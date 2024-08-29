<?php
ob_start();
?>
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="d-flex justify-content-center w-full">
                                <img src="/assets/img/logos/login.png" alt="logo" width="220" height="120">
                            </div>
                            <div class="card-header bg-gray-100  pb-0 text-center">
                                <h4 class="font-weight-bolder">Bienvenue</h4>
                                <p>Enter votre nom d'utilisateur et mot de passe</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Nom d'utilisateur" aria-label="Email">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Mot de passe">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Connexion</button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-danger error-password" role="alert">
                                    <?php echo isset($error) ? $error : ''; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column align-items-center">
                        <div class="position-relative bg-gradient-secondary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                            <span class="mask bg-gradient-secondary opacity-2"></span>
                        <div class="text-center">
                        <img src="/assets/img/logos/prov-larache-logo.png" alt="logo" width="340" height="160">
                        </div>
                        <br/><br/>
                        <h1 class="font-weight-bolder text-white">Courriers</h1>
                        <h4 class="font-weight-bolder text-light">Outil de Gestion et d'archivage des courriers du provine de larache.</h4>
                        <br/><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $content = ob_get_clean(); ?>
<?php
include_once APP_ROOT . '/public/layout/layout.php';
?>