<?php

use entities\Data;
use models\DataModel;

use entities\Agent;
use models\AgentModel;


function addData($request, $db)
{
    $viewVars = [
        "message" => null,
        "error" => null,
    ];

    //get date now 
    $date = date('Y-m-d');
    $viewVars['date'] = $date;
    $dataModel = new DataModel($db);
    $agentModel = new AgentModel($db);
    $aal_id = $_SESSION['user']['aal_id'];
    $viewVars['agents'] = $agentModel->getByQuery([
        "aal_id" => [
            "op" => "=",
            "value" => $aal_id,
        ]
    ]);

    $agent = $agentModel->getByQuery([
        "aal_id" => [
            "op" => "=",
            "value" => $aal_id,
        ]
    ]);
    // get all data by agent id
    $allDataOfAal = [];
    foreach ($agent as $ag) {
        $allDataOfAal[] = $dataModel->getByQuery([
            "agent_id" => [
                "op" => "=",
                "value" => $ag->getId(),
            ]
        ]);
    }

    $allfilteredData = [];
    foreach ($allDataOfAal as $data) {
        if ($data) {
            $allfilteredData[] = end($data);
        }
    }

    if ($request->isPost()) {
        $data = new Data($request->getPost());

        $dataNew = $allfilteredData;
        $dataNew = end($dataNew);
        if ($dataNew) {
            $data->setCumulMenage($dataNew->getCumulMenage() + $data->getNbrMenage());
            $data->setCumulFamille($dataNew->getCumulFamille() + $data->getNbrFamille());
        } else {
            $data->setCumulMenage($data->getNbrMenage());
            $data->setCumulFamille($data->getNbrFamille());
        }
        try {
            $dataModel->create($data->toArray());
            $_SESSION["message"] = "تمت الإضافة بنجاح";
            header("Location: /dataCollect");
        } catch (Exception $e) {
            $_SESSION['error'] = "حدث خطأ أثناء الإضافة";
        }
    }

    return $viewVars;

}

$vars = addData($this->request, $this->db);

extract($vars);