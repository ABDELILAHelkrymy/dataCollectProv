<?php

use models\AalModel;
use models\DistrictModel;

use models\DataModel;
use models\AgentModel;

$date = $this->request->get("q");

$districtModel = new DistrictModel($this->db);
$districts = $districtModel->getAll();

$aalModel = new AalModel($this->db);
$aals = $aalModel->getAll();
$dataModel = new DataModel($this->db);

$today = date("Y-m-d");
$datas = $dataModel->getByQueryDateLessThan("created_at", $date ?? $today);

$agentModel = new AgentModel($this->db);
$agents = $agentModel->getAll();
// populate districts into aaLs
foreach ($aals as $aal) {
    $district = $districtModel->getById($aal->getDistrictId());
    $aal->setDistrictId($district);
}


// populate aaLs into agents
foreach ($agents as $agent) {
    $aale = $aalModel->getById($agent->getAalId());
    $agent->setAalId($aale);
    foreach ($datas as $data) {
        if ($data->getAgentId() === $agent->getId()) {
            $data->setAgentId($agent->getAalId());
        }
    }
}

$newData = [];
foreach ($aals as $alle) {
    foreach ($datas as $data) {
        if ($data->getAgentId()->getId() === $alle->getId()) {
            $newData[$alle->getId()] = $data;
        }
    }
}

// create new array with district id as key to calculate total of cumul menager and cumul famille
$newData2 = [];
foreach ($districts as $district) {
    $nbrMenage = 0;
    $nbrFamille = 0;
    $cumulMenager = 0;
    $cumulFamille = 0;
    foreach ($aals as $aal) {
        if ($aal->getDistrictId()->getId() === $district->getId()) {
            $allId = $aal->getId() ?? null;
            $nbrMenage += $newData[$allId]->nbrMenage ?? 0;
            $nbrFamille += $newData[$allId]->nbrFamille ?? 0;
            $cumulMenager += $newData[$allId]->cumulMenage ?? 0;
            $cumulFamille += $newData[$allId]->cumulFamille ?? 0;
        }
    }
    $newData2[$district->getId()] = [
        "nbrMenage" => $nbrMenage,
        "nbrFamille" => $nbrFamille,
        "cumulMenager" => $cumulMenager,
        "cumulFamille" => $cumulFamille
    ];
}

// create new array to calculate total of cumul menager and cumul famille and total of nbr menage and nbr famille
$total = [
    "nbrMenage" => 0,
    "nbrFamille" => 0,
    "cumulMenager" => 0,
    "cumulFamille" => 0
];
foreach ($newData2 as $data) {
    $total["nbrMenage"] += $data["nbrMenage"];
    $total["nbrFamille"] += $data["nbrFamille"];
    $total["cumulMenager"] += $data["cumulMenager"];
    $total["cumulFamille"] += $data["cumulFamille"];
}