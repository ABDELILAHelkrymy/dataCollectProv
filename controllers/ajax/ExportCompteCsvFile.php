<?php

use models\CompteModel;
use entities\Compte;
use models\SiteModel;
use models\FonctionModel;
use models\UserModel;

require_once APP_ROOT . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


function exportCompteCsvFile($request, $db)
{
    // get the CompteModel
    $compteModel = new CompteModel($db);

    // get data from post request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // if the data is not a valid json
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Invalid data format'];
    }

    $type = $data['type'];
    $dateStart = $data['startDate'];
    $dateEnd = $data['endDate'];
    $comptes = [];

    if ($type == 'all') {
        $comptes = $compteModel->getAll();
    } else {
        if ($dateEnd) { {
                $comptes = $compteModel->getByQuery([
                    "created_at" => [
                        "op" => ">=",
                        "value" => $dateStart,
                    ],
                    "created_at" => [
                        "op" => "<=",
                        "value" => $dateEnd,
                    ],
                ]);
            }
        } else {
            $comptes = $compteModel->getByQuery([
                "created_at" => [
                    "op" => ">=",
                    "value" => $dateStart,
                ],
            ]);
        }
    }

    $siteModel = new SiteModel($db);
    $sites = $siteModel->getAll();
    $functionModel = new FonctionModel($db);
    // sort by createdAt
    if (isset($comptes) && $comptes != null) {
        usort($comptes, function ($a, $b) {
            return $b->getCreatedAt() <=> $a->getCreatedAt();
        });
    }

    $userModel = new UserModel($db);

    // populate site and function name in comptes array , return new array
    function populateSiteNames($comptes, $userModel, $sites, $functionModel)
    {
        foreach ($comptes as $compte) {
            foreach ($sites as $site) {
                if ($compte->getSitePhysique() == $site->getId()) {
                    $compte->setSitePhysique($site->getLibelle());
                }
                if ($compte->getEntiteeFonctionnelle() == $site->getId()) {
                    $compte->setEntiteeFonctionnelle($site->getLibelle());
                }
            }
            $compte->setFonction($functionModel->getById($compte->getFonction())->getNom());
            // get the first letter of the nom and prenom of user from session
            $auteur = $userModel->getById($compte->getCreatedBy());
            $avatar = $auteur->getFirstname() . " " . $auteur->getLastname();
            $compte->setCreatedBy($avatar);
            $dateCreatedAt = date_create($compte->getCreatedAt());
            $compte->setCreatedAt($dateCreatedAt->format('d/m/Y'));
            if ($compte->getStatutChangedAt() !== null) {
                $compte->setStatutChangedAt(date_create($compte->getStatutChangedAt())->format('d/m/Y'));
            }

            $dateEmbauche = date_create($compte->getDateEmbauche());
            $compte->setDateEmbauche($dateEmbauche->format('d/m/Y'));
        }
        return $comptes;
    }

    $comptes = populateSiteNames($comptes, $userModel, $sites, $functionModel);


    // create a new PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set the first row with the column names
    $sheet->setCellValue('A1', 'NUMERO');
    $sheet->setCellValue('B1', 'DATE DEMANDE');
    $sheet->setCellValue('C1', 'DATE EMBAUCHE');
    $sheet->setCellValue('D1', 'CENTRE / EXTERNE');
    $sheet->setCellValue('E1', 'COMPTE');
    $sheet->setCellValue('F1', 'STATUT');
    $sheet->setCellValue('G1', 'DATE STATUT');
    $sheet->setCellValue('H1', 'OBJET DEMANDE');
    $sheet->setCellValue('I1', 'AUTEUR');
    $sheet->setCellValue('J1', 'REFERENCE GALA');


    // populate the rows with the materiels data
    $row = 2;
    foreach ($comptes as $compte) {
        $compte = new Compte($compte);

        $sheet->setCellValue('A' . $row, $compte->getNumeroCompte());
        $sheet->setCellValue('B' . $row, $compte->getCreatedAt());
        $sheet->setCellValue('C' . $row, $compte->getDateEmbauche());
        $sheet->setCellValue('D' . $row, $compte->getSitePhysique());
        $sheet->setCellValue('E' . $row, $compte->getPrenom() . ' ' . $compte->getNom());
        $sheet->setCellValue('F' . $row, $compte->getStatut());
        $sheet->setCellValue('G' . $row, $compte->getStatutChangedAt());
        $sheet->setCellValue('H' . $row, $compte->getNatureDemande());
        $sheet->setCellValue('I' . $row, $compte->getCreatedBy());
        $sheet->setCellValue('J' . $row, $compte->getRefGala());
        $row++;
    }

    // create a new Xlsx object
    $writer = new Xlsx($spreadsheet);

    // set the headers to download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="comptes.xlsx"');
    header('Cache-Control: max-age=0');

    // write the file to the output
    $writer->save('php://output');
    exit;
}

// Assuming $this->request and $this->db are correctly set
exportCompteCsvFile($this->request, $this->db);
