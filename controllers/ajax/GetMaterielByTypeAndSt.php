<?php

use models\MaterielModel;

function getMaterielByTypeAndSortiDuStock($type, $sortiDuStockMotif, $materieModel)
{
    $materiels = [];

    if ($sortiDuStockMotif && $type) {
        $state = $sortiDuStockMotif === "disponible" ? NULL : $sortiDuStockMotif;
        $op = $sortiDuStockMotif === "disponible" ? "IS" : "=";
        if ($type === 'all') {
            $materiels = $materieModel->getByQuery([
                "sortie_du_stock" => [
                    "op" => $op,
                    "value" => $state,
                ],
            ]);
        } else {
            $materiels = $materieModel->getByQuery([
                "type" => [
                    "op" => "=",
                    "value" => $type,
                ],
                "sortie_du_stock" => [
                    "op" => $op,
                    "value" => $state,
                ],
            ]);
        }
    }

    // return the response data as an array not an object
    $materiels = array_merge($materiels);
    return $materiels;
}

// create a function to handle the ajax request and return the response data
function materielsAjax($request, $db)
{

    $materielModel = new MaterielModel($db, true);

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $type = $data['type'] ?? null;
    $sortiDuStockMotif = $data['sortiDuStockMotif'] ?? null;

    $materiels = getMaterielByTypeAndSortiDuStock($type, $sortiDuStockMotif, $materielModel);

    // return the response data as an array not an object
    return $materiels;
}

$materiels = materielsAjax($this->request, $this->db);

$response = json_encode($materiels, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $response;
