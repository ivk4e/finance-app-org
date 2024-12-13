<?php
    include 'includes/head.php';

    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
    }
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<body>
    <section class="position-relative py-4 py-xl-5" style="padding-top: 0px;">
        <div class="container" style="margin-top: 0px;">
            <div class="row mb-5" style="margin-top: 0;">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Регистрирай се</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="margin-top: 15px;">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column align-items-center" style="box-shadow: 3px 3px 15px var(--bs-card-border-color);">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4" style="background: linear-gradient(0deg, #564be6, #8f56f4 116%);"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z"></path>
                                </svg></div>
                            <form class="text-center" method="POST" action="../handlers/handler_registration.php">
                                <div class="mb-3"><input class="form-control" type="text" id="firstName" name="firstName" placeholder="First Name" required=""></div>
                                <div class="mb-3"><input class="form-control" type="text" id="lastName" name="lastName" placeholder="Last Name" required=""></div>
                                <div class="mb-3"><input class="form-control" type="date" id="dateOfBirth" name="dateOfBirth"></div>
                                <div class="mb-3"><input class="form-control" type="email" id="email" name="email" placeholder="Email"></div>
                                <div class="mb-3"><input class="form-control" type="password" id="password" name="password" placeholder="Password" autocomplete="off"></div>
                                <div class="mb-3"><input class="form-control" type="password" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password"></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" style="background: linear-gradient(69deg, #564be6, #8f56f4);">Регистрация</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Simple-Slider-swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>

</html>