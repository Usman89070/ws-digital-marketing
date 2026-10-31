<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
require_once __DIR__ . '/includes/seo-fields.php';
seo_require_tables();
$pdo = get_db();

$isPost = ($_GET['type'] ?? $_POST['type'] ?? 'post') !== 'case';
$table = $isPost ? 'blog_posts' : 'case_studies';
$prefix = $isPost ? '/blog/' : '/case-studies/';
$nameCol = $isPost ? 'title' : 'name';
$descCol = $isPost ? 'excerpt' : 'summary';
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) {
    header('Location: seo-content.php?type=' . ($isPost ? 'posts' : 'cases'));
    exit;
}
$listUrl = 'seo-content.php?type=' . ($isPost ? 'posts' : 'cases');
$hasAltColumn = array_key_exists('image_alt', $item);
$oldSlug = (string) $item['slug'];
$oldPath = $prefix . $oldSlug;
$page_title = 'SEO: ' . $item[$nameCol];

$pageRow = seo_page_row($pdo, $oldPath) ?: [];
$values = array_merge($pageRow, [
    'meta_title' => (string) ($item['meta_title'] ?? ''),
    'meta_description' => (string) ($item['meta_description'] ?? ''),
]);
$slugValue = $oldSlug;
$altValue = (string) ($item['image_alt'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    [$fields, $errors] = seo_collect_page_fields($_POST);
    $slugValue = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower((string) ($_POST['slug'] ?? ''))), '-');
    $altValue = trim((string) ($_POST['image_alt'] ?? ''));
    $values = array_merge($values, $fields);

    if ($slugValue === '') {
        $errors[] = 'The URL can\'t be empty.';
    } elseif ($slugValue !== $oldSlug) {
        $dupe = $pdo->prepare('SELECT id FROM ' . $table . ' WHERE slug = ? AND id <> ?');
        $dupe->execute([$slugValue, $id]);
        if ($dupe->fetch()) {
            $errors[] = 'Another ' . ($isPost ? 'post' : 'case study') . ' already uses the URL "' . $slugValue . '".';
        }
    }

    if ($errors) {
        foreach ($errors as $e) {
            flash_set('error', $e);
        }
    } else {
        $newPath = $prefix . $slugValue;
        $user = (string) $_SESSION['admin_username'];

        // Content-table fields (single source of truth for title/description/alt/URL).
        $sets = ['slug = ?', 'meta_title = ?', 'meta_description = ?'];
        $params = [$slugValue, $fields['meta_title'], $fields['meta_description']];
        if ($hasAltColumn) {
            $sets[] = 'image_alt = ?';
            $params[] = mb_substr($altValue, 0, 255);
        }
        $params[] = $id;
        $pdo->prepare('UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE id = ?')->execute($params);

        // Address changed: keep the page's SEO row and send the old URL to the new one.
        if ($slugValue !== $oldSlug) {
            $pdo->prepare('UPDATE IGNORE page_seo SET path = ? WHERE path = ?')->execute([$newPath, $oldPath]);
            seo_redirect_for_slug_change($oldPath, $newPath, $user);
        }

        // page_seo carries everything else; title/description live on the content row.
        unset($fields['extra_content']);
        $fields['meta_title'] = '';
        $fields['meta_description'] = '';
        seo_page_save($pdo, $newPath, $fields, $user);

        flash_set('success', 'SEO saved.' . ($slugValue !== $oldSlug ? ' The old URL ' . $oldPath . ' now redirects (301) to ' . $newPath . '.' : ''));
        header('Location: ' . $listUrl);
        exit;
    }
}

$defaultDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($item[$descCol] ?? ''))));
include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<p class="muted" style="margin-top:-10px;">
    <a href="<?php echo h(SEO_SITE_BASE . $oldPath); ?>" target="_blank" rel="noopener">View live page &#8599;</a> &middot;
    <a href="<?php echo h($listUrl); ?>">&larr; Back to the list</a>
</p>

<div class="admin-card">
    <form method="post" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="type" value="<?php echo $isPost ? 'post' : 'case'; ?>">

        <div class="section-title">Address &amp; image</div>
        <label for="slug">URL</label>
        <input type="text" id="slug" name="slug" value="<?php echo h($slugValue); ?>" required>
        <div class="hint">Full address: <?php echo h(SEO_SITE_BASE . $prefix); ?><strong><?php echo h($slugValue); ?></strong>. Only lowercase letters, numbers and hyphens. If you change it, a 301 redirect from the old address is created automatically.</div>

        <?php if ($hasAltColumn): ?>
            <label for="image_alt">Main image alt text</label>
            <input type="text" id="image_alt" name="image_alt" value="<?php echo h($altValue); ?>" maxlength="255">
            <div class="hint">Describe what's in the image (e.g. "Plumber repairing a kitchen tap"). Leave it blank only for purely decorative images.</div>
        <?php else: ?>
            <div class="alert alert-warning" style="margin-top:16px;">Image alt text for blog posts needs the one-time database update (<code>seo-dashboard-migration.sql</code>).</div>
        <?php endif; ?>

        <?php seo_render_fields($values, [
            'default_title' => (string) $item[$nameCol],
            'default_desc' => mb_substr($defaultDesc, 0, 160),
            'path' => $prefix . $slugValue,
            'show_extra' => false,
        ]); ?>

        <div style="margin-top:28px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save SEO</button>
            <a href="<?php echo h($listUrl); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php seo_ui_script(); ?>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
