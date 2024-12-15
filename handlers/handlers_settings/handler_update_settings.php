<?php
require_once('../../db.php');

try {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $dateOfBirth = date('Y-m-d', strtotime($_POST['dateOfBirth']));
    $newPassword = trim($_POST['password']);

    if (empty($firstName) || empty($lastName) || empty($email) || empty($dateOfBirth)) {
        $_SESSION['error'] = 'Всички полета са задължителни.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    // Проверка за валиден email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Въведете валиден email.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    // Проверка дали имейлът е зает от друг потребител
    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && $user['user_id'] !== $_SESSION['user_id']) {
        $_SESSION['error'] = 'Email адресът е зает.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    // Проверка дали данните са променени
    $stmt = $pdo->prepare('SELECT first_name, last_name, email, date_of_birth FROM users WHERE user_id = :user_id');
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $currentUser = $stmt->fetch();

    if (
        $firstName === trim($currentUser['first_name']) &&
        $lastName === trim($currentUser['last_name']) &&
        $email === trim($currentUser['email']) &&
        $dateOfBirth === date('Y-m-d', strtotime($currentUser['date_of_birth'])) &&
        empty($newPassword)
    ) {
        $_SESSION['warning'] = 'Няма направени промени.';
        header('Location: ../../?page=profile-settings');
        exit;
    }

    // Обновяване на основната информация
    $stmt = $pdo->prepare('
        UPDATE users
        SET 
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            date_of_birth = :date_of_birth
        WHERE user_id = :user_id
    ');
    $stmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':email' => $email,
        ':date_of_birth' => $dateOfBirth,
        ':user_id' => $_SESSION['user_id']
    ]);

    // Проверка и обновяване на паролата
    if (!empty($newPassword)) {
        $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Обновяване на паролата
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE users SET password_hash = :password WHERE user_id = :user_id');
        $stmt->execute([
            ':password' => $hashedPassword,
            ':user_id' => $_SESSION['user_id']
        ]);
    }

    $_SESSION['user_first_name'] = $firstName;
    $_SESSION['user_last_name'] = $lastName;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_date_of_birth'] = $dateOfBirth;

    $_SESSION['success'] = 'Профилът е успешно обновен.';
    header('Location: ../../?page=profile-settings');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = 'Профилът е неуспешно обновен: ' . $e->getMessage();
    header('Location: ../../?page=profile-settings');
    exit;
}
?>
