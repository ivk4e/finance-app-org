<?php
function getPageDetails($page, $action) {
    $page_path = '';
    $page_title = '';
    $show_back_button = false;

    switch ($page) {
        case 'finance-goals':
            if ($action === 'add') {
                $page_path = './pages/finance-goals/add-finance-goal.php';
                $page_title = 'Добавяне на финансова цел';
                $show_back_button = true;
            } 
            else if ($action === 'edit') {
                $page_path = './pages/finance-goals/edit-finance-goal.php';
                $page_title = 'Редактиране на финансова цел';
                $show_back_button = true;
            } else {
                $page_path = './pages/finance-goals/finance-goals.php';
                $page_title = 'Финансови цели';
            }
            break;
        case 'my-credits':
            if ($action === 'add') {
                $page_path = './pages/credits/add-credit.php';
                $page_title = 'Добавяне на финансово задължение';
                $show_back_button = true;
            } 
            else if ($action === 'edit') {
                $page_path = './pages/credits/edit-credit.php';
                $page_title = 'Редактиране на финансово задължение';
                $show_back_button = true;
            } else {
                $page_path = './pages/credits/my-credits.php';
                $page_title = 'Финансови задължения';
            }
            break;
        case 'shared-finances':
            if ($action === 'addBalance') {
                $page_path = './pages/balances/add-balance.php';
                $page_title = 'Добавяне на баланс';
                $show_back_button = true;
            } 
            else if ($action === 'editBalance') {
                $page_path = './pages/balances/edit-balance.php';
                $page_title = 'Редактиране на баланс';
                $show_back_button = true;
            } 
            else if ($action === 'addTransaction') {
                $page_path = './pages/shared/add-transaction.php';
                $page_title = 'Добавяне на транзакция';
                $show_back_button = true;
            } 
            else if ($action === 'editTransaction') {
                $page_path = './pages/shared/edit-transaction.php';
                $page_title = 'Редактиране на транзакция';
                $show_back_button = true;
            } 
            else if ($action === 'addGroup') {
                $page_path = './pages/shared/add-group.php';
                $page_title = 'Добавяне на група';
                $show_back_button = true;
            } else {
                $page_path = './pages/shared/shared-finances.php';
                $page_title = 'Споделени финанси';
            }
            break;
        case 'profile-settings':
            $page_path = './pages/settings/profile-settings.php';
            $page_title = 'Настройки на профила';
            break;
        default:
            $page_path = './pages/hello.php'; // Страница за грешка, ако файлът не съществува
            $page_title = '';
            break;
    }

    return [
        'page_path' => $page_path,
        'page_title' => $page_title,
        'show_back_button' => $show_back_button,
    ];
}
