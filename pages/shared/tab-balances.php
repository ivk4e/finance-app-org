<?php 
    require_once('db.php');

    $userId = $_SESSION['user_id'] ?? null;
    
    $filterDateStart = $_POST['filter_date'] ?? null;
    $filterDateEnd = $_POST['filter_date_end'] ?? null;
    $filterUser = $_POST['filter_user'] ?? null;
    $filterAmount = $_POST['amount'] ?? null;
    $filterAmountNow = $_POST['amount_now'] ?? null; 
    
    try {
        $query = '
            SELECT 
                sb.balance_id,
                sb.amount,
                sb.balance_date,
                sb.purpose,
                sb.last_modified,
                sb.last_modified_by_user_id,
                u.email,
                sg.group_name,
                sb.saved_amont,
                ROUND((sb.saved_amont / sb.amount) * 100, 2) AS progress_percentage
            FROM 
                shared_balances sb
            LEFT JOIN 
                shared_groups sg ON sb.group_id = sg.group_id
            LEFT JOIN 
                group_members gm ON sg.group_id = gm.group_id
            LEFT JOIN 
                users u ON sb.last_modified_by_user_id = u.user_id
            WHERE 
                gm.user_id = :user_id AND sb.is_active = 1
        ';
    
        $params = [':user_id' => $userId];

        if ($filterDateStart) {
            $query .= ' AND sb.last_modified = :filter_date_start';
            $params[':filter_date_start'] = $filterDateStart;
        }

        if ($filterDateEnd) {
            $query .= ' AND sb.balance_date = :filter_date_end';
            $params[':filter_date_end'] = $filterDateEnd;
        }

        if ($filterUser) {
            $query .= ' AND u.email LIKE :filter_user';
            $params[':filter_user'] = '%' . $filterUser . '%';
        }

        if ($filterAmount) {
            $query .= ' AND sb.amount = :filter_amount';
            $params[':filter_amount'] = $filterAmount;
        }

        if ($filterAmountNow) {
            $query .= ' AND sb.saved_amont = :filter_amount_now';
            $params[':filter_amount_now'] = $filterAmountNow;
        }

        $query .= ' ORDER BY sb.last_modified DESC';
    
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
    
        $balances = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        echo 'Грешка при изпълнение на заявката: ' . $e->getMessage();
    }
?>

<p><em><span style="color: rgb(106, 106, 106);">Тук ще видиш текущите разпределения на баланса с дадени потребители.</span></em></p>
<div class="d-xxl-flex justify-content-xxl-end"><a href="?page=shared-finances&action=addBalance" style="text-decoration: none;"><button class="btn btn-success d-xxl-flex justify-content-xxl-center" type="button" style="color:var(--bs-btn-color);padding-right:12px;--bs-success:#198754;--bs-success-rgb:25,135,84;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right:10px;font-size:24px;">add</i>Добави баланс</button></a><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path>
        </svg></button></div>
        <form method="POST" action="" style="margin-bottom: 100px;">
            <input type="hidden" name="page" value="shared-finances">
            <input type="hidden" name="tab" value="balances">

            <div class="d-inline-flex filters-fields">
                <div class="filters-text-input">
                    <label class="form-label d-flex"><strong>Дата на краен баланс:</strong></label>
                    <input type="date" style="min-width: 200px; height: 35px;"  name="filter_date_end" value="<?php echo htmlspecialchars($_POST['filter_date_end'] ?? ''); ?>">
                </div>
                <div class="filters-text-input">
                    <label class="form-label d-flex"><strong>Дата на последен баланс:</strong></label>
                    <input type="date" style="min-width: 200px; height: 35px;"  name="filter_date" value="<?php echo htmlspecialchars($_POST['filter_date'] ?? ''); ?>">
                </div>
                <div class="filters-text-input">
                    <label class="form-label d-flex"><strong>Потребител:</strong></label>
                    <input type="text" style="min-width: 200px; height: 35px; font-size:15px;" name="filter_user" value="<?php echo htmlspecialchars($_POST['filter_user'] ?? ''); ?>">
                </div>
                <div class="filters-text-input">
                    <label class="form-label d-flex"><strong>Обща сума:</strong></label>
                    <input type="text" style="min-width: 200px; height: 35px; font-size:15px;" name="amount" value="<?php echo htmlspecialchars($_POST['amount'] ?? ''); ?>">
                </div>
                <div class="filters-text-input">
                    <label class="form-label d-flex"><strong>Събрана сума:</strong></label>
                    <input type="text" style="min-width: 200px; height: 35px; font-size:15px;" name="amount_now" value="<?php echo htmlspecialchars($_POST['amount_now'] ?? ''); ?>">
                </div>
            </div>

            <div class="d-xxl-flex justify-content-xxl-start" style="margin-bottom: 20px;">
                <button class="btn btn-primary" type="submit">
                    <i class="material-icons" style="font-size: 16px; vertical-align: middle;">filter_list</i>
                    Филтрирай
                </button>

                <a href="?page=shared-finances&tab=balances" class="d-flex align-items-center" style="text-decoration:none; margin-left: 10px;">
                    <i class="material-icons" style="font-size: 16px; vertical-align: middle;">clear</i>
                    Изчисти
                </a>
            </div>
        </form>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Дата на краен баланс</th>
                <th>Име на група</th>
                <th>Обща сума</th>
                <th>Събрана сума</th>
                <th>Дата последна модификация</th>
                <th>Редактирал потребител</th>
                <th>Цел</th>
                <th>Прогрес</th>
                <th>Опции</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($balances)): ?>
                <?php foreach ($balances as $balance): ?>
                    <tr>
                    <td><?php echo htmlspecialchars($balance['balance_date']); ?></td>
                        <td><?php echo htmlspecialchars($balance['group_name']); ?></td>
                        <td><?php echo number_format($balance['amount'], 2); ?> лв.</td>

                        <td><?php echo number_format($balance['saved_amont'], 2); ?> лв.</td>
                        
                        <td><?php echo htmlspecialchars($balance['last_modified']); ?></td>
                        <td><?php echo htmlspecialchars($balance['email']); ?></td>
                        <td><?php echo htmlspecialchars($balance['purpose']); ?></td>
                        
                        <td>
                            <div class="progress">
                                <div class="progress-bar" 
                                    role="progressbar" 
                                    style="width: <?php echo $balance['progress_percentage']; ?>%;" 
                                    aria-valuenow="<?php echo $balance['progress_percentage']; ?>" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                    <?php echo $balance['progress_percentage']; ?>%
                                </div>
                            </div>
                        <td>
                            <div class="d-flex justify-content-between gap-2">
                                <a href="?page=shared-finances&tab=balances&action=editBalance&id=<?php echo $balance['balance_id']; ?>" class="btn btn-sm btn-warning w-60">Редактирай</a>
                                <a href="handlers/handlers_shared/handler_delete_balance.php?id=<?php echo $balance['balance_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Сигурни ли сте, че искате да изтриете този баланс?');">Изтрий</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Няма намерен баланс към момента.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>