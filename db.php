<?php
// db.php - reusable mysqli connection (utf8mb4)
// Local XAMPP defaults: user=root, password=''
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'employee_db');

// Create a global $mysqli connection so included files can use it directly.
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    // Readable message for local/dev. For production, log and show generic message.
    die('Database connection failed: ' . htmlspecialchars($mysqli->connect_error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
}
$mysqli->set_charset('utf8mb4');

function db_connect()
{
    global $mysqli;
    return $mysqli;
}

?>
