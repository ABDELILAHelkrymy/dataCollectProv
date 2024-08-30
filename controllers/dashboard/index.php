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
if($date) {
    $datas = $dataModel->getByQueryDate("created_at", $date);
} else {
    $datas = $dataModel->getByQueryDate("created_at", date("Y-m-d"));
}

$agentModel = new AgentModel($this->db);
$agents = $agentModel->getAll();

// populate districts into aaLs
foreach ($aals as $aal) {
    $district = $districtModel->getById($aal->getDistrictId());
    $aal->setDistrictId($district->getName());
}

// populate aaLs into agents
foreach ($agents as $agent) {
    $aal = $aalModel->getById($agent->getAalId());
    $agent->setAalId($aal);
    foreach ($datas as $data) {
        if ($data->getAgentId() === $agent->getId()) {
            $data->setAgentId($agent->getAalId());
        }
    }
}

$newData = [];
foreach ($aals as $all) {
    foreach ($datas as $data) {
        if ($data->getAgentId()->getId() === $all->getId()) {
            // make new array with aalId as key
            $newData[$all->getId()] = $data;
        }
    }
}

// create new array with district as key and sum of data as value
$districtTotals = [];
foreach ($aals as $aal) {
    $allId = $aal->getId() ?? null;
    if (!isset($districtTotals[$aal->getDistrictId()])) {
        $districtTotals[$aal->getDistrictId()] = [
            "nbrMenage" => 0,
            "cumulMenage" => 0,
            "nbrFamille" => 0,
            "cumulFamille" => 0,
        ];
    }
    $districtTotals[$aal->getDistrictId()]["nbrMenage"] += $newData[$allId]->nbrMenage ?? 0;
    $districtTotals[$aal->getDistrictId()]["cumulMenage"] += $newData[$allId]->cumulMenage ?? 0;
    $districtTotals[$aal->getDistrictId()]["nbrFamille"] += $newData[$allId]->nbrFamille ?? 0;
    $districtTotals[$aal->getDistrictId()]["cumulFamille"] += $newData[$allId]->cumulFamille ?? 0;
}