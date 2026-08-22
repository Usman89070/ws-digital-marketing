<?php
require_once __DIR__ . '/includes/auth.php';
$pdo = get_db();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$member = ['name' => '', 'role' => '', 'description' => '', 'photo_path' => '', 'linkedin_url' => '#', 'display_order' => 0];
$error = '';

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM team_members WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        header('Location: team-list.php');
        exit;
    }
    $member = $existing;
}

$page_title = $id ? 'Edit Team Member' : 'Add Team Member';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $member['name'] = trim($_POST['name'] ?? '');
    $member['role'] = trim($_POST['role'] ?? '');
    $member['description'] = trim($_POST['description'] ?? '');
    $member['linkedin_url'] = trim($_POST['linkedin_url'] ?? '') ?: '#';
    $member['display_order'] = (int) ($_POST['display_order'] ?? 0);

    if ($member['name'] === '' || $member['role'] === '') {
        $error = 'Name and role are required.';
    } else {
        try {
            $uploaded = handle_image_upload('photo_file', 'images/team', $member['name']);
            if ($uploaded) {
                $member['photo_path'] = $uploaded;
            }

            if ($id) {
                $stmt = $pdo->prepare('UPDATE team_members SET name=?, role=?, description=?, photo_path=?, linkedin_url=?, display_order=? WHERE id=?');
                $stmt->execute([$member['name'], $member['role'], $member['description'], $member['photo_path'], $member['linkedin_url'], $member['display_order'], $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO team_members (name, role, description, photo_path, linkedin_url, display_order) VALUES (?,?,?,?,?,?)');
                $stmt->execute([$member['name'], $member['role'], $member['description'], $member['photo_path'], $member['linkedin_url'], $member['display_order']]);
            }
            header('Location: team-list.php?saved=1');
            exit;
        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }
    }
}

include __DIR__ . '/includes/layout-header.php';
?>
<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="admin-card">
    <form method="post" enctype="multipart/form-data" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="role">Role / Title</label>
        <input type="text" id="role" name="role" required value="<?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="description">Short Description (one sentence, shown on hover)</label>
        <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($member['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="linkedin_url">LinkedIn URL (optional)</label>
        <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/in/..." value="<?php echo htmlspecialchars($member['linkedin_url'] === '#' ? '' : $member['linkedin_url'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="display_order">Display Order (lower numbers appear first)</label>
        <input type="number" id="display_order" name="display_order" value="<?php echo (int) $member['display_order']; ?>">

        <label for="photo_file">Photo (upload)</label>
        <input type="file" id="photo_file" name="photo_file" accept="image/jpeg,image/png,image/webp">
        <div class="hint">JPG, PNG, or WEBP, up to 5MB. Leave blank to keep the current photo.</div>

        <?php if ($member['photo_path']): ?>
            <div class="current-image">
                <div class="hint">Current photo:</div>
                <img src="<?php echo htmlspecialchars($member['photo_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="" onerror="this.style.display='none'">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Team Member</button>
        <a href="team-list.php" class="btn btn-secondary" style="margin-top:20px;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
