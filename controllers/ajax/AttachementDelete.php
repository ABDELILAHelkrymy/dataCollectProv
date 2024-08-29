<?php

use models\AttachementModel;

function attachementDelete($request, $db)
{
    $attachementModel = new AttachementModel($db);

    // get id from the request body
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);  // Assuming JSON data

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle invalid JSON format (optional)
        return ['error' => 'Invalid data format'];
    }

    $id = $data['id'] ?? null;
    // delete the attachement
    $attachementModel->deleteById($id);

    return ['success' => 'Attachement deleted successfully'];
}

$compte = attachementDelete($this->request, $this->db);

$data = json_encode($compte, JSON_UNESCAPED_UNICODE);

header('Content-Type: application/json');

echo $data;