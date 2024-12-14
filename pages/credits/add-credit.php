<?php 
    require_once('db.php');

    try {
        $stmt = $pdo->query('SELECT liability_type_id, liability_name FROM liability_types');
        $liabilityTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Error fetching liability types: ' . $e->getMessage());
    }

    //handle errors and success messages from the session
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
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
                                        <form class="text-center" method="post" action="handlers/handlers_credits/handler_add_credit.php">
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Тип задължение</label>
                                                <div class="dropdown">
                                                <select class="form-select" name="liability_type_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" selected disabled>-- Изберете тип задължение --</option>
                                                        <?php foreach ($liabilityTypes as $liabilityType): ?>
                                                            <option value="<?php echo $liabilityType['liability_type_id']; ?>">
                                                                <?php echo htmlspecialchars($liabilityType['liability_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Крайна дата</label><input class="form-control" type="date" name="targetDate" style="border-color: rgb(222,226,230);color: var(--bs-secondary);"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Наименование</label><input class="form-control" type="text" name="liability_name" style="text-align: left;"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Сума по задължение</label><input class="form-control" min="0" step="0.01" placeholder="0.00" name="targetAmount" type="text"></div>
                                            <div class="mb-3"><button class="btn btn-success d-block w-100" type="submit">Създаване</button></div>
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