<?php 
    require_once('../../db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $liability_type_id = $_POST['liability_type_id'] ?? null;
        $targetDate = $_POST['targetDate'] ?? null;
        $liability_name = $_POST['liability_name'] ?? null;
        $targetAmount = $_POST['targetAmount'] ?? null;

        if (empty($liability_type_id) || empty($targetDate) || empty($liability_name) || empty($targetAmount)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../../?page=my-credits&action=add');
            exit;
        }

        if (!is_numeric($targetAmount) || $targetAmount < 0) {
            $_SESSION['error'] = 'Въведете валидна целева сума.';
            header('Location: ../../?page=my-credits&action=add');
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (empty($userId)) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=my-credits&action=add');
            exit;
        }

        try {
            $creationDate = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare('INSERT INTO financial_liabilities (liability_name, liability_type_id, created_date, target_date, target_amount, user_id, status_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$liability_name, $liability_type_id, $creationDate, $targetDate, $targetAmount, $userId, 1]);

            $_SESSION['success'] = 'Успешно добавено задължение.';
            header('Location: ../../?page=my-credits');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=my-credits&action=add');
            exit;
        }
    } else {
        header('Location: ../../?page=my-credits&action=add');
        exit;
    }

?>