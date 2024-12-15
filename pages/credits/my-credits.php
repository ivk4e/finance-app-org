<?php 
    require_once 'db.php';

    //tables are liability_types and financial_liabilities
    $stmt = $pdo->prepare('
        SELECT 
            fl.created_date,
            fl.target_date,
            lt.liability_name,
            fl.liability_id,
            fl.liability_name,
            fl.target_amount,
            fl.paid_amount,
            fl.last_modified,
            fl.status_id,
            s.status_name AS credit_status,
            (fl.target_amount - fl.paid_amount) AS remaining_amount,
            ROUND((fl.paid_amount / fl.target_amount) * 100, 2) AS progress_percentage
        FROM 
            financial_liabilities fl
        JOIN 
            liability_types lt ON fl.liability_type_id = lt.liability_type_id
        JOIN statuses s on fl.status_id = s.status_id
        WHERE 
            fl.user_id = ?
        ORDER BY 
            fl.created_date DESC;
    ');

    $stmt->execute([$_SESSION['user_id']]);
    $credits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //handle errors and success messages from the session
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
        unset($_SESSION['error']);
    }

?>

<div class="d-xxl-flex justify-content-xxl-start" style="margin-bottom: 20px;"><a href="?page=my-credits&action=add" style="text-decoration: none;"><button class="btn btn-primary d-xxl-flex justify-content-xxl-center" type="button" style="color:var(--bs-btn-color);background:var(--bs-link-color);border-color:var(--bs-link-color);padding-right:12px;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right:10px;font-size:24px;">add_circle_outline</i>Добави</button></a><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;">
    <a href="?page=my-credits"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path>
        </svg></a></button></div>
<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="color: var(--bs-btn-border-color);">Дата на създаване</th>
                        <th>Име на задължение</th>
                        <th>Целева сума</th>
                        <th>Целева дата</th>
                        <th>Наскоро платена сума</th>
                        <th>Оставаща сума</th>
                        <th>Последна модификация</th>
                        <th>Прогрес</th>
                        <th>Статус</th>
                        <th>Опции</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($credits)): ?>
                        <?php foreach ($credits as $credit): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($credit['created_date']) ?></td>
                                <td><?php echo htmlspecialchars($credit['liability_name']) ?></td>
                                <td><?php echo htmlspecialchars($credit['target_amount']) ?></td>
                                <td><?php echo htmlspecialchars($credit['target_date']) ?></td>
                                <td><?php echo number_format($credit['paid_amount'], 2) ?> лв</td>
                                <td><?php echo number_format($credit['remaining_amount'], 2) ?> лв</td>
                                <td><?php echo htmlspecialchars($credit['last_modified']); ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                            role="progressbar" 
                                            style="width: <?php echo $credit['progress_percentage']; ?>%;" 
                                            aria-valuenow="<?php echo $credit['progress_percentage']; ?>" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            <?php echo $credit['progress_percentage']; ?>%
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($credit['credit_status']); ?></td>
                                <td>
                                    <div class="d-flex justify-content-between gap-2">
                                        <a href="?page=my-credits&action=edit&id=<?php echo $credit['liability_id'] ?>" class="btn btn-sm btn-warning w-60">Редактирай</a>
                                        <a href="handlers/handlers_credits/handler_delete_credit.php?id=<?php echo $credit['liability_id']; ?>" class="btn btn-sm btn-danger w-50" onclick="return confirm('Сигурни ли сте, че искате да изтриете това задължение?');">Изтрий</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Няма добавени кредити</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>