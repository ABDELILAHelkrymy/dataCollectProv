<?php

use models\UserModel;
use models\RoleModel;

if ($this->request->isPost()) {
    $error = '';
    $username = $this->request->post('username');
    $password = $this->request->post('password');
    if ($username && $password) {
        $userModel = new UserModel($this->db);
        $user = $userModel->getOneBy("username", $username);
        if ($user) {
            if ($user->verifyPassword($password)) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['userid'] = $user->getId();
                $_SESSION['user'] = $user->toArray();
                $roleModel = new RoleModel($this->db);
                $role = $roleModel->getById($user->getRoleId());
                if ($role) {
                    $_SESSION['userrole'] = $role->getNom();
                } else {
                    $error = 'Rôle invalide';
                }

                if (!$error) {
                    echo 'redirecting';
                    var_dump($_SESSION);
                    header('Location: /');
                } else {
                    $error = 'error exists';
                    echo $error;
                }
            } else {
                $error = 'Mot de passe invalide';
            }
        } else {
            $error = 'Nom d\'utilisateur invalide';
        }
    } else {
        $error = 'Le nom d\'utilisateur et le mot de passe sont requis';
    }
}
