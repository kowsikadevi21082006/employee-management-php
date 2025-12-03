<?php
require_once __DIR__ . '/partials/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    flash_set('error', 'Invalid employee id.');
    header('Location: ' . url('index.php'));
    exit;
}

$mysqli = db_connect();
$errors = [];

// Load existing first for initial form values
$stmt = $mysqli->prepare("SELECT name, email, position, salary FROM employees WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($db_name, $db_email, $db_position, $db_salary);
if (!$stmt->fetch()) {
    $stmt->close();
    flash_set('error', 'Employee not found.');
    header('Location: ' . url('index.php'));
    exit;
}
$stmt->close();

// Initialize form values from DB; will be overridden by POST when submitted
$name = $db_name;
$email = $db_email;
$position = $db_position;
$salary = $db_salary;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use posted values so user doesn't lose input on validation errors
    $name = trim((string)($_POST['name'] ?? $name));
    $email = trim((string)($_POST['email'] ?? $email));
    $position = trim((string)($_POST['position'] ?? $position));
    $salary = trim((string)($_POST['salary'] ?? $salary));

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($position === '') $errors[] = 'Position is required.';
    if ($salary === '' || !is_numeric($salary) || (float)$salary < 0) $errors[] = 'Salary must be a number >= 0.';

    if (empty($errors)) {
        // Check unique email for other records
        $chk = $mysqli->prepare("SELECT id FROM employees WHERE email = ? AND id != ? LIMIT 1");
        $chk->bind_param('si', $email, $id);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            $errors[] = 'Email is already used by another employee.';
            $chk->close();
        } else {
            $chk->close();
            $stmt = $mysqli->prepare("UPDATE employees SET name = ?, email = ?, position = ?, salary = ? WHERE id = ?");
            $salaryFloat = (float)$salary;
            $stmt->bind_param('sssdi', $name, $email, $position, $salaryFloat, $id);
            if ($stmt->execute()) {
                flash_set('success', 'Employee updated successfully.');
                $stmt->close();
                header('Location: ' . url('index.php'));
                exit;
            } else {
                $errors[] = 'Database error: could not update employee.';
            }
            $stmt->close();
        }
    }

}

?>

<div class="card">
    <h2>Edit Employee</h2>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error">
            <?php foreach ($errors as $e) { echo htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '<br>'; } ?>
        </div>
    <?php endif; ?>

    <form method="post" action="edit.php?id=<?php echo $id; ?>">
        <div class="form-grid">
            <div class="form-row">
                <label class="label" for="name">Name</label>
                <input class="input" id="name" name="name" type="text" value="<?php echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            </div>
            <div class="form-row">
                <label class="label" for="email">Email</label>
                <input class="input" id="email" name="email" type="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            </div>
            <div class="form-row">
                <label class="label" for="position">Position</label>
                <input class="input" id="position" name="position" type="text" value="<?php echo htmlspecialchars($position, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            </div>
            <div class="form-row">
                <label class="label" for="salary">Salary</label>
                <input class="input" id="salary" name="salary" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars($salary, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            </div>
        </div>
        <div style="margin-top:12px">
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="<?php echo e(url('index.php')); ?>">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
