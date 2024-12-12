<?php
    include '../includes/sidebar.php';

    $is_main_page = false;
    include '../includes/head.php';
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<body>
    <div style="display: block;">
        <div id="main-content" style="margin-bottom: 100px;">
            <div class="container py-4 py-xl-5" style="padding-bottom: 48px;height: 160px;">
                <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-end justify-content-sm-end justify-content-md-end justify-content-lg-end justify-content-xl-end justify-content-xxl-end" style="display: inline-flex;margin-bottom: 10px;">
                    <div class="d-xxl-flex me-auto justify-content-xxl-start"><a href="finance-goals.html" style="text-decoration:none;">
                            <p class="d-xxl-flex" style="color: rgb(45,29,232);">&lt;- Назад</p>
                        </a></div><button class="toggle-sidebar" type="button" data-bs-target="#offcanvas-menu" data-bs-toggle="offcanvas" data-bs-backdrop="true" style="padding:14px 11px 1px 5px;padding-top:15px;padding-bottom:1px;padding-right:11px;width:30px;height:30px;background:url('../assets/img/list.svg') center / contain no-repeat;border-style:none;"><i class="bi bi-list"></i></button><label class="form-label" style="margin-bottom: 0px;margin-top: 3px;">Меню</label>
                </div>
                <div class="row mb-5">
                    <div class="col-md-8 col-xl-6 text-center mx-auto">
                        <h2 style="display: inline-flex;">Редактиране на финансова цел</h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <section class="position-relative py-4 py-xl-5">
                                <div class="container">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6 col-xl-4">
                                            <div class="card mb-5">
                                                <div class="card-body d-flex flex-column align-items-center">
                                                    <form class="text-center" method="post">
                                                        <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Тип цел</label>
                                                            <div class="dropdown"><button class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="width: 207px;text-align: right;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);border-right-color: rgb(222,226,230);"></button>
                                                                <div class="dropdown-menu"><a class="dropdown-item" href="#">First Item</a><a class="dropdown-item" href="#">Second Item</a><a class="dropdown-item" href="#">Third Item</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Целева дата</label><input class="form-control" type="date" style="border-color: rgb(222,226,230);color: var(--bs-secondary);"></div>
                                                        <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Наименование</label><input class="form-control" type="text" style="text-align: left;"></div>
                                                        <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Целева сума</label><input class="form-control" type="text"></div>
                                                        <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Спестена сума</label><input class="form-control" type="text"></div>
                                                        <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Статус</label>
                                                            <div class="dropdown"><button class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="width: 207px;text-align: right;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);border-right-color: rgb(222,226,230);"></button>
                                                                <div class="dropdown-menu"><a class="dropdown-item" href="#">First Item</a><a class="dropdown-item" href="#">Second Item</a><a class="dropdown-item" href="#">Third Item</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3"><button class="btn btn-warning d-block w-100" type="submit">Запазване</button>
                                                            <div>
                                                                <p style="font-style: italic;color: rgb(255,15,0);margin-top: 10px;">Изтриване на цел</p>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include '../includes/footer.php';
    ?>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>