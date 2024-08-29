<?php

use entities\Compte;
use models\CompteModel;
use services\HabMailer;
use models\ServiceModel;
use models\FonctionModel;
use models\AttachementModel;
use entities\Attachement;
use models\SiteModel;

use core\Mailer;
use services\HabFiler;



function compteUpdateStatus($request, $db)
{
    $compteModel = new CompteModel($db, true);
    $fonctionModel = new FonctionModel($db);
    $attachmentModel = new AttachementModel($db);

    $serviceModel = new ServiceModel($db);
    $siteModel = new SiteModel($db);

    // get id from the request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    // if (json_last_error() !== JSON_ERROR_NONE) {
    //     // Handle invalid JSON format (optional)
    //     return ['error' => 'Invalid data format'];
    // }

    $id = $_POST['id'] ?? $data['id'] ?? null;
    $statut = $_POST['statut'] ?? $data['statut'] ?? null;
    $responsable1 = $_POST['responsable'] ?? null;
    $responsable2 = $_POST['adjoint'] ?? null;

    if ($statut === "validée") {
        //get the attachments
        $pjs = $_FILES['pieces_jointe'] ?? null;
        if ($pjs) {
            foreach ($pjs['name'] as $key => $fileName) {
                // Get file properties for each file
                $file = [
                    'name' => $pjs['name'][$key],
                    'type' => $pjs['type'][$key],
                    'tmp_name' => $pjs['tmp_name'][$key],
                    'error' => $pjs['error'][$key],
                    'size' => $pjs['size'][$key]
                ];

                // Process the file if there were no errors
                if ($file['error'] === 0) {
                    $compteName = $request->post('nom') . '_' . $request->post('prenom');

                    // Call your existing uploadFile function
                    $pjPath = HabFiler::uploadFile($file, $compteName);

                    $attachement = new Attachement();
                    $attachement->setFileName($pjPath);
                    $attachement->setFilePath($pjPath);
                    $attachement->setCreatedBy($_SESSION['user']['id']);
                    $attachement->setCompteId($id);

                    $attachmentModel->create($attachement->toArray());
                } else {
                    $_SESSION['error'] = 'Erreur';
                }
            }
        }
    }

    // update the status
    if ($statut === "validée" || $statut === "annulée" || $statut === "en cours") {
        // convert the $_POST to Compte object
        $d = json_decode($_POST["compte"], true);
        $compte = new Compte($d);
        $compte->setId($id);
        $compte->setStatut($statut);
        $compte->setStatutChangedBy($_SESSION['user']['id']);
        $compte->setStatutChangedAt(date('Y-m-d H:i:s'));
        $compte->setDemandeChangeStatut("");
    } else {
        $compte = $compteModel->getById($id);
        $compte = new Compte($compte);
        $compte->setDemandeChangeStatut($statut);
    }

    $compte->setId($id);
    $compteModel->updateById($compte->toArray());

    //populate service property by function id
    $fonctionId = $compte->getFonction();
    $fonction = $fonctionModel->getById($fonctionId);
    $serviceId = $fonction->getService();
    $service = $serviceModel->getById($serviceId);
    $serviceName = $service->getNom();

     // populate entiteeFontionalle property by site name
    $EntiteeFonctionelleId = $compte->getEntiteeFonctionnelle();
    $EntiteeFonctionelleSite = $siteModel->getById($EntiteeFonctionelleId);
    if ($EntiteeFonctionelleSite) {
        $compte->setEntiteeFonctionnelle($EntiteeFonctionelleSite->getLibelle());
    }

    if ($statut != "en cours" || $statut != "annulée") {
        $email = $compte->getEmail();
        $action = null;
        if ($statut === "validée") {
            $mode = HabMailer::COMPTE_VALIDATION;
            if ($email) {
                $to[] = $email;
            }
            if ($responsable1) {
                $to[] = $responsable1;
            }
            if ($responsable2) {
                $to[] = $responsable2;
            }
        } else {
            $mode = HabMailer::COMPTE_CREATION;
            $action = $statut;
        }
        $to = HabMailer::getMainRecipients($mode);
        $cc = HabMailer::getCCRecipients($mode);
        $subject = HabMailer::getSubject($mode, $compte, $action, null);
        $body = HabMailer::getBody($mode, $compte, $serviceName, $action, null);
        $attachments = isset($pjPath) && $pjPath ? [APP_ROOT . $pjPath] : [];

        $mailOptions = compact('to', 'cc', 'subject', 'body', 'attachments', 'mode');

        try {
            Mailer::send($mailOptions);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de l\'envoi du mail';
        }

    }
    return ['success' => 'Compte status updated successfully'];
}
$compte = compteUpdateStatus($this->request, $this->db);

$data = json_encode($compte, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $data;