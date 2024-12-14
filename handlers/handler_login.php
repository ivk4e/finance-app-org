<?php 
    require_once('../db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header('Location: ../pages/login.php?error=Not valid data.');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: ../pages/login.php?error=Invalid email.');
            exit;
        }

        if (strlen($password) < 6) {
            header('Location: ../pages/login.php?error=Password must be at least 6 characters long.');
            exit;
        }

        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->rowCount() === 0) {
                header('Location: ../pages/login.php?error=Invalid email or password.');
                exit;
            }

            $user = $stmt->fetch();
            if (!password_verify($password, $user['password_hash'])) {
                header('Location: ../pages/login.php?error=Invalid email or password.');
                exit;
            }

            //update the login_activity page for user_id, login_time, ip_address, device_info
            $stmt = $pdo->prepare('INSERT INTO login_activity (user_id, login_date, ip_address, device_info) VALUES (?, ?, ?, ?)');
            $stmt->execute([$user['user_id'], date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_last_name'] = $user['last_name'];
            $_SESSION['user_date_of_birth'] = $user['date_of_birth'];
            $_SESSION['user_created_at'] = $user['created_at'];

            //get infomation from the login_activity table
            $stmt = $pdo->prepare('SELECT * FROM login_activity WHERE user_id = ? ORDER BY login_date DESC');
            $stmt->execute([$user['user_id']]);
            $login_activity = $stmt->fetch();
            
            $_SESSION['user_last_login'] = $login_activity['login_date'];
            $_SESSION['user_ip_address'] = $login_activity['ip_address'];
            $_SESSION['user_device_info'] = $login_activity['device_info'];

            header('Location: ../index.php');
            exit;
        } catch (PDOException $e) {
            header('Location: ../pages/login.php?error=Database error.');
            exit;
        }

    } else {
        header('Location: ../pages/login.php');
        exit;
    }
?>