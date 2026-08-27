<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Case Studies';
$pdo = get_db();
$studies = $pdo->query('SELECT id, name, tag, image_path, has_data, display_order FROM case_studies ORDER BY display_order ASC, name ASC')->fetchAll();

include __DIR__ . '/includes/layout-header.php';
?>
<?php if (!empty($_GET['deleted'])): ?>
    <div class="alert alert-success">Case study deleted.</div>
<?php endif; ?>
<?php if (!empty($_GET['saved'])): ?>
    <div class="alert alert-success">Case study saved.</div>
<?php endif; ?>

<div class="page-actions">
    <span></span>
    <a href="case-form.php" class="btn btn-primary">+ Add Case Study</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Tag</th>
            <th>Results Data</th>
            <th>Order</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$studies): ?>
            <tr><td colspan="6">No case studies yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($studies as $study): ?>
            <tr>
                <td><?php if ($study['image_path']): ?><img src="<?php echo htmlspecialchars($study['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt=""><?php endif; ?></td>
                <td><?php echo htmlspecialchars($study['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($study['tag'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo $study['has_data'] ? 'Yes' : 'Scope only'; ?></td>
                <td><?php echo (int) $study['display_order']; ?></td>
                <td>
                    <a href="case-form.php?id=<?php echo (int) $study['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="post" action="case-delete.php" style="display:inline;" onsubmit="return confirm('Delete this case study? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int) $study['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
