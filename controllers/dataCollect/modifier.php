<?php 

use entities\Data;
use models\DataModel;

use entities\Agent;
use models\AgentModel;


function modifierData($request, $db){
    $viewVars = [
        "message" => null,
        "error" => null,
    ];
    $agentModel = new AgentModel($db);
    $aal_id = $_SESSION['user']['aal_id'];
    $viewVars["aal_id"] = $aal_id;
    $viewVars['agents'] = $agentModel->getByQuery([
        "aal_id" => [
            "op" => "=",
            "value" => $aal_id,
        ]
    ]);

    $dataModel = new DataModel($db);
    $data = $dataModel->getById($request->getParams()["id"]);
    $viewVars["data"] = $data;

    if ($request->isPost()) {
        $data = new Data($request->getPost());
        $data->setId($request->getParams()["id"]);
        $dataModel->updateById($data->toArray());
        $viewVars["message"] = "Data updated successfully";
        header("Location: /dataCollect/details/" . $_SESSION['user']['aal_id']);
    }

    return $viewVars;
}

$vars = modifierData($this->request, $this->db);
extract($vars);

