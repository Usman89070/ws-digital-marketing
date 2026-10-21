<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Reviews';
$pdo = get_db();
$reviews = $pdo->query('SELECT id, author_name, author_role, rating, photo_path, display_order FROM reviews ORDER BY display_order ASC, id ASC')->fetchAll();

include __DIR__ . '/includes/layout-header.php';
?>
<?php if (!empty($_GET['deleted'])): ?>
    <div class="alert alert-success">Review deleted.</div>
<?php endif; ?>
<?php if (!empty($_GET['saved'])): ?>
    <div class="alert alert-success">Review saved.</div>
<?php endif; ?>

<div class="page-actions">
    <span></span>
    <a href="review-form.php" class="btn btn-primary">+ Add Review</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Role / Company</th>
            <th>Rating</th>
            <th>Order</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$reviews): ?>
            <tr><td colspan="6">No reviews yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($reviews as $review): ?>
            <tr>
                <td><?php if ($review['photo_path']): ?><img src="<?php echo htmlspecialchars($review['photo_path'], ENT_QUOTES, 'UTF-8'); ?>" alt=""><?php endif; ?></td>
                <td><?php echo htmlspecialchars($review['author_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($review['author_role'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo str_repeat('★', (int) $review['rating']) . str_repeat('☆', 5 - (int) $review['rating']); ?></td>
                <td><?php echo (int) $review['display_order']; ?></td>
                <td>
                    <a href="review-form.php?id=<?php echo (int) $review['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="post" action="review-delete.php" style="display:inline;" onsubmit="return confirm('Delete this review? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int) $review['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
