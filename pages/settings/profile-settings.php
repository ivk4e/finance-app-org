<?php 

$user_id = $_SESSION['user_id'] ?? '';
$user_first_name = $_SESSION['user_first_name'] ?? '';
$user_last_name = $_SESSION['user_last_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';
$user_birthday = $_SESSION['user_date_of_birth'] ?? '';
$user_created_at = $_SESSION['user_created_at'] ?? '';

$user_ip_address = $_SESSION['user_ip_address'] ?? 'Unknown';
$user_last_login = $_SESSION['user_last_login'] ?? 'Never';
$user_device_info = $_SESSION['user_device_info'] ?? 'Unavailable';

$user_picture = '';

if ($user_id) {
    require_once('db.php'); // Връзка към базата

    $stmt = $pdo->prepare('SELECT picture FROM users WHERE user_id = :user_id');
    $stmt->execute([':user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user_picture = $result['picture']; // Вземаме снимката
    }
}

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

            <div class="col-5 col-sm-5 col-xxl-3">
               
                <img class="d-flex ms-auto" 
                    src="<?php echo !empty($user_picture) ? 'uploads/profile_pictures/' . htmlspecialchars($user_picture) : 'uploads/default.png'; ?>" 
                    style="width: 250px; height: 250px; margin-top: 24px; object-fit: cover; border-radius: 50%;">
                <form class="w-100 mt-3" method="post" action="handlers/handlers_settings/handler_update_picture.php" enctype="multipart/form-data">
                    <div class="mb-3 d-flex justify-content-end">
                        <input class="form-control w-75" type="file" id="profilePicture" name="profilePicture" accept="image/*">
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-warning" type="submit">Запази снимката</button>
                    </div>
                </form>
            </div>
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