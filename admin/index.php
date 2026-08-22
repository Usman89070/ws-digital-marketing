<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Dashboard';

$pdo = get_db();
$blogCount = (int) $pdo->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
$publishedCount = (int) $pdo->query('SELECT COUNT(*) FROM blog_posts WHERE is_published = 1')->fetchColumn();
$teamCount = (int) $pdo->query('SELECT COUNT(*) FROM team_members')->fetchColumn();

include __DIR__ . '/includes/layout-header.php';
?>
<p>Signed in as <strong><?php echo htmlspecialchars($_SESSION['admin_username'], ENT_QUOTES, 'UTF-8'); ?></strong>.</p>

<div class="dashboard-grid">
    <div class="admin-card">
        <div class="num"><?php echo $blogCount; ?></div>
        <div class="label">Total Blog Posts</div>
    </div>
    <div class="admin-card">
        <div class="num"><?php echo $publishedCount; ?></div>
        <div class="label">Published Posts</div>
    </div>
    <div class="admin-card">
        <div class="num"><?php echo $teamCount; ?></div>
        <div class="label">Team Members</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <p style="margin-top:0;"><a href="blog-form.php" class="btn btn-primary">+ Add Blog Post</a></p>
    <p><a href="team-form.php" class="btn btn-primary">+ Add Team Member</a></p>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
