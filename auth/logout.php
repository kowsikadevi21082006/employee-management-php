<?php
require_once __DIR__ . '/../partials/header.php';

// Simple logout: clear user session and redirect
if (session_status() === PHP_SESSION_NONE) session_start();
unset($_SESSION['user']);
flash_set('success', 'You have been logged out.');
header('Location: ' . url('landing.php'));
exit;
