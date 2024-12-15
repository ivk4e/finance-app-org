<?php 
$user_first_name = $_SESSION['user_first_name'] ?? '';
$user_last_name = $_SESSION['user_last_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';
$user_birthday = $_SESSION['user_date_of_birth'] ?? '';
$user_created_at = $_SESSION['user_created_at'] ?? '';

$user_ip_address = $_SESSION['user_ip_address'] ?? 'Unknown';
$user_last_login = $_SESSION['user_last_login'] ?? 'Never';
$user_device_info = $_SESSION['user_device_info'] ?? 'Unavailable';

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['warning'])) {
    echo '<div class="alert alert-warning" role="alert">' . $_SESSION['warning'] . '</div>';
    unset($_SESSION['warning']);
}

?>

<div>
    <div class="container position-relative">
        <div class="row d-xxl-flex justify-content-xxl-center">
            <div class="col-5 col-sm-5 col-xxl-3"><img class="d-flex ms-auto" width="100" height="80" style="width: 250px;height: 250px;margin-top: 24px;"><button class="btn btn-dark d-flex ms-auto" type="button" style="margin-top: 10px;">Смени снимката</button></div>
            <div class="col-md-6 col-xl-4 col-xxl-3">
                <div>
                    <form class="p-3 p-xl-4" method="post" action="handlers/handlers_settings/handler_update_settings.php" style="padding-top: 24px;">
                        <div class="mb-3"><label class="form-label" for="name">Име</label><input class="form-control" type="text" id="name" name="firstName" value="<?php echo $user_first_name ?>"></div>
                        <div class="mb-3"><label class="form-label" for="name-1">Фамилия</label><input class="form-control" type="text" id="name-1" name="lastName" value="<?php echo $user_last_name ?>"></div>
                        <div class="mb-3"><label class="form-label" for="name-2">Рожден ден</label><input class="form-control" type="date" name="dateOfBirth" value="<?php echo $user_birthday ?>"></div>
                        <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" type="email" id="email" name="email" value="<?php echo $user_email ?>"></div>
                        <div class="mb-3"><label class="form-label" for="email-1">Парола</label><input class="form-control" type="password" name="password"></div>
                        <div class="d-inline-flex mb-3"><label class="form-label" style="margin-right: 10px;">Дата на създаване:</label><label class="form-label"><?php echo $user_created_at ?></label></div>
                        <div class="d-inline-flex mb-3"><label class="form-label" style="margin-right: 65px;">IP адрес:</label><label class="form-label"><?php echo $user_ip_address?></label></div>
                        <div class="d-inline-flex mb-3"><label class="form-label" style="margin-right: 10px;">Последно влизане:</label><label class="form-label"><?php echo $user_last_login ?></label></div>
                        <div class="d-inline-flex mb-3"><label class="form-label" style="margin-right: 65px;">Браузър:</label><label class="form-label"><?php echo $user_device_info ?></label></div>
                        <div class="d-xxl-flex justify-content-xxl-center mb-3"><button class="btn btn-warning" type="submit">Редактирай</button></div>
                        <label class="form-label d-xxl-flex justify-content-xxl-center" style="border-color: rgb(255,15,0);">
                            <em>
                                <span style="color: rgb(255, 15, 0);">
                                    <a href="#" style="text-decoration: none; color: rgb(255, 15, 0);" onclick="showDeleteConfirmation(event);">Изтрий профила</a>
                                </span>
                            </em>
                        </label>

                        <div id="delete-confirmation" style="display: none; margin-top: 20px;">
                            <label class="form-label" for="confirmPassword">Потвърдете паролата си, за да изтриете профила:</label>
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword">
                            <div class="mt-3 d-flex justify-content-center">
                                <button class="btn btn-danger" type="submit" formaction="handlers/handlers_settings/handler_delete_settings.php">Потвърди изтриването</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showDeleteConfirmation(event) {
        event.preventDefault();
        const confirmationDiv = document.getElementById('delete-confirmation');
        confirmationDiv.style.display = 'block';
    }
</script>