<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Blog Posts';
$pdo = get_db();
$posts = $pdo->query('SELECT id, title, category, image_path, is_published, created_at FROM blog_posts ORDER BY created_at DESC')->fetchAll();

include __DIR__ . '/includes/layout-header.php';
?>
<?php if (!empty($_GET['deleted'])): ?>
    <div class="alert alert-success">Blog post deleted.</div>
<?php endif; ?>
<?php if (!empty($_GET['saved'])): ?>
    <div class="alert alert-success">Blog post saved.</div>
<?php endif; ?>

<div class="page-actions">
    <span></span>
    <a href="blog-form.php" class="btn btn-primary">+ Add Blog Post</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th></th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$posts): ?>
            <tr><td colspan="6">No blog posts yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php if ($post['image_path']): ?><img src="<?php echo htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt=""><?php endif; ?></td>
                <td><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo $post['is_published'] ? 'Published' : 'Draft'; ?></td>
                <td><?php echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="blog-form.php?id=<?php echo (int) $post['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="post" action="blog-delete.php" style="display:inline;" onsubmit="return confirm('Delete this blog post? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int) $post['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
