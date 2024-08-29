<?php

use models\FonctionModel;

function getFunctionsByServiceId($serviceId, $functionModel)
{
    $functions = $functionModel->getByQuery([
        "service" => [
            "op" => "=",
            "value" => $serviceId,
        ],
    ]);

    // return the response data as an array not an object
    $functions = array_merge($functions);
    return $functions;
}

// create a function to handle the ajax request and return the response data
function functionsAjax($request, $db)
{
    $functionModel = new FonctionModel($db, true);

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $serviceId = $data['serviceId'] ?? null;

    $functions = getFunctionsByServiceId($serviceId, $functionModel);

    // return the response data as an array not an object
    return $functions;
}


$functions = functionsAjax($this->request, $this->db);

$response = json_encode($functions, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $response;