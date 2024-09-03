<?php
$title = "Tableau de bord";
ob_start();
?>
<div class="container-fluid py-4">
    <div class="row mt-4 justify-content-center">
        <div class="col-md-12 col-lg-10 mb-lg-0 mb-4">
            <div class="card ">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Suivi du nombre de ménages et de logements recensés.</h6>
                        <div class="form-group d-flex">
                            <input class="form-control date_collect" name="date" type="date"
                                value="<?= $date ?? date("Y-m-d") ?>">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 text-center">
                                            AAL / CAIDAT</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 text-center">
                                            Nombre total de ménages prévisionnel estimatif</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 text-center">
                                            Nombre de ménages recensées</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 text-center">
                                            Cumul</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 text-center">
                                            Pourcentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $currentDistrict = null;
                                    $currentDistrictId = null;
                                    foreach ($aals as $aal):
                                        $allId = $aal->getId() ?? null;
                                        if ($currentDistrict !== $aal->getDistrictId()->getName()) {
                                            if ($currentDistrict !== null) {
                                                // Print the total for the previous district
                                                ?>
                                                <tr class="<?='bg-dark'.$currentDistrictId?>">
                                                    <td>
                                                        <div class="d-flex px-2 py-1 justify-content-center">
                                                            <div class="text-md  text-bold font-weight-bold mb-0 text-center">
                                                                <h6 class="mb-0 text-white "><?= $currentDistrict ?> (Total)
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 class="text-md text-white  text-bold font-weight-bold mb-0 text-center">
                                                            <?= $newData2[$currentDistrictId]["cumulFamilleTotalProvisoire"] ?? 0 ?>
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <h5 class="text-md text-white  text-bold font-weight-bold mb-0 text-center">
                                                            <?= $newData2[$currentDistrictId]["nbrFamille"] ?? 0 ?>
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <h5 class="text-md text-white  text-bold font-weight-bold mb-0 text-center">
                                                            <?= $newData2[$currentDistrictId]["cumulFamille"] ?? 0 ?>
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <h5 class="text-md text-white  text-bold font-weight-bold mb-0 text-center">
                                                            <?= $newData2[$currentDistrictId]["cumulePourcentage"] ?? 0 ?>%
                                                        </h5>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            $currentDistrict = $aal->getDistrictId()->getName();
                                            $currentDistrictId = $aal->getDistrictId()->getId();
                                        }
                                        ?>
                                        <tr>
                                            <td class="<?='bg'.$currentDistrictId?>">
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= $aal->getName() ?></h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            <?= $aal->getDistrictId()->getName() ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 text-center">
                                                    <?= $nbrFamilleTotalProvisoireByAal[$allId] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 text-center">
                                                    <?= $newData[$allId]['nbrFamille'] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 text-center">
                                                    <?= $newData1[$allId]['cumulFamille'] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 text-center">
                                                    <?= $newData1[$allId]['percentage'] ?? 0 ?>%
                                                </p>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php
                                    // Print the total for the last district
                                    if ($currentDistrict !== null) {
                                        ?>
                                        <tr class="<?='bg-dark'.$currentDistrictId?>">
                                            <td>
                                                <div class="d-flex px-2 py-1 justify-content-center">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-white  text-sm"><?= $currentDistrict ?> (Total)</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-md text-white  font-weight-bold mb-0 text-center">
                                                    <?= $newData2[$currentDistrictId]["cumulFamilleTotalProvisoire"] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-md text-white  font-weight-bold mb-0 text-center">
                                                    <?= $newData2[$currentDistrictId]["nbrFamille"] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-md  text-white  font-weight-bold mb-0 text-center">
                                                    <?= $newData2[$currentDistrictId]["cumulFamille"] ?? 0 ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-md text-white  font-weight-bold mb-0 text-center">
                                                    <?= $newData2[$currentDistrictId]["cumulePourcentage"] ?? 0 ?>%
                                                </p>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <!-- add total -->
                                    <tr class="bg-gradient-faded-info">
                                        <td>
                                            <div class="d-flex px-2 py-1 justify-content-center">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-md text-white text-bold text-uppercase">Total
                                                        Province</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-md text-white font-weight-bold mb-0 text-center">
                                                <?= $total["nbrFamilleTotalProvisoire"] ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-md text-white font-weight-bold mb-0 text-center">
                                                <?= $total["nbrFamille"] ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-md text-white font-weight-bold mb-0 text-center">
                                                <?= $total["cumulFamille"] ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-md text-white font-weight-bold mb-0 text-center">
                                                <?= $total["cumulePourcentageTotal"] ?>%
                                            </p>
                                        </td>
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