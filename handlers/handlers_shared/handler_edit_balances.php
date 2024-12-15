<?php 
    require_once('../../db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $group_id = intval($_POST['group_id']) ?? null;
        $dateBalance = $_POST['dateBalance'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $saved_amount = $_POST['savedAmount'] ?? null;
        $purpose = $_POST['purpose'] ?? null;
        $balance_id = $_POST['balance_id'] ?? null;

        if (empty($group_id) || empty($dateBalance) || empty($amount) || empty($purpose) || empty($balance_id)) {
            $_SESSION['error'] = 'Всички полета са задължителни.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        if (!is_numeric($amount) || $amount < 0 || empty($amount)) {
            $_SESSION['error'] = 'Въведете валидна сума.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        //if the saved amount is not set, set it to 0
        if (empty($saved_amount)) {
            $saved_amount = 0.00;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (empty($userId)) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

        try {
            $modifiedDate = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare('UPDATE shared_balances SET group_id = ?, balance_date = ?, amount = ?, saved_amont = ?, purpose = ?, last_modified_by_user_id = ?, last_modified = ?, status_id = ? WHERE balance_id = ?');
            $stmt->execute([$group_id, $dateBalance, $amount, $saved_amount, $purpose, $userId, $modifiedDate, 1, $balance_id]);

            $_SESSION['success'] = 'Успешно редактиран баланс.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Невалиден потребител.';
            header('Location: ../../?page=shared-finances&tab=balances');
            exit;
        }

    }
?>