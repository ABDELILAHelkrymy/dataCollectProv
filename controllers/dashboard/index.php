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
$datasForCumul = $dataModel->getByQueryDateLessThan("created_at", $date ?? $today);

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
    foreach ($datasForCumul as $data) {
        if ($data->getAgentId() === $agent->getId()) {
            $data->setAgentId($agent->getAalId());
        }
    }
}

$newData = [];
foreach ($aals as $aal) {
    // Initialize sums for the current agent
    $newData[$aal->getId()] = [
        'nbrMenage' => 0,
        'cumulMenage' => 0,
        'nbrFamille' => 0,
        'cumulFamille' => 0,
    ];

    foreach ($datas as $data) {
        // Check if the agentId matches the aal id
        if ($data->getAgentId()->getId() === $aal->getId()) {
            // Accumulate the values for this agent
            $newData[$aal->getId()]['nbrMenage'] += $data->getNbrMenage();
            $newData[$aal->getId()]['cumulMenage'] = $data->getCumulMenage();
            $newData[$aal->getId()]['nbrFamille'] += $data->getNbrFamille();
            $newData[$aal->getId()]['cumulFamille'] = $data->getCumulFamille();
            $newData[$aal->getId()]['observations'][] = $data->getObservations();
        }
    }
}

// create an aray with nbr familles total provisoire aal id as key
$nbrFamilleTotalProvisoire = [
    // create a static list with 25 data
    3706, 5773, 6447, 5923, 4886, 5807, 7447, 0, 644, 5433, 2239, 9282, 7367, 8000, 3250, 8000, 5000, 2000, 2250, 4750, 1500, 5000, 5750, 4500, 2500
];

$nbrFamilleTotalProvisoireByAal = [];
foreach ($aals as $aalId) {
    $nbrFamilleTotalProvisoireByAal[$aalId->getId()] = $nbrFamilleTotalProvisoire[$aalId->getId()-1];
}


$newData1 = [];

foreach ($aals as $alle) {
    $nbrMenage = 0;
    $nbrFamille = 0;
    $cumulMenager = 0;
    $cumulFamille = 0;
    $percentage = 0;
    foreach ($datasForCumul as $data) {
        if ($data->getAgentId()->getId() === $alle->getId()) {
            $cumulMenager += $data->getNbrMenage();
            $cumulFamille += $data->getNbrFamille();
        }
    }
    if ($nbrFamilleTotalProvisoireByAal[$alle->getId()] != 0) {
        $percentage = number_format(($cumulFamille / $nbrFamilleTotalProvisoireByAal[$alle->getId()]) * 100, 2);
    } else {
        $percentage = 0;
    }
    $newData1[$alle->getId()] = [
        "cumulMenage" => $cumulMenager,
        "cumulFamille" => $cumulFamille,
        "percentage" => $percentage
    ];
}

// create new array with district id as key to calculate total of cumul menager and cumul famille
$newData2 = [];
foreach ($districts as $district) {
    $nbrMenage = 0;
    $nbrFamille = 0;
    $cumulMenager = 0;
    $cumulFamille = 0;
    $cumulFamilleTotalProvisoire = 0;
    foreach ($aals as $aal) {
        if ($aal->getDistrictId()->getId() === $district->getId()) {
            $allId = $aal->getId() ?? null;
            $nbrMenage += $newData[$allId]['nbrMenage'] ?? 0;
            $nbrFamille += $newData[$allId]['nbrFamille'] ?? 0;
            $cumulMenager += $newData1[$allId]['cumulMenage'] ?? 0;
            $cumulFamille += $newData1[$allId]['cumulFamille'] ?? 0;
            $cumulFamilleTotalProvisoire += $nbrFamilleTotalProvisoireByAal[$allId] ?? 0;
        }
    }
    $cumulePourcentage = 0;
    if ($cumulFamilleTotalProvisoire != 0) {
        $cumulePourcentage = number_format(($cumulFamille / $cumulFamilleTotalProvisoire) * 100, 2);
    } else {
        $cumulePourcentage = 0;
    }
    $newData2[$district->getId()] = [
        "nbrMenage" => $nbrMenage,
        "nbrFamille" => $nbrFamille,
        "cumulMenager" => $cumulMenager,
        "cumulFamille" => $cumulFamille,
        "cumulFamilleTotalProvisoire" => $cumulFamilleTotalProvisoire,
        "cumulePourcentage" => $cumulePourcentage
    ];
}

// create new array to calculate total of cumul menager and cumul famille and total of nbr menage and nbr famille
$total = [
    "nbrMenage" => 0,
    "nbrFamille" => 0,
    "cumulMenager" => 0,
    "cumulFamille" => 0,
    "nbrFamilleTotalProvisoire" => 0,
    "cumulePourcentageTotal" => 0
];
foreach ($newData2 as $data) {
    $total["nbrMenage"] += $data["nbrMenage"];
    $total["nbrFamille"] += $data["nbrFamille"];
    $total["cumulMenager"] += $data["cumulMenager"];
    $total["cumulFamille"] += $data["cumulFamille"];
    $total["nbrFamilleTotalProvisoire"] += $data["cumulFamilleTotalProvisoire"];
    $total["cumulePourcentageTotal"] = number_format(($total["cumulFamille"] / $total["nbrFamilleTotalProvisoire"]) * 100, 2);
}