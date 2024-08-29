<?php

use models\FonctionApplicationModel;
use models\ApplicationModel;

function getApplicationsByFonctionId($fonctionId, $functionapplicationModel, $appilcationModel)
{
    $applicationsIds = $functionapplicationModel->getByQuery([
        "fonction_id" => [
            "op" => "=",
            "value" => $fonctionId,
        ],
    ]);
    $applications = [];

    foreach ($applicationsIds as $applicationId) {
        $application = $appilcationModel->getById($applicationId['application_id']);
        $applications[] = $application;
    }
    return $applications;
}

// create a function to handle the ajax request and return the response data
function applicationsAjax($request, $db)
{
    $functionapplicationModel = new FonctionApplicationModel($db, true);
    $appilcationModel = new ApplicationModel($db, true);

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $fonctionId = $data['fonctionId'] ?? null;

    $applications = getApplicationsByFonctionId($fonctionId, $functionapplicationModel, $appilcationModel);

    // return the response data as an array not an object
    return $applications;
}


$applications = applicationsAjax($this->request, $this->db);

$response = json_encode($applications, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $response;