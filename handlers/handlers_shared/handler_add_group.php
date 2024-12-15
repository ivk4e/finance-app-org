<?php 
require_once('../../db.php');   

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'] ?? null;
    $member_email = $_POST['member_email'] ?? null;
    $purpose = $_POST['purpose'] ?? null;

    if (empty($group_name) || empty($member_email) || empty($purpose)) {
        $_SESSION['error'] = 'Всички полета са задължителни.';
        header('Location: ../../?page=shared-finances&action=add-group');
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;

    if (empty($userId)) {
        $_SESSION['error'] = 'Невалиден потребител.';
        header('Location: ../../?page=shared-finances&action=add-group');
        exit;
    }

    try {
        // Намери user_id на въведения email
        $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = :email');
        $stmt->execute([':email' => $member_email]);
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$member) {
            $_SESSION['error'] = 'Участник с този имейл не съществува в системата.';
            header('Location: ../../?page=shared-finances&action=add-group');
            exit;
        }

        $other_user_member_id = $member['user_id'];

        $pdo->beginTransaction();

        $stmt = $pdo->prepare('
            INSERT INTO shared_groups (group_name, created_by, created_date, is_active)
            VALUES (:group_name, :created_by, NOW(), 1)
        ');
        $stmt->execute([
            ':group_name' => $group_name,
            ':created_by' => $userId
        ]);

        $group_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare('
            INSERT INTO group_members (group_id, user_id, other_user_member_id, purpose, role_id)
            VALUES (:group_id, :user_id, :other_user_member_id, :purpose, :role_id)
        ');
        $stmt->execute([
            ':group_id' => $group_id,
            ':user_id' => $userId,
            ':other_user_member_id' => $other_user_member_id,
            ':purpose' => $purpose,
            ':role_id' => 2
        ]);

        $stmt->execute([
            ':group_id' => $group_id,
            ':user_id' => $other_user_member_id,
            ':other_user_member_id' => $userId,
            ':purpose' => $purpose,
            ':role_id' => 1
        ]);

        $pdo->commit();

        $_SESSION['success'] = 'Групата беше успешно създадена.';
        header('Location: ../../?page=shared-finances');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Грешка: ' . $e->getMessage();
        header('Location: ../../?page=shared-finances');
        exit;
    }
} else {
    header('Location: ../../?page=shared-finances');
    exit;
}
