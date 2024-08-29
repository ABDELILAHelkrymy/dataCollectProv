<?php

use models\MaterielModel;
use services\HabFiler;
use entities\Materiel;

$materiel = new Materiel();

function uploadMaterielCsvFile($request, $db)
{
    $materielModel = new MaterielModel($db, true);

    // get data from post request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    // if the data is not a valid json
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }
    // get the first element of the array
    $keys = array_shift($data);
    // create an array to store the materiels
    $materiels = [];
    // loop through the data array
    foreach ($data as $i => $row) {
        // create an array to store the materiel
        $materiel = [];
        // loop through the keys array
        foreach ($keys as $j => $key) {
            // add the key and the value to the materiel array
            $materiel[$key] = $row[$j];
        }
        // add the materiel to the materiels array
        $materiels[] = $materiel;
    }
    // loop through the materiels array
    foreach ($materiels as $materiel) {
        // transform the materiel column to string if not
        // convert the date from serial number to date
        $materiel['date_signalement'] = date('Y-m-d', ($materiel['date_signalement'] - 25569) * 86400);

        $materiel['date_signalement'] = (string) $materiel['date_signalement'];

        $materiel['date_restitution'] = date('Y-m-d', ($materiel['date_restitution'] - 25569) * 86400);

        $materiel['date_restitution'] = (string) $materiel['date_restitution'];
        $materiel['teletravail'] = (string) $materiel['teletravail'];
        // create the materiel in the database

        // get materiel by serie

        $findMateriel = $materielModel->getByQuery([
            "serie" => [
                "op" => "LIKE",
                "value" => $materiel['serie'],
            ],
        ]);

        // if materiel exist not create
        if ($findMateriel) {
            continue;
        }

        // create materiel

        $materiel = new Materiel($materiel);

        $materielModel->create($materiel->toArray());
    }
    // return the materiels array
    return $materiels;
    // decode rowData
}

// Call the function with the uploaded file and database connection
$materiels = uploadMaterielCsvFile($this->request, $this->db);

// Encode the response as JSON
$response = json_encode($materiels, JSON_UNESCAPED_UNICODE);

// Set the response content type
header('Content-Type: application/json');

// Output the response
echo $response;
