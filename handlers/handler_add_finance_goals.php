<?php 
require_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal_type_id = $_POST['type_id'] ?? null;
    $targetDate = $_POST['targetDate'] ?? null;
    $goalName = $_POST['goalName'] ?? null;
    $targetAmount = $_POST['targetAmount'] ?? null;

    if (empty($goal_type_id) || empty($targetDate) || empty($goalName) || empty($targetAmount)) {
        $_SESSION['error'] = 'Всички полета са задължителни.';
        header('Location: ../?page=finance-goals&action=add');
        exit;
    }

    if (!is_numeric($targetAmount) || $targetAmount < 0) {
        $_SESSION['error'] = 'Въведете валидна целева сума.';
        header('Location: ../?page=finance-goals&action=add');
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;

    if (empty($userId)) {
        $_SESSION['error'] = 'Невалиден потребител.';
        header('Location: ../?page=finance-goals&action=add');
        exit;
    }

    try {
        $creationDate = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('INSERT INTO financial_goals (goal_name, goal_type_id, created_date, target_date, target_amount, user_id, status_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$goalName, $goal_type_id, $creationDate, $targetDate, $targetAmount, $userId, 1]);

        $_SESSION['success'] = 'Успешно добавена финансова цел.';
        header('Location: ../?page=finance-goals');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Невалиден потребител.';
        header('Location: ../?page=finance-goals&action=add');
        exit;
    }
} else {
    header('Location: ../?page=finance-goals&action=add');
    exit;
}

?>