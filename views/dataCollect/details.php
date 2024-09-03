<?php
$title = "تفاصيل البيانات";
ob_start();
?>
<div class="container-fluid py-6">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row mb-3">
                        <a href="<?php echo '/dataCollect'?>">
                            <h6 class="mb-0"><i class='bx bx-left-arrow-alt'></i> رجوع</h6>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">
                                <?= $districtcurent->getName() . ' - ' . $aalcurent->getName() ?>
                            </h6>
                        </div>
                        <div class="col-6 text-end">
                            <h5>
                                لائحة السكان والسكنى المحصاة
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive has-scroll">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary opacity-7 center"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        data-sort="douar">
                                        لائحة الدواوير / الأحياء
                                        
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        data-sort="dateEmbauche">
                                        عدد المساكن
                                        
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        data-sort="sitePhysique">
                                        عدد الأسر
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        data-sort="nom">
                                        اسم العون 
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        data-sort="nom">
                                        التاريخ 
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($allDataOfAal as $data) : ?>
                                <?php foreach ($data as $d) : ?>
                                <tr></tr>
                                    <td data-key="douar" class="align-middle center">
                                        <div class="d-flex px-2 py-1 center">
                                            <a href="<?php echo '/dataCollect/modifier/' . $d->getId(); ?>"
                                                class="">
                                                <i class="bx bx-edit text-success"></i>  
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm font-weight-bold mb-0 text-center"><?= $d->getListDouar() ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm font-weight-bold mb-0 text-center"><?= $d->getNbrMenage() ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm font-weight-bold mb-0 text-center"><?= $d->getNbrFamille() ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm font-weight-bold mb-0 text-center"><?= $agents[$d->getAgentId()]->getFirstname() . ' ' . $agents[$d->getAgentId()]->getLastname() ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-sm font-weight-bold mb-0 text-center"><?= date('Y - m - d', strtotime($d->getCreatedAt())) ?></p>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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