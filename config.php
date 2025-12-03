<?php
// config.php - path helpers, escaping, and CSRF helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', '/employee_mgmt');

function url($path = '')
{
    return rtrim(BASE_PATH, '/') . '/' . ltrim((string)$path, '/');
}

function e($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_verify($t)
{
    if (empty($_SESSION['csrf'])) return false;
    return hash_equals($_SESSION['csrf'], (string)$t);
}

?>
