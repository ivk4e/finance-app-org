<?php
    $base_path = isset($is_main_page) && $is_main_page ? '' : '../';
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo isset($page_title) ? $page_title : 'Finance App'; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/bs-theme-overrides.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/Navbar-Centered-Links-icons.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/untitled.css">
</head>