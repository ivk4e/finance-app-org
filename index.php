<?php
    require_once 'handlers/router.php';

    $page = $_GET['page'] ?? 'hello';
    $action = $_GET['action'] ?? 'view';

    $pageDetails = getPageDetails($page, $action);

    $page_path = $pageDetails['page_path'];
    $page_title = $pageDetails['page_title'];
    $show_back_button = $pageDetails['show_back_button'];

    $is_main_page = true;

    include './pages/includes/sidebar.php';
    include './pages/includes/head.php';
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<body>
    <div style="display: block;">
        <div id="main-content" style="margin-bottom: 100px;">
            <div class="container py-4 py-xl-5">
                <div class="d-sm-flex d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-sm-end justify-content-xxl-end" style="display: inline-flex;margin-bottom: 10px;">
                     <!-- Back Button -->
                     <?php if ($show_back_button): ?>
                            <div class="d-xxl-flex me-auto justify-content-xxl-start">
                                <a href="?page=<?php echo $page ?>" style="text-decoration: none;">
                                    <p class="d-xxl-flex" style="color: rgb(45,29,232);">&lt;- Назад</p>
                                </a>
                            </div>
                    <?php endif; ?>

                     <!-- Button Menu -->
                    <button class="toggle-sidebar" type="button" data-bs-target="#offcanvas-menu" data-bs-toggle="offcanvas" data-bs-backdrop="true" style="padding:14px 11px 1px 5px;padding-top:15px;padding-bottom:1px;padding-right:11px;width:30px;height:30px;background:url('assets/img/list.svg') center / contain no-repeat;border-style:none;"><i class="bi bi-list"></i></button><label class="form-label" style="margin-bottom: 0px;margin-top: 3px;">Меню</label>
                </div>
                
                <!-- Page Title -->
                <div class="row mb-5">
                    <div class="col-md-8 col-xl-6 text-center mx-auto">
                        <h2 style="display: inline-flex;"><?php echo $page_title ?></h2>
                    </div>
                </div>

                <!-- Page Content -->
                <?php
                    if (file_exists($page_path)) {
                        include $page_path;
                    } else {
                        include '404.php';
                    }
                ?>
        </div>
    </div>
    <?php
        include './pages/includes/footer.php';
    ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>