<?php
require_once('../db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $dateOfBirth = $_POST['dateOfBirth'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($repeatPassword)) {
        header('Location: ../pages/registration.php?error=Not valid data.');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../pages/registration.php?error=Invalid email.');
        exit;
    }

    if (strlen($password) < 6) {
        header('Location: ../pages/registration.php?error=Password must be at least 6 characters long.');
        exit;
    }

    if ($password !== $repeatPassword) {
        header('Location: ../pages/registration.php?error=Passwords do not match.');
        exit;
    }

    $dateNow = date('Y-m-d');
    if ($dateOfBirth > $dateNow) {
        header('Location: ../pages/registration.php?error=Invalid date of birth.');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_ARGON2I);

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            header('Location: ../pages/registration.php?error=Email already exists.');
            exit;
        }
        
        $createdAt = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, date_of_birth, email, password_hash, created_at) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$firstName, $lastName, $dateOfBirth, $email, $hashed_password, $createdAt]);

        $_SESSION['success'] = 'Регистрацията е успешна. Моля, влезте.';
        header('Location: ../pages/login.php');
        exit;
    } catch (PDOException $e) {
        header('Location: ../pages/registration.php?error=Database error.');
        exit;
    }

} else {
    header('Location: ../pages/registration.php');
    exit;
}