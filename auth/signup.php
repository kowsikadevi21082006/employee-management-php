<?php
require_once __DIR__ . '/../partials/header.php';

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = trim((string)($_POST['password'] ?? ''));
    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
    if ($password === '') $errors[] = 'Password required.';

    // Signup is a placeholder: do not create users in DB here.
    if (empty($errors)) {
      flash_set('success', 'Signup is not enabled in this demo. You may login as guest.');
      header('Location: ' . url('landing.php'));
      exit;
    }
}

?>

<div class="card">
  <h2>Sign Up</h2>
  <?php if (!empty($errors)): ?>
    <div class="flash flash-error"><?php foreach($errors as $e) echo htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '<br>'; ?></div>
  <?php endif; ?>
  <form method="post" action="<?php echo e(url('auth/signup.php')); ?>" class="form-grid">
    <div class="form-row">
      <label class="label">Name</label>
      <input class="input" type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" required>
    </div>
    <div class="form-row">
      <label class="label">Email</label>
      <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" required>
    </div>
    <div class="form-row">
      <label class="label">Password</label>
      <input class="input" type="password" name="password" required>
    </div>
    <div class="form-row">
      <button class="btn btn-primary" type="submit">Sign up (Disabled)</button>
      <a class="btn btn-secondary" href="<?php echo e(url('landing.php')); ?>">Back</a>
    </div>
    <p class="form-note">Note: Signup is a placeholder in this demo. Use Login or Continue as guest.</p>
  </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
