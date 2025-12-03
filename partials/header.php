<?php
// Header partial: session, flash, CSRF helpers, page header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../config.php';

function flash_set($type, $message)
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flash_display()
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    foreach ($_SESSION['flash'] as $f) {
        $cls = ($f['type'] === 'success') ? 'flash-success' : 'flash-error';
        echo '<div class="flash ' . $cls . '">';
        echo '<span class="flash-icon">' . ($f['type'] === 'success' ? '✔' : '✖') . '</span>';
        echo '<div class="flash-body">' . htmlspecialchars($f['message'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</div>';
        echo '</div>';
    }
    unset($_SESSION['flash']);
}

// CSRF helpers provided by config.php: csrf_token(), csrf_verify()

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Employee Management</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('public/style.css')); ?>">
</head>
<body class="app-root">
<header class="navbar">
    <div class="container navbar-inner">
        <div class="brand">
            <a href="<?php echo e(url('landing.php')); ?>" class="logo">
                <img src="<?php echo e(url('public/img/logo.svg')); ?>" alt="Logo" class="logo-img">
                <span class="logo-text">Employee<span class="logo-accent">Mgmt</span></span>
            </a>
        </div>
        <button class="nav-toggle" aria-label="Toggle menu" onclick="window.app && window.app.toggleMenu()">☰</button>
        <nav class="nav-links" id="navLinks">
            <a class="nav-item" href="<?php echo e(url('index.php')); ?>">Employees</a>
            <a class="nav-item" href="<?php echo e(url('create.php')); ?>">Add</a>
            <?php if (!empty($_SESSION['user'])): ?>
                <form method="post" action="<?php echo e(url('auth/logout.php')); ?>" class="inline-form">
                    <button class="btn btn-secondary" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a class="btn btn-primary" href="<?php echo e(url('auth/login.php')); ?>">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container main-container">
    <?php flash_display(); ?>
