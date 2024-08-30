<?php
$date = date('Y-m-d');
$title = $date . " : إحصاء السكن والسكنى - اليوم";
ob_start();
?>
<div class="container-fluid py-6">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mb-4 text-end">
                <div class="card-header pb-0 mb-3">
                    <div class="row">
                        <h3 class="mb-0">ملأ البيانات الخاصة بإحصاء السكن والسكنى</h3>
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
                                        <input class="form-control" id="list_douar" name="list_douar" type="text"
                                            value="" required>
                                    </div>
                                    <p class="error-prenom text-danger text-xs error-text"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <label for="example-text-input" class="form-control-label">إسم عون
                                            السلطة</label>
                                        <select class="form-select" name="agent_id" required>
                                            <option value="">إختر عون السلطة</option>
                                            <?php foreach ($agents as $agent): ?>
                                                <option value="<?= $agent->getId() ?>">
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
                                        <input class="form-control" name="nbr_menage" type="number" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-end">
                                        <label for="example-text-input" class="form-control-label">عدد الأسر
                                            المحصية</label>
                                        <input class="form-control" name="nbr_famille" type="number" value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit"
                                        class="btn bg-gradient-success text-md w-30 mt-4 mb-0 compte-btn">أضف</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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