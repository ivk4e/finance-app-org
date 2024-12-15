<?php 
    require_once('../../db.php');

    if (!isset($_GET['id'])) {
        header('Location: ../../?page=shared-finances');
        exit;
    }

    $balance_id = intval($_GET['id']);

    if ($balance_id <= 0) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
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
        $stmt = $pdo->prepare('SELECT balance_id FROM shared_balances WHERE balance_id = :balance_id');
        $stmt->execute([':balance_id' => $balance_id]);
        $balance = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo->beginTransaction();

        $stmt = $pdo->prepare('UPDATE shared_balances SET is_active = 0 WHERE balance_id = :balance_id');
        $stmt->execute([':balance_id' => $balance_id]);

        $pdo->commit();

        $_SESSION['success'] = 'Балансът беше успешно деактивиран.';
        header('Location: ../../?page=shared-finances&tab=balances');

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Възникна грешка. Моля, опитайте отново.';
        header('Location: ../../?page=shared-finances&tab=balances');
    }
?>