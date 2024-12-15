<?php
require_once('db.php');

// Показване на съобщения за грешка или успех
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

// Определяне на текущия таб. По подразбиране е "groups"
$currentTab = $_GET['tab'] ?? 'groups';
?>

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $currentTab === 'groups' ? 'active' : ''; ?>" 
                               href="?page=shared-finances&tab=groups">Моите групи</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php echo $currentTab === 'balances' ? 'active' : ''; ?>" 
                               href="?page=shared-finances&tab=balances">Разпределяне на баланс</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <?php if ($currentTab === 'groups'): ?>
                            <?php include 'tab-groups.php'; ?>
                        <?php elseif ($currentTab === 'balances'): ?>
                            <?php include 'tab-balances.php'; ?>
                        <?php else: ?>
                            <p>Невалиден таб!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
