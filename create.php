<?php
require_once __DIR__ . '/partials/header.php';

$errors = [];
$name = '';
$email = '';
$position = '';
$salary = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $position = trim((string)($_POST['position'] ?? ''));
    $salary = trim((string)($_POST['salary'] ?? ''));

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($position === '') $errors[] = 'Position is required.';
    if ($salary === '' || !is_numeric($salary) || (float)$salary < 0) $errors[] = 'Salary must be a number >= 0.';

    if (empty($errors)) {
        $mysqli = db_connect();
        $stmt = $mysqli->prepare("INSERT INTO employees (name, email, position, salary) VALUES (?, ?, ?, ?)");
        $salaryFloat = (float)$salary;
        $stmt->bind_param('sssd', $name, $email, $position, $salaryFloat);
        if ($stmt->execute()) {
            flash_set('success', 'Employee created.');
            $stmt->close();
            header('Location: ' . url('index.php'));
            exit;
        } else {
            if ($mysqli->errno === 1062) {
                $errors[] = 'Email already exists.';
            } else {
                $errors[] = 'Database error: could not add employee.';
            }
        }
        $stmt->close();
    }
}

?>

<div class="card">
    <h2>Add Employee</h2>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error">
            <?php foreach ($errors as $e) { echo htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '<br>'; } ?>
        </div>
    <?php endif; ?>

    <form method="post" action="create.php">
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
            <button class="btn btn-primary" type="submit">Create</button>
            <a class="btn btn-secondary" href="<?php echo e(url('index.php')); ?>">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
