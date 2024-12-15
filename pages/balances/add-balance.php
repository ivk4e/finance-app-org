<?php 
    require_once('db.php');

    $userId = $_SESSION['user_id'] ?? null;

    try {
        //let's load the groups of this user
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
                AND sg.is_active = 1
            ORDER BY 
                sg.group_name ASC;
        ');

        $stmt->execute([
            ':user_id' => $userId
        ]);

        $groupsOfTheUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    catch (PDOException $e) {
        echo 'Error fetching groups: ' . $e->getMessage();
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
                                        <form class="text-center" method="post" action="handlers/handlers_shared/handler_add_balance.php">
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Група</label>
                                                <div class="dropdown">
                                                    <select class="form-select" name="group_id" style="text-align: left;color: var(--bs-secondary);padding-right: 12px;border-color: rgb(222,226,230);">
                                                        <option value="" selected disabled>-- Изберете група --</option>
                                                        <?php foreach ($groupsOfTheUser as $group): ?>
                                                            <option value="<?php echo $group['group_id']; ?>">
                                                                <?php echo htmlspecialchars($group['group_name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Дата на баланс</label><input class="form-control" name="dateBalance" type="date" style="border-color: rgb(222,226,230);color: var(--bs-secondary);"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Сума за събиране</label><input class="form-control" name="amount" type="text" min="0" step="0.01" placeholder="0.00" style="text-align: left;"></div>
                                            <div style="margin-bottom: 16px;"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Причина</label><input class="form-control" name="purpose" type="text"></div>
                                            <div class="mb-3"><button class="btn btn-success d-block w-100" type="submit">Запази</button></div>
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
