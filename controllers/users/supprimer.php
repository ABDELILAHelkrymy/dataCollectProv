<?php

use models\UserModel;

$userModel = new UserModel($this->db);

$id = $this->request->getParam('id');

try {
    $userModel->deleteById($id);
} catch (\Throwable $th) {
    $_SESSION['error'] = 'Erreur lors de la suppression d\'utilisateur';
    header('Location: /users');
    exit();
}

$_SESSION['message'] = 'Utilisateur supprimée avec succès';
header('Location: /users');
