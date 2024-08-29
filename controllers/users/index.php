<?php

use models\UserModel;
use models\RoleModel;

$userModel = new UserModel($this->db);
$roleModel = new RoleModel($this->db);

$query = $this->request->get("q");

if ($query) {
    $users = $userModel->getByQueryOr([
        "firstname" => [
            "op" => "LIKE",
            "value" => '%' . $query . '%',
        ],
        "lastname" => [
            "op" => "LIKE",
            "value" => '%' . $query . '%',
        ],
        "username" => [
            "op" => "LIKE",
            "value" => '%' . $query . '%',
        ],
    ]);
} else if ($_SESSION['userrole'] === 'super_admin') {
    $users = $userModel->getByQuery([
        'role_id' => [
            'op' => '!=',
            'value' => 0
        ]
    ]);
} else {
    $users = $userModel->getByQuery([
        'role_id' => [
            'op' => '=',
            'value' => 2
        ]
    ]);
}

$roles = $roleModel->getAll();

// populate roles in users

foreach ($users as $user) {
    foreach ($roles as $role) {
        if ($user->getRoleId() == $role->getId()) {
            $user->setRoleId($role->getNom());
        }
    }
}