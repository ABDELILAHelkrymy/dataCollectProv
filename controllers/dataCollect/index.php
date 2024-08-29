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


    $viewVars['agents'] = $agentModel->getAll();

    if ($request->isPost()) {
        $data = new Data($request->getPost());

        try {
            $dataModel->create($data->toArray());
            $viewVars['message'] = "تمت الإضافة بنجاح";
            header("Location: /dataCollect");
        } catch (Exception $e) {
            $viewVars['error'] = "حدث خطأ أثناء الإضافة";
        }
    }

    return $viewVars;

}

$vars = addData($this->request, $this->db);

extract($vars);