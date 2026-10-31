<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
require_once __DIR__ . '/includes/seo-fields.php';
seo_require_tables();
$pdo = get_db();

$path = seo_clean_path((string) ($_GET['path'] ?? $_POST['path'] ?? ''));
if ($path === null || strpos($path, '/admin') === 0) {
    header('Location: seo-pages.php');
    exit;
}

$label = 'Custom address';
foreach (site_static_pages() as $p) {
    if ($p['path'] === $path) {
        $label = $p['label'];
    }
}
$defaults = site_page_defaults($path);
$row = seo_page_row($pdo, $path) ?: [];
$page_title = 'SEO: ' . $label;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'reset') {
        $pdo->prepare('DELETE FROM page_seo WHERE path = ?')->execute([$path]);
        flash_set('success', 'Reset: ' . $path . ' now uses its built-in SEO values.');
        header('Location: seo-pages.php');
        exit;
    }
    [$fields, $errors] = seo_collect_page_fields($_POST);
    if ($errors) {
        foreach ($errors as $e) {
            flash_set('error', $e);
        }
        $row = array_merge($row, $fields);
    } else {
        seo_page_save($pdo, $path, $fields, (string) $_SESSION['admin_username']);
        flash_set('success', 'SEO saved for ' . $path . '. It is live now.');
        header('Location: seo-pages.php');
        exit;
    }
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<p class="muted" style="margin-top:-10px;">
    Address: <span class="path"><?php echo h($path); ?></span> &middot;
    <a href="<?php echo h(SEO_SITE_BASE . ($path === '/' ? '/' : $path)); ?>" target="_blank" rel="noopener">View live page &#8599;</a> &middot;
    <a href="seo-pages.php">&larr; Back to all pages</a>
</p>

<div class="admin-card">
    <form method="post" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="path" value="<?php echo h($path); ?>">
        <?php seo_render_fields($row, [
            'default_title' => (string) $defaults['title'],
            'default_desc' => (string) $defaults['description'],
            'path' => $path,
            'show_extra' => true,
        ]); ?>
        <div style="margin-top:28px; display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" name="action" value="save" class="btn btn-primary">Save SEO</button>
            <a href="seo-pages.php" class="btn btn-secondary">Cancel</a>
            <?php if ($row): ?>
                <button type="submit" name="action" value="reset" class="btn btn-danger" onclick="return confirm('Remove all SEO overrides for this page and go back to its built-in values?');">Reset to defaults</button>
            <?php endif; ?>
        </div>
    </form>
</div>
<?php seo_ui_script(); ?>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
