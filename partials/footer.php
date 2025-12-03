<?php
// Footer partial
?>
    </main>
    <footer class="site-footer">
        <div class="container">
            <p class="muted">&copy; <?php echo date('Y'); ?> Employee Management — Built with PHP & MySQL</p>
        </div>
    </footer>
    <?php require_once __DIR__ . '/../config.php'; ?>
    <script src="<?php echo e(url('public/app.js')); ?>"></script>
</body>
</html>
