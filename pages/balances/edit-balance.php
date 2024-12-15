<?php 
    require_once('db.php');

    if (!isset($_GET['id'])) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ?page=shared-finances&tab=balances&action=edit&id=' . $_GET['id']);
        exit;
    }

    $balanceId = $_GET['id'];
    $userId = $_SESSION['user_id'] ?? null;

    try {
        $stmt = $pdo->prepare('
            SELECT 
                sb.balance_id,
                sb.amount,
                sb.balance_date,
                sb.purpose,
                sb.status_id,
                sb.last_modified,
                sg.group_name,
                sb.saved_amont,
                ROUND((sb.saved_amont / sb.amount) * 100, 2) AS progress_percentage
            FROM 
                shared_balances sb
            JOIN 
                shared_groups sg ON sb.group_id = sg.group_id
            JOIN 
                group_members gm ON sg.group_id = gm.group_id
            WHERE 
                gm.user_id = :user_id
            AND
                sb.balance_id = :balance_id
            GROUP BY 
                sb.balance_id, sg.group_name, sb.amount, sb.balance_date, sb.purpose, sb.last_modified
            ORDER BY 
                sb.last_modified DESC;
        ');

        $stmt->execute([
            ':user_id' => $userId,
            ':balance_id' => $balanceId,
        ]);

        $balance = $stmt->fetch();

        $stmt = $pdo->prepare('
            SELECT 
                sg.group_id,
                sg.group_name
            FROM 
                shared_groups sg
            JOIN 
                group_members gm ON sg.group_id = gm.group_id
            WHERE 
                gm.user_id = :user_id
            ORDER BY 
                sg.group_name;
        ');

        $stmt->execute([':user_id' => $userId]);
        $groupsOfTheUser = $stmt->fetchAll();

        $statuses = $pdo->query('SELECT * FROM statuses')->fetchAll();

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Грешка при извличане на данни: ' . $e->getMessage();
        header('Location: ?page=shared-finances&tab=balances');
        exit;
    }

?>

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <section class="position-relative py-4 py-xl-5">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-5">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <form class="text-center" method="post" action="handlers/handlers_shared/handler_edit_balances.php">
                                            <div class="mb-3">
                                                <input type="hidden" name="balance_id" value="<?php echo htmlspecialchars($balance['balance_id']); ?>">
                                                
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Група</label>
                                                <div class="dropdown">
                                                <select class="form-select" name="group_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);" required>
                                                <option value="" disabled>-- Изберете група --</option>
                                                    <?php foreach ($groupsOfTheUser as $group): ?>
                                                        <option value="<?php echo $group['group_id']; ?>">
                                                            <?php echo htmlspecialchars($group['group_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Дата на баланс</label>
                                                <input class="form-control" type="date" name="dateBalance" value="<?php echo htmlspecialchars($balance['balance_date']); ?>" style="border-color: rgb(222,226,230);color: var(--bs-secondary);">
                                            </div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Сума за събиране</label>
                                                <input class="form-control" type="text" name="amount" value="<?php echo htmlspecialchars($balance['amount']); ?>" style="text-align: left;">
                                            </div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Спестена сума</label>
                                                <input class="form-control" type="text" name="savedAmount" value="<?php echo htmlspecialchars($balance['saved_amont']); ?>" style="text-align: left;">
                                            </div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Причина</label>
                                                <input class="form-control" type="text" name="purpose" value="<?php echo htmlspecialchars($balance['purpose']); ?>">
                                            </div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Статус</label>
                                                <div class="dropdown">
                                                <select class="form-select" name="status_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" disabled>-- Изберете статус --</option>
                                                        <?php foreach ($statuses as $status): ?>
                                                            <option value="<?php echo $status['status_id']; ?>" <?php echo $balance['status_id'] == $status['status_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($status['status_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-warning d-block w-100" type="submit">Редактиране</button>
                                                <div>
                                                    <a href="handlers/handlers_shared/handler_delete_balance.php?id=<?php echo $balance['balance_id']; ?>" style="color: var(--bs-link-color); text-decoration: none;">
                                                    <p style="font-style: italic;color: rgb(255,15,0);margin-top: 10px;">Изтриване на баланс</p></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>