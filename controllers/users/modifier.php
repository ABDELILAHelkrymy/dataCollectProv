<?php

use entities\User;
use models\UserModel;
use models\RoleModel;


function ModifierNouveau($request, $db)
{
    $id = $request->getParam('id');
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

    $user = $userModel->getById($id);

    if ($request->isPost()) {
        try {
            $params = $request->getPost();
            if ($params['password'] === $params['confirme_password']) {
                $user = new User($request->getPost());

                // user name is the first letter of the first name and the last name
                $user->setId($id);
                $userById = $userModel->getById($id);
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
                if ($userById->getEmail() !== $user->getEmail() && count($usersByEmail) > 0) {
                    $_SESSION['error'] = 'Cet email existe déjà';
                    header('Location: /users');
                    exit;
                }
                if ($userById->getUsername() !== $user->getUsername() && count($usersByUserName) > 0) {
                    $_SESSION['error'] = 'Ce nom d\'utilisateur existe déjà';
                    header('Location: /users');
                    exit;
                }
                if ($user->getPassword() !== '') {
                    $user->setPlainPassword($params['password']);
                } else {
                    $user->setPassword($userById->getPassword());
                }
                $userModel->updateById($user->toArray());
                $_SESSION['message'] = 'utilisateur modifié avec succès';
                header('Location: /users');
            }
        } catch (\Throwable $th) {
            $_SESSION['error'] = 'Erreur lors de la modification de l\'utilisateur';
            header('Location: /users');
        }
    } else {
        $viewVars['user'] = $user;
    }

    return $viewVars;

}

$vars = ModifierNouveau($this->request, $this->db);
extract($vars);

