<?php
$title = "Courriers Arrivée";
ob_start();
?>
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Comptes</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-primary mb-0" href="/comptes/nouveau">
                                <i class='bx bx-user-plus'></i>&nbsp;&nbsp;Ajouter</a>
                            <a class="btn bg-gradient-primary mb-0 export-compte" data-bs-toggle="modal"
                                data-bs-target="#modal-notification" href="javascript:;">
                                <i class='bx bxs-file-export'></i>&nbsp;&nbsp;Exporter CSV</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary opacity-7"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="numeroCompte">
                                        Numéro <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="createdAt">
                                        Date Demande <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="dateEmbauche">
                                        Date d&#39;embauche <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="sitePhysique">
                                        Centre / Externe <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="compte">
                                        Compte <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="status">
                                        Status <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="dateStatus">
                                        Date Status <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        data-sort="natureContrat">
                                        Objet Demande <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        data-sort="createdBy">
                                        Auteur <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        data-sort="refGala">
                                        Référence GALA <i class='bx bx-sort-alt-2 sort-icon'></i>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            
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
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exporter CSV</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group input-export-csv">
                        <div class="d-flex my-3">
                            <h6 class="mb-0">Exporter toutes les demandes</h6>
                            <div class="form-check form-switch ps-0 ms-auto my-auto">
                                <input class="form-check-input mt-1 ms-auto export-compte export-all" type="checkbox"
                                    name="all" id="navbarFixed" value="all">
                            </div>
                        </div>
                        <div class="d-flex my-3">
                            <h6 class="mb-0">Exporter les demandes par date</h6>
                            <div class="form-check form-switch ps-0 ms-auto my-auto">
                                <input class="form-check-input mt-1 ms-auto export-compte export-by-date"
                                    type="checkbox" name="byDate" id="navbarFixed" value="byDate">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between my-3 form-dates d-none">
                            <div class="col-5">
                                <label for="" class="form-control-label">Date début</label>
                                <input type="date" class="form-control date-start" placeholder="Date de début"
                                    name="date-start" required>
                            </div>
                            <div class="col-5">
                                <label for="" class="form-control-label">Date fin (optionnel)</label>
                                <input type="date" name="date-end" class="form-control date-end"
                                    placeholder="Date de fin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success export-compte-btn" data-bs-dismiss="modal">
                    Exporter
                </button>
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