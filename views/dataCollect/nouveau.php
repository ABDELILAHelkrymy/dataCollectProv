<?php
$title = "Nouveau compte";
ob_start();
?>
<div class="container-fluid py-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Ajouter compte</p>
                    </div>
                </div> -->
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <p class="text-uppercase text-sm">Informations demande</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group w-50">
                                    <label for="example-text-input" class="form-control-label">Objet de la
                                        demande</label>
                                    <select class="form-select" name="nature_demande"
                                        aria-label="Default select example" required>
                                        <?php
                                        foreach ($natureDemandes as $type) {
                                            ?>
                                            <option value="<?= $type ?>">
                                                <?= $type ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date création
                                        demande</label>
                                    <input class="form-control" type="date" value="" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Par</label>
                                    <input class="form-control" type="text" value=<?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?> disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Numéro</label>
                                    <input class="form-control" type="text" value="" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Status</label>
                                    <input class="form-control" type="text" value="En Cours" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date Status</label>
                                    <input class="form-control" type="date" value="" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Par</label>
                                    <input class="form-control" type="text" value=<?= $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?> disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Référence GALA</label>
                                    <input class="form-control ref_gala" id="ref_gala" type="text" name="ref_gala"
                                        value="">
                                </div>
                                <p class="error-gala text-danger text-xs error-text"></p>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Informations personnelles</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group w-15">
                                    <label for="example-text-input" class="form-control-label">Titre</label>
                                    <select class="form-select select-title" name="titre"
                                        aria-label="Default select example" required>
                                        <?php
                                        foreach ($titres as $t) {
                                            ?>
                                            <option value="<?= $t ?>" id="title-option">
                                                <?= $t ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nom</label>
                                    <input class="form-control" id="nom-compte" name="nom" type="text" value=""
                                        required>
                                </div>
                                <p class="error-name text-danger text-xs error-text"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Prénom</label>
                                    <input class="form-control prenom-compte" id="prenom-compte" name="prenom"
                                        type="text" value="" required>
                                </div>
                                <p class="error-prenom text-danger text-xs error-text"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nom de
                                        naissance</label>
                                    <input class="form-control" name="nom_naissance" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date de
                                        naissance</label>
                                    <input class="form-control date_naissance" id="date_naissance" name="date_naissance"
                                        type="date" value="" required>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Informations professionelles</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nature du
                                        contrat</label>
                                    <select class="form-select" id="nature_contrat" name="nature_contrat"
                                        aria-label="Default select example" required>
                                        <?php
                                        foreach ($natureContrats as $type) {
                                            ?>
                                            <option value="<?= $type ?>">
                                                <?= $type ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date
                                        d'embauche</label>
                                    <input class="form-control" name="date_embauche" type="date" value="" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Site
                                        physique</label>
                                    <select class="form-select site_physique" id="site_physique" name="site_physique"
                                        aria-label="Default select example" required>
                                        <option value="" selected disabled>
                                            selectioner un site
                                        </option>
                                        <?php
                                        foreach ($sites as $site) {
                                            ?>
                                            <option value="<?= $site->getId() ?>" data-centre="<?= $site->getLibelle() ?>">
                                                <?= $site->getLibelle() ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Entité
                                        fonctionnelle</label>
                                    <select id="entitee_fonctionnelle" class="form-select entitee_fonctionnelle"
                                        name="entitee_fonctionnelle" aria-label="Default select example" required>
                                        <option value="" selected disabled>
                                            selectioner un site
                                        </option>
                                        <?php
                                        foreach ($sites as $site) {
                                            if ($site->getLibelle() !== 'Externe') {
                                                ?>
                                                <option value="<?= $site->getId() ?>">
                                                    <?= $site->getLibelle() ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Service</label>
                                    <select class="form-select" id="services" name="service"
                                        aria-label="Default select example" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Fonction</label>
                                    <select class="form-select" id="fonctions" name="fonction"
                                        aria-label="Default select example" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Société
                                        prestataire</label>
                                    <input class="form-control" name="societe_prestataire" type="text" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Date fin</label>
                                    <input class="form-control" name="date_fin" type="date" value="">
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION['userrole'] === 'admin' || $_SESSION['userrole'] === 'super_admin') {
                            ?>

                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Informations Administratives</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        <input class="form-control" name="email" type="email" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">N° de
                                            téléphone portable</label>
                                        <input class="form-control tel" name="tel" type="tel" value="">
                                    </div>
                                    <p class="error-phone text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input text-sm" class="form-control-label">N° de téléphone
                                            interne
                                        </label>
                                        <input class="form-control tel telInterne" name="telInterne" type="tel" value="">
                                    </div>
                                    <p class="error-phone text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">N° de téléphone
                                            externe</label>
                                        <input class="form-control tel telExterne" id="tel" name="telExterne" type="tel"
                                            value="">
                                    </div>
                                    <p class="error-phone text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">ID Neptune</label>
                                        <input class="form-control" id="id_neptune" name="id_neptune" type="text" value=""
                                            required>
                                    </div>
                                    <p class="error-id-neptune text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">User Protea</label>
                                        <input class="form-control" id="user_protea" name="user_protea" type="text" value=""
                                            required>
                                    </div>
                                    <p class="error-user-protea text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mot De Passe
                                            Portea</label>
                                        <input class="form-control" id="mot_de_passe_portea" name="motDePassePortea"
                                            type="text" value="" required>
                                    </div>
                                    <p class="error-password_portea text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mot De Passe session
                                            windows</label>
                                        <input class="form-control" id="mot_de_passe" name="motDePasse" type="text" value=""
                                            required>
                                    </div>
                                    <p class="error-password text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input responsable1" class="form-control-label">Email
                                            responsable</label>
                                        <input class="form-control" name="responsable" type="email" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input responsable2" class="form-control-label">Email
                                            adjoint</label>
                                        <input class="form-control" name="adjoint" type="email" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Applications</label>
                                        <select class="form-select cls_select" id="applications" name="application" disabled
                                            multiple aria-label="multiple select example">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Documents</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Pièce jointe</label>
                                    <input class="form-control" id="file-input" name="pieces_jointe[]" type="file"
                                        multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="file-list" class="list-group"></ul>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Commentaire</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Votre
                                        Commentaire</label>
                                    <textarea class="form-control" name="commentaires" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <button type="submit"
                                    class="btn bg-gradient-primary w-30 mt-4 mb-0 compte-btn">Ajouter</button>
                            </div>

                            <?php
                            if ($_SESSION['userrole'] === 'admin' || $_SESSION['userrole'] === 'super_admin') {
                                ?>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <input class="valide-input" name="statut" type="hidden" value="en cours">
                                    <a href="javascript:;"
                                        class="btn bg-success mt-4 mb-0 compte-btn text-white font-weight-bold text-sm"
                                        data-bs-toggle="modal" data-bs-target="#modal-notification" id="deleteCompte">
                                        Valider la de la demande
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </form>
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
                    <p>Voulez-vous valider la demande ?</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" type="button" class="btn btn-danger valide-btn" data-bs-dismiss="modal">Oui</a>
                <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Non</button>
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

<?php
$content = ob_get_clean();
include_once APP_ROOT . '/public/layout/layout.php';
?>