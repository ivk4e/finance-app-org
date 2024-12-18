<?php 
    require_once('../../db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $group_id = $_POST['group_id'] ?? null;
        $dateBalance = $_POST['dateBalance'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $purpose = $_POST['purpose'] ?? null;

        if (empty($group_id) || empty($dateBalance) || empty($amount) || empty($purpose)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        if (!is_numeric($amount) || $amount < 0) {
            $_SESSION['error'] = 'Въведете валидна сума.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (empty($userId)) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        try {
            $creationDate = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare('INSERT INTO shared_balances (group_id, balance_date, amount, purpose, creator_id, created_date, status_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$group_id, $dateBalance, $amount, $purpose, $userId, $creationDate, 1]);

            $_SESSION['success'] = 'Успешно добавен баланс.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }
    }
?>