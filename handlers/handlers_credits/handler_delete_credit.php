<?php
    require_once('../../db.php');

    if (!isset($_GET['id'])) {
        header('Location: ../../?page=my-credits');
        exit;
    }

    $liabilityId = intval($_GET['id']);

    if ($liabilityId <= 0) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ../../?page=my-credits');
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM financial_liabilities WHERE liability_id = :liability_id');
    $stmt->execute([':liability_id' => $liabilityId]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = 'Задължението беше успешно изтрито.';
    } else {
        $_SESSION['error'] = 'Неуспешно изтриване. Вероятно редът не съществува.';
    }

    header('Location: ../../?page=my-credits');
    exit;
?>