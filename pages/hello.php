<?php 
    //get the user first name from the session
    $user_first_name = $_SESSION['user_first_name']; 

    $hour = date('H');
    if ($hour < 12) {
        $greeting = "Добро утро";
    } elseif ($hour < 18) {
        $greeting = "Добър ден";
    } else {
        $greeting = "Добър вечер";
    }

    require_once('db.php'); // Включване на файла за връзка с базата данни

$user_id = $_SESSION['user_id'] ?? null; // Вземане на ID на логнатия потребител

try {
    // 1. Обща сума на текущите финансови цели на потребителя
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(saved_amount), 0) AS total_balance
        FROM financial_goals
        WHERE user_id = :user_id AND status_id = 1
    ");
    $stmt->execute([':user_id' => $user_id]);
    $total_balance = $stmt->fetchColumn();

    // 2. Предстоящи цели (завършващи в следващите 5 дни)
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS goal_name
        FROM financial_goals
        WHERE user_id = :user_id 
        AND status_id = 1 
        AND DATEDIFF(target_date, CURDATE()) BETWEEN 0 AND 5
    ");
    $stmt->execute([':user_id' => $user_id]);
    $upcoming_goals = $stmt->fetchColumn();

    // 3. Предстоящи задължения (с крайна дата в следващите 5 дни)
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS liability_name
        FROM financial_liabilities
        WHERE user_id = :user_id 
        AND status_id = 1 
        AND DATEDIFF(target_date, CURDATE()) BETWEEN 0 AND 5
    ");
    $stmt->execute([':user_id' => $user_id]);
    $upcoming_obligations = $stmt->fetchColumn();

} catch (PDOException $e) {
    die('Грешка при извличането на данните: ' . $e->getMessage());
}


?>

<div class="row mb-5">
    <div class="col-md-8 col-xl-6 text-center mx-auto">
        <h2><?php echo $greeting; ?>, <?php echo htmlspecialchars($user_first_name); ?>!</h2>
        <p class="w-lg-50">Тук можеш да следиш своите финанси, цели и задължения.</p>
    </div>
</div>
<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
    <div class="col">
        <div class="card">
            <div class="card-body p-4">
                <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bell">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6"></path>
                    </svg></div>
                <h4 class="card-title">Обща стойност на спестените ти пари</h4>
                <h2 class="text-success"><?php echo number_format($total_balance, 2); ?> лв.</h2>
                <p class="card-text">Това е текущият баланс по отношение на самостоятелните ти цели.</p>
                <a href="?page=finance-goals" style="text-decoration:none;">Виж повече &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body p-4">
                <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></div>
                <h4 class="card-title">Предстоящи цели</h4>
                <?php if ($upcoming_goals == 0): ?>
                    <h2 class="text-success"><?php echo $upcoming_goals; ?></h2>
                    <p class="card-text">Не си близо до крайния срок за твоите цели.</p>
                    <a href="?page=finance-goals" style="text-decoration:none;">Преглед на целите &rarr;</a>
                <?php else: ?>
                    <h2 class="text-warning"><?php echo $upcoming_goals; ?></h2>
                    <p class="card-text">Брой цели, които очакват твоето действие.</p>
                    <a href="?page=finance-goals" style="text-decoration:none;">Виж повече &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body p-4">
                <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center d-inline-block mb-3 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-flag">
                        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z"></path>
                    </svg></div>
                <h4 class="card-title">Предстоящи задължения</h4>
                <?php if ($upcoming_obligations == 0): ?>
                    <h2 class="text-success"><?php echo $upcoming_obligations; ?></h2>
                    <p class="card-text">Все още нямаш наближаващи задължения.</p>
                    <a href="?page=my-credits" style="text-decoration:none;">Преглед на задълженията &rarr;</a>
                <?php else: ?>
                    <h2 class="text-danger"><?php echo $upcoming_obligations; ?></h2>
                    <p class="card-text">Брой задължения, които очакват твоето действие.</p>
                    <a href="?page=my-credits" style="text-decoration:none;">Виж повече &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="pages/notifications.js"></script>