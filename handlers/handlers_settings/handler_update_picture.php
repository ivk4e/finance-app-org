<?php
require_once('../../db.php');

session_start();

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    $_SESSION['error'] = 'Не сте влезли в системата.';
    header('Location: ../../?page=profile-settings');
    exit;
}

if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
    $fileName = $_FILES['profilePicture']['name'];
    $fileSize = $_FILES['profilePicture']['size'];
    $fileType = $_FILES['profilePicture']['type'];

    // Проверка за допустим тип на файла
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedMimeTypes)) {
        $_SESSION['error'] = 'Невалиден формат на файла. Моля, качете JPEG, PNG или GIF.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    // Създаване на уникално име на файла
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = 'profile_' . $userId . '.' . $fileExtension;

    // Задаване на пътя за качване
    $uploadDir = '../../uploads/profile_pictures/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $destPath = $uploadDir . $newFileName;

    // Преместване на файла
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        try {
            // Актуализиране на профилната снимка в базата данни
            $stmt = $pdo->prepare('
                UPDATE users 
                SET picture = :picture 
                WHERE user_id = :user_id
            ');
            $stmt->execute([
                ':picture' => $newFileName,
                ':user_id' => $userId
            ]);

            $_SESSION['success'] = 'Снимката на профила е успешно обновена.';
            header('Location: ../../?page=profile-settings');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Грешка при записване на снимката в базата данни.';
            header('Location: ../../?page=profile-settings');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Грешка при качване на файла.';
        header('Location: ../../?page=profile-settings');
        exit;
    }
} else {
    $_SESSION['error'] = 'Моля, качете снимка.';
    header('Location: ../../?page=profile-settings');
    exit;
}
?>
