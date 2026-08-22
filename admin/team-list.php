<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Team Members';
$pdo = get_db();
$members = $pdo->query('SELECT id, name, role, photo_path, display_order FROM team_members ORDER BY display_order ASC, id ASC')->fetchAll();

include __DIR__ . '/includes/layout-header.php';
?>
<?php if (!empty($_GET['deleted'])): ?>
    <div class="alert alert-success">Team member deleted.</div>
<?php endif; ?>
<?php if (!empty($_GET['saved'])): ?>
    <div class="alert alert-success">Team member saved.</div>
<?php endif; ?>

<div class="page-actions">
    <span></span>
    <a href="team-form.php" class="btn btn-primary">+ Add Team Member</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Role</th>
            <th>Order</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$members): ?>
            <tr><td colspan="5">No team members yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?php if ($member['photo_path']): ?><img src="<?php echo htmlspecialchars($member['photo_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="" onerror="this.style.display='none'"><?php endif; ?></td>
                <td><?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo (int) $member['display_order']; ?></td>
                <td>
                    <a href="team-form.php?id=<?php echo (int) $member['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="post" action="team-delete.php" style="display:inline;" onsubmit="return confirm('Delete this team member? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int) $member['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
