<?php 
    require_once('db.php');

    if (!isset($_GET['id'])) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ?page=finance-goals&action=edit&id=' . $_GET['id']);
        exit;
    }
    
    $goalId = $_GET['id'];

    try {
        $stmt = $pdo->prepare('
            SELECT 
                fg.goal_id,
                fg.goal_name,
                fg.goal_type_id,
                gt.type_name AS goal_type_name,
                fg.target_amount,
                fg.saved_amount,
                fg.target_date,
                fg.status_id,
                s.status_name AS status_name
            FROM 
                financial_goals fg
            JOIN 
                goal_types gt ON fg.goal_type_id = gt.type_id
            JOIN 
                statuses s ON fg.status_id = s.status_id
            WHERE 
                fg.goal_id = :goal_id;
        ');
        $stmt->execute([':goal_id' => $goalId]);
        $goal = $stmt->fetch();

        // Извличане на всички типове цели
        $goalTypes = $pdo->query('SELECT * FROM goal_types')->fetchAll();

        // Извличане на всички статуси
        $statuses = $pdo->query('SELECT * FROM statuses')->fetchAll();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Грешка при извличане на данни: ' . $e->getMessage();
        header('Location: ?page=finance-goals');
        exit;
    }

    //check for Session error and success and make an alert
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
                                        <form class="text-center" method="post" action="handlers/handler_edit_finance_goal.php">
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Тип цел</label>
                                            <input type="hidden" name="goal_id" value="<?php echo htmlspecialchars($goal['goal_id']); ?>">
                                            <div class="dropdown">
                                                    <select class="form-select" name="type_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" disabled>-- Изберете тип цел --</option>
                                                        <?php foreach ($goalTypes as $goalType): ?>
                                                            <option value="<?php echo $goalType['type_id']; ?>" <?php echo $goal['goal_type_id'] == $goalType['type_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($goalType['type_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Целева дата</label>
                                                <input class="form-control" type="date" name="target_name" value="<?php echo htmlspecialchars($goal['target_date']); ?>" style="border-color: rgb(222,226,230);color: var(--bs-secondary);"></div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Наименование</label>
                                                <input class="form-control" name="goal_name" value="<?php echo htmlspecialchars($goal['goal_name']); ?>" style="text-align: left;"></div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Целева сума</label>
                                                <input class="form-control" name="target_amount" value="<?php echo htmlspecialchars($goal['target_amount']); ?>" type="text"></div>
                                            <div style="margin-bottom: 16px;">
                                                <label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Спестена сума</label>
                                                <input class="form-control" name="saved_amount" value="<?php echo htmlspecialchars($goal['saved_amount']); ?>" type="text"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Статус</label>
                                            <div class="dropdown">
                                                    <select class="form-select" name="status_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" disabled>-- Изберете статус --</option>
                                                        <?php foreach ($statuses as $status): ?>
                                                            <option value="<?php echo $status['status_id']; ?>" <?php echo $goal['status_id'] == $status['status_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($status['status_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            </div>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-warning d-block w-100" type="submit">Запазване</button>
                                                <div>
                                                    <a href="handlers/handler_delete_finance_goals.php?id=<?php echo $goal['goal_id']; ?>" style="text-decoration: none;" onclick="return confirm('Сигурни ли сте, че искате да изтриете тази цел?');"><p style="font-style: italic; color: rgb(255,15,0);margin-top: 10px;">Изтриване на цел</p>
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