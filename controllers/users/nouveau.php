<?php

use entities\User;
use models\UserModel;
use models\RoleModel;


function userNouveau($request, $db)
{
    $viewVars = [];

    $userModel = new UserModel($db);
    $roleModel = new RoleModel($db);

    if ($_SESSION['userrole'] === 'super_admin') {
        $viewVars['roles'] = $roleModel->getByQuery([
            'nom' => [
                'op' => '!=',
                'value' => 'super_admin'
            ],
        ]);
    } else {
        $viewVars['roles'] = $roleModel->getByQuery([
            'nom' => [
                'op' => '=',
                'value' => 'srh'
            ]
        ]);
    }

    if ($request->isPost()) {
        try {
            $params = $request->getPost();
            if ($params['password'] === $params['confirme_password']) {
                $user = new User($request->getPost());

                // user name is the first letter of the first name and the last name
                $user->setPlainPassword($params['password']);
                // verifie si le email existe
                $usersByEmail = $userModel->getByQuery([
                    'email' => [
                        'op' => '=',
                        'value' => $user->getEmail()
                    ],
                ]);
                $usersByUserName = $userModel->getByQuery([
                    'username' => [
                        'op' => '=',
                        'value' => $user->getUsername()
                    ]
                ]);
                if (count($usersByEmail) > 0) {
                    $_SESSION['error'] = 'Cet email existe déjà';
                    header('Location: /users');
                } else if (count($usersByUserName) > 0) {
                    $_SESSION['error'] = 'Ce nom d\'utilisateur existe déjà';
                    header('Location: /users');
                } else {
                    $userModel->create($user->toArray());
                    $_SESSION['message'] = 'utilisateur créé avec succès';
                    header('Location: /users');
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['error'] = 'Erreur lors de la création de l\'utilisateur';
            header('Location: /users');
        }
    }

    return $viewVars;

}

$vars = userNouveau($this->request, $this->db);
extract($vars);

