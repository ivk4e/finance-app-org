<?php
    require_once('../../db.php');

    if (!isset($_GET['id'])) {
        header('Location: ../../?page=shared-finances');
        exit;
    }

    $group_id = intval($_GET['id']);
    
    if ($group_id <= 0) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ../../?page=shared-finances');
        exit;
    }
    $userId = $_SESSION['user_id'] ?? null;

    if (empty($userId)) {
        $_SESSION['error'] = 'Невалиден потребител.';
        header('Location: ../../?page=shared-finances');
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT group_id FROM shared_groups WHERE group_id = :group_id AND created_by = :created_by');
        $stmt->execute([':group_id' => $group_id, ':created_by' => $userId]);
        $group = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$group) {
            $_SESSION['error'] = 'Нямате права да изтриете тази група.';
            header('Location: ../../?page=shared-finances');
            exit;
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare('UPDATE shared_groups SET is_active = 0 WHERE group_id = :group_id');
        $stmt->execute([':group_id' => $group_id]);

        $pdo->commit();

        $_SESSION['success'] = 'Групата беше успешно деактивирана.';
        header('Location: ../../?page=shared-finances');

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Възникна грешка. Моля, опитайте отново.';
        header('Location: ../../?page=shared-finances');
    }

?>