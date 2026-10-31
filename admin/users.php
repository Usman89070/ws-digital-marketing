<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Users & Access';
$pdo = get_db();
$me = (int) $_SESSION['admin_id'];

// The role/active columns come from seo-dashboard-migration.sql.
try {
    $pdo->query('SELECT role, is_active, last_login_at FROM admin_users LIMIT 1');
} catch (PDOException $e) {
    include __DIR__ . '/includes/layout-header.php';
    echo '<div class="alert alert-warning">User roles need the one-time database setup first. Run <code>seo-dashboard-migration.sql</code> in phpMyAdmin (SQL tab), then reload this page.</div>';
    include __DIR__ . '/includes/layout-footer.php';
    exit;
}

const ROLE_LABELS = ['admin' => 'Administrator (everything)', 'seo' => 'SEO Manager (SEO tools only)'];

function active_admin_count(PDO $pdo, int $exceptId = 0): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM admin_users WHERE role = \'admin\' AND is_active = 1 AND id <> ?');
    $stmt->execute([$exceptId]);
    return (int) $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = (string) ($_POST['action'] ?? '');
    $targetId = (int) ($_POST['id'] ?? 0);

    if ($action === 'create') {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $role = (string) ($_POST['role'] ?? 'seo');
        if (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $username)) {
            flash_set('error', 'Username must be 3-50 characters: letters, numbers, dots, dashes or underscores.');
        } elseif (strlen($password) < 10) {
            flash_set('error', 'Password must be at least 10 characters.');
        } elseif (!isset(ROLE_LABELS[$role])) {
            flash_set('error', 'Pick a valid role.');
        } else {
            $exists = $pdo->prepare('SELECT id FROM admin_users WHERE username = ?');
            $exists->execute([$username]);
            if ($exists->fetch()) {
                flash_set('error', 'That username is already taken.');
            } else {
                $pdo->prepare('INSERT INTO admin_users (username, password_hash, role) VALUES (?, ?, ?)')
                    ->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role]);
                flash_set('success', 'User "' . $username . '" created as ' . ROLE_LABELS[$role] . '. Share the username and password with them securely.');
            }
        }
    } elseif ($targetId > 0) {
        $stmt = $pdo->prepare('SELECT id, username, role, is_active FROM admin_users WHERE id = ?');
        $stmt->execute([$targetId]);
        $target = $stmt->fetch();
        if (!$target) {
            flash_set('error', 'User not found.');
        } elseif ($action === 'role') {
            $role = (string) ($_POST['role'] ?? '');
            if (!isset(ROLE_LABELS[$role])) {
                flash_set('error', 'Pick a valid role.');
            } elseif ($target['role'] === 'admin' && $role !== 'admin' && $target['is_active'] && active_admin_count($pdo, $targetId) < 1) {
                flash_set('error', 'You can\'t remove the last active administrator.');
            } else {
                $pdo->prepare('UPDATE admin_users SET role = ? WHERE id = ?')->execute([$role, $targetId]);
                flash_set('success', 'Role updated for "' . $target['username'] . '".');
            }
        } elseif ($action === 'toggle') {
            if ($targetId === $me) {
                flash_set('error', 'You can\'t disable your own account.');
            } elseif ($target['role'] === 'admin' && $target['is_active'] && active_admin_count($pdo, $targetId) < 1) {
                flash_set('error', 'You can\'t disable the last active administrator.');
            } else {
                $pdo->prepare('UPDATE admin_users SET is_active = ? WHERE id = ?')->execute([$target['is_active'] ? 0 : 1, $targetId]);
                flash_set('success', '"' . $target['username'] . '" is now ' . ($target['is_active'] ? 'disabled' : 'active') . '.');
            }
        } elseif ($action === 'password') {
            $password = (string) ($_POST['password'] ?? '');
            if (strlen($password) < 10) {
                flash_set('error', 'Password must be at least 10 characters.');
            } else {
                $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $targetId]);
                flash_set('success', 'Password reset for "' . $target['username'] . '".');
            }
        } elseif ($action === 'delete') {
            if ($targetId === $me) {
                flash_set('error', 'You can\'t delete your own account.');
            } elseif ($target['role'] === 'admin' && $target['is_active'] && active_admin_count($pdo, $targetId) < 1) {
                flash_set('error', 'You can\'t delete the last active administrator.');
            } else {
                $pdo->prepare('DELETE FROM admin_users WHERE id = ?')->execute([$targetId]);
                flash_set('success', 'User "' . $target['username'] . '" deleted.');
            }
        }
    }
    header('Location: users.php');
    exit;
}

