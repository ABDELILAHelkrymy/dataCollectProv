<?php

use models\ServiceModel;
use models\SiteModel;

function getServicesByCity($sitePhysique, $serviceModel, $entiteeFonctionnelle = null)
{
    $cities = [];
    if ($sitePhysique && $entiteeFonctionnelle) {
        $cities = [$sitePhysique['ville'], $entiteeFonctionnelle['ville']];
    } elseif ($sitePhysique) {
        $cities = [$sitePhysique['ville']];
    } elseif ($entiteeFonctionnelle) {
        $cities = [$entiteeFonctionnelle['ville']];
    }

    $isParis = in_array("Paris", $cities);
    $isExterne = in_array("Externe", $cities);
    $services = [];

    if ($isExterne) {
        $services = $serviceModel->getAll();
    } else {
        $services = $serviceModel->getByQuery([
            "nom" => [
                "op" => $isParis ? "<>" : "=",
                "value" => "CGEA",
            ],
        ]);
    }

    // return the response data as an array not an object
    $services = array_merge($services);
    return $services;
}

// create a function to handle the ajax request and return the response data
function servicesAjax($request, $db)
{

    $sitesModel = new SiteModel($db, true);
    $serviceModel = new ServiceModel($db, true);

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $sitePhysiqueID = $data['sitePhysique'] ?? null;
    $entiteeFonctionnelleID = $data['entiteeFonctionnelle'] ?? null;

    $sitePhysique = $sitesModel->getById($sitePhysiqueID);
    $entiteeFonctionnelle = $sitesModel->getById($entiteeFonctionnelleID);

    $services = getServicesByCity($sitePhysique, $serviceModel, $entiteeFonctionnelle);

    // return the response data as an array not an object
    return $services;
}

$services = servicesAjax($this->request, $this->db);

$response = json_encode($services, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $response;
