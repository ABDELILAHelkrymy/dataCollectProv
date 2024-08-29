<?php
if ($_SESSION['userrole'] === 'super_admin') {
    $title = "Utilisateurs";
} else {
    $title = "Utilisateurs RH";
}
ob_start();
?>
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">
                                <?= $title ?>
                            </h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-primary mb-0" href="/users/nouveau">
                                <i class='bx bxs-user-rectangle'></i>&nbsp;&nbsp;Ajouter</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nom d'utilisateur</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nom</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Prénom</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <?php
                                    if ($_SESSION['userrole'] === 'super_admin') {
                                        ?>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role</th>
                                        <?php
                                    }
                                    ?>
                                    <!-- <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Role</th> -->
                                    <?php
                                    if ($_SESSION['userrole'] == 'admin' || $_SESSION['userrole'] === 'super_admin') {
                                        ?>
                                        <th class="text-secondary opacity-7"></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $user) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <h6 class="mb-0 text-sm">
                                                    <?= $user->getUsername() ?>
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <h6 class="mb-0 text-sm">
                                                    <?= $user->getFirstname() ?>
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <?= $user->getLastname() ?>
                                            </p>
                                        </td>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <?= $user->getEmail() ?>
                                            </p>

                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <?= $user->getRoleId() ?>
                                            </p>
                                        </td>
                                        <?php
                                        if ($_SESSION['userrole'] == 'admin' || $_SESSION['userrole'] === 'super_admin') {
                                            ?>
                                            <td class="align-middle">
                                                <a href="<?php echo '/users/modifier/' . $user->getId(); ?>"
                                                    class="text-info font-weight-bold text-md mx-2" id="editCompte">
                                                    <i class='bx bxs-edit'></i>
                                                </a>
                                                <a href="javascript:;" class="text-danger font-weight-bold text-sm"
                                                    data-bs-toggle="modal" data-bs-target="#modal-notification"
                                                    id="deleteCompte">
                                                    <i class='ni ni-basket'></i>
                                                </a>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
    aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="py-3 text-center">
                    <i class="ni ni-bell-55 ni-3x"></i>
                    <h4 class="text-gradient text-danger mt-4">Attention !</h4>
                    <p>la suppression de ce user entraînera la perte permanente de toutes ses données. Confirmez-vous
                        la suppression ?</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?php
                if (isset($user) && $user->getId() !== null) {
                    echo '/users/supprimer/' . $user->getId();
                }
                ?>" type="button" class="btn btn-danger">Supprimer</a>
                <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">fermer</button>
            </div>
        </div>
    </div>
</div>
<div class="message-info" data-message="<?php
if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
    echo $_SESSION["message"];
    $messgaeClass = 'bg-gradient-success';
    unset($_SESSION["message"]);
} else if (isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
    echo $_SESSION["error"];
    $messgaeClass = 'bg-gradient-danger';
    unset($_SESSION["error"]);
} else {
    echo '';
}
?>"></div>
<div class="message-info-toast toast position-fixed align-items-center text-white <?= $messgaeClass ?> top-1 end-1 p-1"
    style="z-index: 11">
    <div class="d-flex">
        <div class="toast-body">

        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php
include_once APP_ROOT . '/public/layout/layout.php';
?>