<?php
require_once __DIR__ . '/includes/auth.php';
$page_title = 'Account';
$pdo = get_db();
$message = '';
$messageType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $current = (string) ($_POST['current_password'] ?? '');
    $new = (string) ($_POST['new_password'] ?? '');
    $confirm = (string) ($_POST['confirm_password'] ?? '');

    $stmt = $pdo->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($current, $row['password_hash'])) {
        $message = 'Current password is incorrect.';
        $messageType = 'error';
    } elseif (strlen($new) < 8) {
        $message = 'New password must be at least 8 characters.';
        $messageType = 'error';
    } elseif ($new !== $confirm) {
        $message = 'New password and confirmation do not match.';
        $messageType = 'error';
    } else {
        $stmt = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
        $stmt->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['admin_id']]);
        $message = 'Password updated successfully.';
        $messageType = 'success';
    }
}

include __DIR__ . '/includes/layout-header.php';
?>
<?php if ($message): ?>
    <div class="alert alert-<?php echo $messageType; ?>"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="admin-card" style="max-width: 420px;">
    <form method="post" class="admin-form">
        <?php echo csrf_field(); ?>
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" required>
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" required minlength="8">
        <div class="hint">At least 8 characters.</div>
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Update Password</button>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
