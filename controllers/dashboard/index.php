<?php

use models\AalModel;
use models\DistrictModel;

use models\DataModel;
use models\AgentModel;


$districtModel = new DistrictModel($this->db);
$districts = $districtModel->getAll();

$aalModel = new AalModel($this->db);
$aals = $aalModel->getAll();

$dataModel = new DataModel($this->db);
$datas = $dataModel->getAll();

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

foreach ($aals as $all) {
    foreach ($datas as $data) {
        if ($data->getAgentId()->getId() === $all->getId()) {
            var_dump($data->getNbrMenage());
        }
    }
}