<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

$mysqli = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id <= 0) {
        flash_set('error', 'Invalid employee id.');
        header('Location: ' . url('index.php'));
        exit;
    }

    $token = $_POST['csrf'] ?? '';
    if (!csrf_verify($token)) {
        flash_set('error', 'Invalid CSRF token.');
        header('Location: ' . url('index.php'));
        exit;
    }

    $stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        flash_set('success', 'Employee deleted.');
    } else {
        flash_set('error', 'Could not delete employee.');
    }
    $stmt->close();
    header('Location: ' . url('index.php'));
    exit;
}

// GET confirm page
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . url('index.php'));
    exit;
}

$stmt = $mysqli->prepare("SELECT name, email FROM employees WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($name, $email);
if (!$stmt->fetch()) {
    $stmt->close();
    flash_set('error', 'Employee not found.');
    header('Location: ' . url('index.php'));
    exit;
}
$stmt->close();
?>

<div class="card">
  <h2>Confirm Delete</h2>
  <p>Are you sure you want to delete employee <strong><?php echo e($name); ?></strong> (<?php echo e($email); ?>)?</p>

  <form method="post" action="<?php echo e(url('delete.php')); ?>">
    <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
    <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
    <button class="btn btn-danger" type="submit">Delete</button>
    <a class="btn btn-secondary" href="<?php echo e(url('index.php')); ?>">Cancel</a>
  </form>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
