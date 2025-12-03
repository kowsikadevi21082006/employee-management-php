<?php
require_once __DIR__ . '/../partials/header.php';

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = trim((string)($_POST['password'] ?? ''));
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email.';
    if ($password === '') $errors[] = 'Password required.';

    // Placeholder auth: accept any creds for demo; set session user
    if (empty($errors)) {
      $_SESSION['user'] = ['email' => $email];
      flash_set('success', 'Logged in as ' . $email);
      header('Location: ' . url('index.php'));
      exit;
    }
}

?>

<div class="card">
  <h2>Login</h2>
  <?php if (!empty($errors)): ?>
    <div class="flash flash-error"><?php foreach($errors as $e) echo htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '<br>'; ?></div>
  <?php endif; ?>
  <form method="post" action="<?php echo e(url('auth/login.php')); ?>" class="form-grid">
    <div class="form-row">
      <label class="label">Email</label>
      <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" required>
    </div>
    <div class="form-row">
      <label class="label">Password</label>
      <input class="input" type="password" name="password" required>
    </div>
    <div class="form-row">
      <button class="btn btn-primary" type="submit">Login</button>
      <a class="btn btn-secondary" href="<?php echo e(url('landing.php')); ?>">Back</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
