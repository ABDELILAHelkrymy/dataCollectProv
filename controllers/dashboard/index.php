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
$datas = $dataModel->getByQueryDate("created_at", $date ?? $today);
$datasForCumul = $dataModel->getByQueryDateLessThan("created_at", $date ? $date . " 23:59:59" : $today . " 23:59:59");


$agentModel = new AgentModel($this->db);
$agents = $agentModel->getAll();
// populate districts into aaLs
foreach ($aals as $aal) {
    $district = $districtModel->getById($aal->getDistrictId());
    $aal->setDistrictId($district);
}

// var_dump($aals);
// populate aaLs into agents
foreach ($agents as $agent) {
    $aale = $aalModel->getById($agent->getAalId());
    $agent->setAalId($aale);
    foreach ($datas as $data) {
        if ($data->getAgentId() === $agent->getId()) {
            $data->setAgentId($agent->getAalId());
        }
    }
    foreach ($datasForCumul as $data) {
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

// create new array with all id as key to calculate total of nbr menage and nbr famille

$newData1 = [];
foreach ($aals as $aal) {
    $cumulMenager = 0;
    $cumulFamille = 0;
    foreach ($datasForCumul as $data) {
        if ($data->getAgentId()->getId() === $aal->getId()) {
            $cumulMenager += $data->getNbrMenage();
            $cumulFamille += $data->getNbrFamille();
        }
    }
    $newData1[$aal->getId()] = [
        "cumulMenage" => $cumulMenager,
        "cumulFamille" => $cumulFamille
    ];
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
            $cumulMenager += $newData1[$allId]['cumulMenage'] ?? 0;
            $cumulFamille += $newData1[$allId]['cumulFamille'] ?? 0;
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