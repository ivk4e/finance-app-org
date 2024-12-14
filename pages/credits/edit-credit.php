<?php 
    require_once('db.php');

    if (!isset($_GET['id'])) {
        $_SESSION['error'] = 'Невалиден идентификатор.';
        header('Location: ?page=my-credits&action=edit&id=' . $_GET['id']);
        exit;
    }

    $liabilityId = $_GET['id'];

    try {
        $stmt = $pdo->prepare('
            SELECT 
                fl.liability_id,
                fl.liability_name,
                fl.liability_type_id,
                lt.liability_name,
                fl.target_amount,
                fl.paid_amount,
                fl.target_date,
                fl.status_id,
                s.status_name AS status_name
            FROM 
                financial_liabilities fl
            JOIN 
                liability_types lt ON fl.liability_type_id = lt.liability_type_id
            JOIN 
                statuses s ON fl.status_id = s.status_id
            WHERE 
                fl.liability_id = :liability_id;
        ');
        $stmt->execute([':liability_id' => $liabilityId]);
        $liability = $stmt->fetch();

        $liabilityTypes = $pdo->query('SELECT * FROM liability_types')->fetchAll();

        $statuses = $pdo->query('SELECT * FROM statuses')->fetchAll();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Грешка при извличане на данни: ' . $e->getMessage();
        header('Location: ?page=my-credits');
        exit;
    }

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
                                        <form class="text-center" method="post" action="handlers/handlers_credits/handler_edit_credit.php">
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Тип задължение</label>
                                            <input type="hidden" name="liability_id" value="<?php echo htmlspecialchars($liability['liability_id']); ?>">
                                            <div class="dropdown">
                                                    <select class="form-select" name="liability_type_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" disabled>-- Изберете тип задължение --</option>
                                                        <?php foreach ($liabilityTypes as $liabilityType): ?>
                                                            <option value="<?php echo $liabilityType['liability_type_id']; ?>" <?php echo $liability['liability_type_id'] == $liabilityType['liability_type_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($liabilityType['liability_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Крайна дата</label><input class="form-control" type="date" name="target_date" value="<?php echo htmlspecialchars($liability['target_date']); ?>" style="border-color: rgb(222,226,230);color: var(--bs-secondary);"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Наименование</label><input class="form-control" name="liability_name" value="<?php echo htmlspecialchars($liability['liability_name']); ?>" type="text" style="text-align: left;"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Крайна сума</label><input class="form-control" name="target_amount" value="<?php echo htmlspecialchars($liability['target_amount']); ?>" type="text"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Наскоро платена сума</label><input class="form-control" name="paid_amount" value="<?php echo htmlspecialchars($liability['paid_amount']); ?>" type="text"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Статус</label>
                                            <div class="dropdown">
                                                    <select class="form-select" name="status_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" disabled>-- Изберете статус --</option>
                                                        <?php foreach ($statuses as $status): ?>
                                                            <option value="<?php echo $status['status_id']; ?>" <?php echo $liability['status_id'] == $status['status_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($status['status_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            </div>
                                            </div>
                                            <div class="mb-3"><button class="btn btn-warning d-block w-100" type="submit">Запазване</button>
                                                <div>
                                                    <a href="handlers/handlers_credits/handler_delete_credit.php?id=<?php echo $liability['liability_id']; ?>" style="text-decoration: none;" onclick="return confirm('Сигурни ли сте, че искате да изтриете това задължение?');"><p style="font-style: italic;color: rgb(255,15,0);margin-top: 10px;">Изтриване на задължение</p>
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