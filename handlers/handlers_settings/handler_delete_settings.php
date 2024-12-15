<?php 
require_once('../../db.php');

session_start();

if (empty($_POST['confirmPassword'])) {
    $_SESSION['error'] = 'Моля, въведете парола за потвърждение.';
    header('Location: ../../?page=profile-settings');
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT password_hash, is_deleted
        FROM users
        WHERE user_id = :user_id
    ');
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = 'Потребителят не съществува.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    if ($user['is_deleted'] == 0) {
        $_SESSION['error'] = 'Профилът вече е изтрит.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    if (!password_verify($_POST['confirmPassword'], $user['password_hash'])) {
        $_SESSION['error'] = 'Невалидна парола за потвърждение.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    $stmt = $pdo->prepare('
        UPDATE users
        SET is_deleted = 0
        WHERE user_id = :user_id
    ');
    $stmt->execute([':user_id' => $_SESSION['user_id']]);

    session_destroy();
    header('Location: ../../');
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = 'Възникна грешка при изтриването на профила. Моля, опитайте отново.';
    header('Location: ../../?page=profile-settings');
    exit;
}
?>
