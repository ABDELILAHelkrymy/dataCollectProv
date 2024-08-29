<?php

use models\CompteModel;
use models\SiteModel;

function getCompteById($compteId, $compteModel)
{
    $compte = $compteModel->getById($compteId);

    // return the response data as an array not an object
    $compte = array_merge($compte);
    return $compte;
}

function getSiteById($siteId, $siteModel)
{
    $site = $siteModel->getById($siteId);

    // return the response data as an array not an object
    $site = array_merge($site);
    return $site;
}

// create a compte to handle the ajax request and return the response data
function compteAjax($request, $db)
{
    $compteModel = new CompteModel($db, true);

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $compteId = $data['id'] ?? null;

    $compte = getCompteById($compteId, $compteModel);

    $siteModel = new SiteModel($db, true);

    $site = getSiteById($compte['site_physique'], $siteModel);

    $compte['site_physique'] = $site['libelle'];

    // return the response data as an array not an object
    return $compte;
}


$compte = compteAjax($this->request, $this->db);

$response = json_encode($compte, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $response;