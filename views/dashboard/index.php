<?php
$title = "Tableau de bord";
ob_start();
?>
<div class="container-fluid py-4">
    <div class="row mt-4 justify-content-center">
        <div class="col-md-8 mb-lg-0 mb-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Tableau de Bord</h6>
                        <div class="form-group d-flex">
                            <input class="form-control" name="date" type="date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">AAL / CAIDAT</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nombre de ménagère recensés</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Cumul</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nombre de famille recensés</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Cumul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $currentDistrict = null;
                                    $districtTotals = [];

                                    foreach ($aals as $aal) : 
                                        if ($currentDistrict !== $aal->getDistrictId()) {
                                            if ($currentDistrict !== null) {
                                                // Print the total for the previous district
                                                ?>
                                                <tr class="bg-success">
                                                    <td>
                                                        <div class="d-flex px-2 py-1 justify-content-center">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm"><?= $currentDistrict ?> (Total)</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-md text-white text-bold font-weight-bold mb-0">1</p></td>
                                                    <td><p class="text-md text-white text-bold font-weight-bold mb-0">1</p></td>
                                                    <td><p class="text-md text-white text-bold font-weight-bold mb-0">1</p></td>
                                                    <td><p class="text-md text-white text-bold font-weight-bold mb-0">1</p></td>
                                                </tr>
                                                <?php
                                            }
                                            $currentDistrict = $aal->getDistrictId();
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $aal->getName() ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?= $aal->getDistrictId() ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><p class="text-sm font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-sm font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-sm font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-sm font-weight-bold mb-0">1</p></td>
                                    </tr>
                                    <?php endforeach; ?>

                                    <?php
                                    // Print the total for the last district
                                    if ($currentDistrict !== null) {
                                        ?>
                                        <tr class="bg-success">
                                            <td>
                                                <div class="d-flex px-2 py-1 justify-content-center">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= $currentDistrict ?> (Total)</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                            <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                            <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                            <td><p class="text-md text-whitefont-weight-bold mb-0">1</p></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <!-- add total -->
                                    <tr class="bg-gradient-faded-info">
                                        <td>
                                            <div class="d-flex px-2 py-1 justify-content-center">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-md text-white text-bold text-uppercase">Total Province</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                        <td><p class="text-md text-white font-weight-bold mb-0">1</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php
include_once APP_ROOT . '/public/layout/layout.php';
?>