<?php
if ($_SESSION['userrole'] === 'super_admin') {
    $title = "Nouveau Utilisateur";
} else {
    $title = "Nouveau Utilisateur RH";
}
ob_start();
?>
<div class="container-fluid py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <p class="text-uppercase text-sm">Informations d'utilisateur
                            <?php if ($_SESSION['userrole'] === 'admin')
                                echo "RH"; ?>
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Role</label>
                                    <select class="form-select select-title" name="role_id" id="type-select" required
                                        aria-label="Default select example">
                                        <?php
                                        foreach ($roles as $role) {
                                            ?>
                                            <option <?php
                                            if ($role->getId() === $user->getRoleId()) {
                                                echo 'selected';
                                            }
                                            ?>
                                                value="<?= $role->getId() ?>">
                                                <?= $role->getNom() ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nom</label>
                                    <input class="form-control" name="firstname" type="text"
                                        value="<?= $user->getFirstname() ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Prénom</label>
                                    <input class="form-control" name="lastname" type="text"
                                        value="<?= $user->getLastname() ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nom d'utilisateur</label>
                                    <input class="form-control" name="username" type="text"
                                        value="<?= $user->getUsername() ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email</label>
                                    <input class="form-control" name="email" type="email"
                                        value="<?= $user->getEmail() ?>" required>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Mot de passe</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">mot de passe</label>
                                    <input class="form-control" id="password" name="password" type="password" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Confirmer mot de
                                        passe</label>
                                    <input class="form-control" id="confirme_password" name="confirme_password"
                                        type="password" value="">
                                </div>
                            </div>
                            <!-- display error -->
                            <div class="col-md-12">
                                <div class="text-sm text-danger error-password" role="alert">

                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <button id="user-btn" type="submit"
                                    class="btn bg-gradient-primary w-30 mt-4 mb-0">Modifier</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include_once APP_ROOT . '/public/layout/layout.php';
?>