<?php
    require_once('db.php');

    $stmt = $pdo->prepare('
        SELECT 
            fg.created_date AS goal_created_at,
            gt.type_name AS goal_type,
            fg.goal_id,
            fg.goal_name,
            fg.target_amount,
            fg.target_date,
            fg.saved_amount,
            fg.last_modified,
            fg.status_id,
            s.status_name AS goal_status,
            (fg.target_amount - fg.saved_amount) AS remaining_amount,
            
            ROUND((fg.saved_amount / fg.target_amount) * 100, 2) AS progress_percentage
        FROM 
            financial_goals fg
        JOIN 
            goal_types gt ON fg.goal_type_id = gt.type_id
        JOIN statuses s on fg.status_id = s.status_id
        WHERE 
            fg.user_id = ?
        ORDER BY 
            fg.created_date DESC;
    ');

    $stmt->execute([$_SESSION['user_id']]);
    $goals = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<div class="d-xxl-flex justify-content-xxl-start" style="margin-bottom: 20px;"><a href="?page=finance-goals&action=add" style="text-decoration: none;"><button class="btn btn-primary d-xxl-flex justify-content-xxl-center" type="button" style="color: var(--bs-btn-color);background: var(--bs-link-color);border-color: var(--bs-link-color);padding-right: 12px;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right: 10px;font-size: 24px;">add_circle_outline</i>Добави</button></a><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;">
    <a href="?page=finance-goals"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
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
                        <th style="color: var(--bs-btn-border-color);">Тип цел</th>
                        <th>Име на целта</th>
                        <th>Целева дата</th>
                        <th>Целева сума</th>
                        <th>Спестена сума</th>
                        <th>Оставаща сума</th>
                        <th>Последна модификация</th>
                        <th>Прогрес</th>
                        <th>Статус</th>
                        <th>Опции</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($goals)): ?>
                        <?php foreach ($goals as $goal): ?>
                            <?php
                                $target_date = new DateTime($goal['target_date']);
                                $current_date = new DateTime();
                                $remaining_days = $current_date->diff($target_date)->days + 1;
                                $is_close_to_target = $target_date > $current_date && $remaining_days <= 5;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($goal['goal_created_at']); ?></td>
                                <td><?php echo htmlspecialchars($goal['goal_type']); ?></td>
                                <td><?php echo htmlspecialchars($goal['goal_name']); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span><?php echo htmlspecialchars($goal['target_date']); ?></span>
                                        <?php if ($is_close_to_target): ?>
                                            <span 
                                            class="text-danger ms-2" 
                                            style="cursor: pointer;"
                                            onclick="showInfoModal(<?php echo $remaining_days; ?>);">&#10071;
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?php echo number_format($goal['target_amount'], 2); ?> лв</td>
                                <td><?php echo number_format($goal['saved_amount'], 2); ?> лв</td>
                                <td><?php echo number_format($goal['remaining_amount'], 2); ?> лв</td>
                                <td><?php echo htmlspecialchars($goal['last_modified']); ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                            role="progressbar" 
                                            style="width: <?php echo $goal['progress_percentage']; ?>%;" 
                                            aria-valuenow="<?php echo $goal['progress_percentage']; ?>" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            <?php echo $goal['progress_percentage']; ?>%
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($goal['goal_status']); ?></td>
                                <td>
                                    <!--  -->
                                    <div class="d-flex justify-content-between gap-2">
                                        <a href="?page=finance-goals&action=edit&id=<?php echo $goal['goal_id']; ?>" class="btn btn-sm btn-warning w-60">Редактирай</a>
                                        <a href="handlers/handlers_finance_goals/handler_delete_finance_goals.php?id=<?php echo $goal['goal_id']; ?>" class="btn btn-sm btn-danger w-50" onclick="return confirm('Сигурни ли сте, че искате да изтриете тази цел?');">Изтрий</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Няма налични цели.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Информация за задължението</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Затвори"></button>
            </div>
            <div class="modal-body">
                Остават <span id="remainingDays"></span> дни до целевата дата!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Затвори</button>
            </div>
        </div>
    </div>
</div>

<script>
function showInfoModal(remainingDays) {
    var modalElement = new bootstrap.Modal(document.getElementById('infoModal'));
    document.getElementById('remainingDays').innerText = remainingDays;
    modalElement.show();
}

</script>