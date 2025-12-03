<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/partials/header.php';

$q = trim((string)($_GET['q'] ?? ''));
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$mysqli = db_connect();

$where = '';
$like = null;
if ($q !== '') {
        $where = " WHERE name LIKE ? OR email LIKE ? OR position LIKE ? ";
        $like = "%{$q}%";
}

// Count total
if ($where === '') {
        $countStmt = $mysqli->prepare("SELECT COUNT(*) FROM employees");
} else {
        $countStmt = $mysqli->prepare("SELECT COUNT(*) FROM employees" . $where);
        $countStmt->bind_param('sss', $like, $like, $like);
}
$countStmt->execute();
$countStmt->bind_result($total);
$countStmt->fetch();
$countStmt->close();

$totalPages = max(1, (int)ceil($total / $limit));

// Fetch page rows
if ($where === '') {
        $stmt = $mysqli->prepare("SELECT id,name,email,position,salary,joined_at FROM employees ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $limit, $offset);
} else {
        // types: s s s i i
        $stmt = $mysqli->prepare("SELECT id,name,email,position,salary,joined_at FROM employees" . $where . " ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bind_param('sssii', $like, $like, $like, $limit, $offset);
}

$stmt->execute();
$res = $stmt->get_result();

?>

<div class="card">
    <div class="toolbar">
        <div class="row">
            <form method="get" action="<?php echo e(url('index.php')); ?>" style="flex:1;display:flex;gap:8px">
                <input class="search-input" type="text" name="q" value="<?php echo e($q); ?>" placeholder="Search name, email or position">
                <button class="btn btn-primary" type="submit">Search</button>
                <a class="btn" href="<?php echo e(url('create.php')); ?>">Add</a>
            </form>
        </div>
    </div>

    <?php if ($res->num_rows === 0): ?>
        <p class="form-note">No employees found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo (int)$row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['position'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                    <td><?php echo number_format((float)$row['salary'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['joined_at'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                    <td class="actions">
                        <a class="btn" href="<?php echo e(url('edit.php?id=' . (int)$row['id'])); ?>">Edit</a>
                        <form method="post" action="<?php echo e(url('delete.php')); ?>" style="display:inline;margin:0">
                            <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                            <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this employee?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <?php if ($p === $page): ?>
                    <strong><?php echo $p; ?></strong>
                <?php else: ?>
                    <a href="?<?php echo http_build_query(['q'=>$q,'page'=>$p]); ?>"><?php echo $p; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

<?php
$stmt->close();
require_once __DIR__ . '/partials/footer.php';
?>
