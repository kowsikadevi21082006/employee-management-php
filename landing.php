<?php
require_once __DIR__ . '/partials/header.php';
?>
<section class="hero">
  <div class="hero-inner">
    <h1>Manage your team with clarity</h1>
    <p>Simple, secure employee management. Search, add, edit and remove employees quickly. Built with PHP & MySQL.</p>
    <div class="hero-cta">
      <a class="btn btn-primary" href="<?php echo e(url('auth/login.php')); ?>">Login</a>
      <a class="btn btn-secondary" href="<?php echo e(url('auth/signup.php')); ?>">Sign up</a>
      <a class="btn" href="<?php echo e(url('index.php')); ?>">Continue as guest</a>
    </div>
  </div>
  <div class="hero-graphic">
    <div class="blob"></div>
  </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
