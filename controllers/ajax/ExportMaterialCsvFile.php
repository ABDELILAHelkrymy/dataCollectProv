<?php

use models\MaterielModel;
use entities\Materiel;
use models\CompteModel;
use models\SiteModel;

require_once APP_ROOT . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$materiel = new Materiel();

function exportMaterialCsvFile($request, $db)
{
    $materielModel = new MaterielModel($db, true);
    $sitesModel = new SiteModel($db, true);

    // get data from post request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // if the data is not a valid json
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Invalid data format'];
    }

    // get the first element of the array
    $keys = $data['materielsIds'];

    // get materiels with ids in the keys array
    $materiels = [];
    foreach ($keys as $key) {
        $materiel = $materielModel->getById($key);
        if ($materiel != null) {
            $materiels[] = $materiel;
        }
    }

    // create a new PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set the first row with the column names
    $sheet->setCellValue('A1', 'Id');
    $sheet->setCellValue('B1', 'Centre');
    $sheet->setCellValue('C1', 'Type');
    $sheet->setCellValue('D1', 'Marque');
    $sheet->setCellValue('E1', 'Numero de Serie');
    $sheet->setCellValue('F1', 'Compte');
    $sheet->setCellValue('G1', 'Tele Travail');
    $sheet->setCellValue('H1', 'Date restitution matériel');
    $sheet->setCellValue('I1', 'Lieu restitution');
    $sheet->setCellValue('J1', 'Date signalement');

    // populate the rows with the materiels data
    $row = 2;
    foreach ($materiels as $materiel) {
        $materiel = new Materiel($materiel);
        // get the compte name
        $compteModel = new CompteModel($db);
        if ($materiel->getIdCompte() != null) {
            $compte = $compteModel->getById($materiel->getIdCompte());
        }
        $siteCompte = null;
        if (isset($compte) && $compte != null) {
            if (is_array($compte)) {
                $siteCompte = $sitesModel->getById($compte['site_physique']);
            } else {
                $siteCompte = $sitesModel->getById($compte->getSitePhysique());
            }
        }
        if ($siteCompte && is_array($siteCompte)) {
            $compte->setSitePhysique($siteCompte['libelle']);
        } elseif ($siteCompte) {
            $compte->setSitePhysique($siteCompte->getLibelle());
        }
        $siteMateriel = $sitesModel->getById($materiel->getLieuRestitution());
        if (isset($siteMateriel)) {
            if (is_array($siteMateriel)) {
                $materiel->setLieuRestitution($siteMateriel['libelle']);
            } else {
                $materiel->setLieuRestitution($siteMateriel->getLibelle());
            }
        }
        if (isset($compte) && $compte != null && is_object($compte)) {
            $materiel->setIdCompte($compte->toArray());
        } else {
            $materiel->setIdCompte([]);
        }

        $sheet->setCellValue("A$row", $materiel->getId());
        $sheet->setCellValue("B$row", $materiel->getIdCompte()["site_physique"] ?? '');
        $sheet->setCellValue("C$row", $materiel->getType());
        $sheet->setCellValue("D$row", $materiel->getMarque());
        $sheet->setCellValue("E$row", $materiel->getSerie());
        if ($materiel->getIdCompte() != null) {
            $compte = $materiel->getIdCompte();
            $name = $compte["nom"] ?? '';
            $surname = $compte["prenom"] ?? '';
            $sheet->setCellValue("F$row", "$name $surname");
        } else {
            $sheet->setCellValue("F$row", '');
        }
        $sheet->setCellValue("G$row", $materiel->getTeletravail());
        $sheet->setCellValue("H$row", $materiel->getDateRestitution());
        $sheet->setCellValue("I$row", $materiel->getLieuRestitution());
        $sheet->setCellValue("J$row", $materiel->getDateSignalement());
        $row++;
    }

    // create a new Xlsx object
    $writer = new Xlsx($spreadsheet);

    // set the headers to download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="materiels.xlsx"');
    header('Cache-Control: max-age=0');

    // write the file to the output
    $writer->save('php://output');
    exit;
}

// Assuming $this->request and $this->db are correctly set
exportMaterialCsvFile($this->request, $this->db);
