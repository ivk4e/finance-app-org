<?php 
    require_once '../../db.php';

    if (!isset($_GET['id'])) {
        header('Location: ../../?page=finance-goals');
        exit;
    }

    $goalId = intval($_GET['id']);
    if ($goalId <= 0) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ../../?page=finance-goals');
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM financial_goals WHERE goal_id = :goal_id');
    $stmt->execute([':goal_id' => $goalId]);

    // Проверка дали редът е изтрит
    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = 'Целта беше успешно изтрита.';
    } else {
        $_SESSION['error'] = 'Неуспешно изтриване. Вероятно редът не съществува.';
    }

    // Пренасочване обратно към списъка с цели
    header('Location: ../../?page=finance-goals');
    exit;
?>