<?php 

use entities\Data;
use models\DataModel;

use entities\Agent;
use models\AgentModel;

use entities\Aal;
use models\AalModel;

use entities\District;
use models\DistrictModel;


function dataList ($request, $db) {
    $id = $request->getParam('id');
    $viewVars = [
        "message" => null,
        "error" => null,
    ];

    $dataModel = new DataModel($db);
    $agentModel = new AgentModel($db);
    $aalModel = new AalModel($db);
    $districtModel = new DistrictModel($db);
    $aal_id = $_SESSION['user']['aal_id'];


    $agent = $agentModel->getByQuery([
        "aal_id" => [
            "op" => "=",
            "value" => $aal_id,
        ]
    ]);
    $viewVars['agents'] = $agent;

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

    $viewVars['allDataOfAal'] = $allDataOfAal;

    $currentAal = $aalModel->getById($aal_id);
    $viewVars['aalcurent'] = $currentAal;

    $currentDistrict = $districtModel->getById($currentAal->getDistrictId());

    $viewVars['districtcurent'] = $currentDistrict;


    return $viewVars;
}

$vars = dataList($this->request, $this->db);
extract($vars);