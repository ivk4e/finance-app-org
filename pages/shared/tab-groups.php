<?php
    require_once('db.php');

    $userId = $_SESSION['user_id'] ?? null;
    
    if (!$userId) {
        die('Грешка: Невалиден потребител. Уверете се, че сте влезли в системата.');
    }


    try {
        $stmt = $pdo->prepare('
        SELECT 
        sg.group_id,
        sg.group_name,
        sg.created_date,
        sg.is_active,
        gm.purpose,
        r.role_name,
        u.email AS member_email
        FROM 
            shared_groups sg
        JOIN 
            group_members gm ON sg.group_id = gm.group_id
        JOIN 
            roles r ON gm.role_id = r.role_id
        JOIN 
            users u ON gm.other_user_member_id = u.user_id
        WHERE 
            sg.is_active = 1
            AND sg.group_id IN (
                SELECT group_id
                FROM group_members
                WHERE user_id = :current_user_id or other_user_member_id = :other_user_member_id and is_active = 1
            )
        ORDER BY 
            sg.created_date DESC;
        ');

        $stmt->execute([
            ':current_user_id' => $userId,
            'other_user_member_id' => $userId
        ]);

        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $e) {
        echo 'Грешка при изпълнение на заявката: ' . $e->getMessage();
    }

?>

<p><em><span style="color: rgb(106, 106, 106);">Тук може да видиш групите, в които участваш.</span></em></p>
<div class="d-xxl-flex justify-content-xxl-end" style="margin-bottom: 20px;"><a href="?page=shared-finances&action=addGroup" style="text-decoration: none;"><button class="btn btn-success d-xxl-flex justify-content-xxl-center" type="button" style="color: var(--bs-btn-color);padding-right: 12px;--bs-success: #198754;--bs-success-rgb: 25,135,84;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right: 10px;font-size: 24px;">add</i>Създай група</button></a><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path>
        </svg></button></div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Номер на група</th>
                <th>Име на група</th>
                <th>Дата на създаване</th>
                <th>Email участник</th>
                <th>Роля</th>
                <th>Цел</th>
                <th>Опции</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($groups)): ?>
                <?php foreach ($groups as $group): ?>
                    <tr>
                    <td><?php echo htmlspecialchars($group['group_id']); ?></td>
                        <td><?php echo htmlspecialchars($group['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($group['created_date']); ?></td>
                        <td><?php echo htmlspecialchars($group['member_email']); ?></td>
                        <td><?php echo htmlspecialchars($group['role_name']); ?></td>
                        <td><?php echo htmlspecialchars($group['purpose']); ?></td>
                        <td>
                            <a href="handlers/handlers_shared/handler_delete_group.php?id=<?php echo $group['group_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Сигурни ли сте, че искате да изтриете тази група?');">Изтрий</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Няма намерени групи.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
