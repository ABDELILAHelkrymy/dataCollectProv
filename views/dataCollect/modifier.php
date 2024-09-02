<?php
$date = date('Y-m-d');
$title = $date . " : الإحصاء العام للسكان والسكنى - اليوم";
ob_start();
?>
<div class="container-fluid py-6">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo '/dataCollect/details/' . $aal_id; ?>">
                                <h6 class="mb-0"><i class='bx bx-left-arrow-alt'></i> رجوع</h6>  
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <h3 class="mb-0">تعديل البيانات الخاصة الإحصاء العام للسكان والسكنى</h3>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <label for="example-text-input"
                                            class="form-control-label text-xl-center">الدواوير / الأحياء
                                            المحصية</label>
                                        <input class="form-control text-end" dir="rtl" id="list_douar" name="list_douar"
                                            type="text" value="<?= $data->getListDouar() ?>" required>
                                    </div>
                                    <p class="error-prenom text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input text-end" class="form-control-label">إسم عون
                                            السلطة</label>
                                        <select class="form-select"  name="agent_id" required>
                                            <option value="" selected disabled>إختر عون السلطة</option>
                                            <?php foreach ($agents as $agent): ?>
                                                <option 
                                                    <?php if ($data->getAgentId() == $agent->getId()) echo 'selected'; ?>
                                                    value="<?= $agent->getId() ?>">
                                                    <?= $agent->getFirstname() . ' ' . $agent->getLastname() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <label for="example-text-input" class="form-control-label">عدد المساكن
                                            المحصية</label>
                                        <input class="form-control text-end" name="nbr_menage" type="number" value="<?= $data->getNbrMenage() ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <label for="example-text-input" class="form-control-label">عدد الأسر
                                            المحصية</label>
                                        <input class="form-control text-end" name="nbr_famille" type="number" value="<?= $data->getNbrFamille() ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-end">
                                        <label for="example-text-input" class="form-control-label">ملاحظات</label>
                                        <textarea class="form-control text-end" dir="rtl" name="observations" rows="3"><?= $data->getObservations() ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-start">
                                <div class="col-md-6">
                                    <button type="submit"
                                        class="btn bg-gradient-success text-md w-30 mt-4 mb-0 compte-btn">تعديل</button>
                                </div>
                            </div>
                        </form>
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