$users = $pdo->query('SELECT id, username, role, is_active, last_login_at, created_at FROM admin_users ORDER BY id ASC')->fetchAll();

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    <strong>Administrator</strong> can manage everything (blog posts, case studies, team, reviews, users, and all SEO tools).
    <strong>SEO Manager</strong> only sees the SEO tools &mdash; pages SEO, posts &amp; case studies SEO, redirects, 404 errors, robots.txt, sitemap, image SEO and site code &mdash;
    and can't edit content, reviews, team members or other users. Disabling a user cuts off their access immediately.
</div>

<div class="table-scroll">
<table class="admin-table">
    <thead>
        <tr><th>Username</th><th>Role</th><th>Status</th><th>Last login</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): $isMe = (int) $u['id'] === $me; ?>
        <tr>
            <td><strong><?php echo h($u['username']); ?></strong><?php echo $isMe ? ' <span class="badge badge-info">You</span>' : ''; ?></td>
            <td>
                <form method="post" style="display:flex; gap:6px; align-items:center;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="role">
                    <input type="hidden" name="id" value="<?php echo (int) $u['id']; ?>">
                    <select name="role" style="padding:6px 8px; border:1px solid var(--border); border-radius:6px;">
                        <?php foreach (ROLE_LABELS as $value => $label): ?>
                            <option value="<?php echo h($value); ?>" <?php echo $u['role'] === $value ? 'selected' : ''; ?>><?php echo h($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                </form>
            </td>
            <td><?php echo $u['is_active'] ? '<span class="badge badge-ok">Active</span>' : '<span class="badge badge-bad">Disabled</span>'; ?></td>
            <td class="muted"><?php echo $u['last_login_at'] ? h($u['last_login_at']) : 'Never'; ?></td>
            <td>
                <form method="post" style="display:inline-flex; gap:6px; align-items:center;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="password">
                    <input type="hidden" name="id" value="<?php echo (int) $u['id']; ?>">
                    <input type="password" name="password" placeholder="New password (10+)" minlength="10" required autocomplete="new-password" style="padding:6px 8px; border:1px solid var(--border); border-radius:6px; width:160px;">
                    <button type="submit" class="btn btn-secondary btn-sm">Reset</button>
                </form>
                <?php if (!$isMe): ?>
                <form method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?php echo (int) $u['id']; ?>">
                    <button type="submit" class="btn btn-secondary btn-sm"><?php echo $u['is_active'] ? 'Disable' : 'Enable'; ?></button>
                </form>
                <form method="post" onsubmit="return confirm('Delete this user permanently?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int) $u['id']; ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<div class="admin-card" style="max-width: 520px; margin-top: 24px;">
    <h2 style="margin-top:0; font-size:1.1rem;">Add a user</h2>
    <form method="post" class="admin-form" autocomplete="off">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="action" value="create">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required pattern="[A-Za-z0-9._-]{3,50}" autocomplete="off">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="10" autocomplete="new-password">
        <div class="hint">At least 10 characters. Share it with the person securely, and ask them to change it from "My Password" after their first login.</div>
        <label for="role">Role</label>
        <select id="role" name="role">
            <?php foreach (ROLE_LABELS as $value => $label): ?>
                <option value="<?php echo h($value); ?>" <?php echo $value === 'seo' ? 'selected' : ''; ?>><?php echo h($label); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Create User</button>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
