<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Posts & Case Studies SEO';
seo_require_tables();
$pdo = get_db();

$type = ($_GET['type'] ?? 'posts') === 'cases' ? 'cases' : 'posts';
$search = trim((string) ($_GET['q'] ?? ''));
$overrides = seo_page_rows($pdo);

// image_alt on blog_posts arrives with the SEO migration; fall back gracefully.
if ($type === 'posts') {
    try {
        $items = $pdo->query('SELECT id, title AS name, slug, is_published AS live, meta_title, meta_description, image_path, image_alt FROM blog_posts ORDER BY created_at DESC')->fetchAll();
    } catch (PDOException $e) {
        $items = $pdo->query('SELECT id, title AS name, slug, is_published AS live, meta_title, meta_description, image_path, \'\' AS image_alt FROM blog_posts ORDER BY created_at DESC')->fetchAll();
    }
    $prefix = '/blog/';
} else {
    $items = $pdo->query('SELECT id, name, slug, 1 AS live, meta_title, meta_description, image_path, image_alt FROM case_studies ORDER BY display_order ASC, name ASC')->fetchAll();
    $prefix = '/case-studies/';
}
if ($search !== '') {
    $items = array_filter($items, fn($i) => stripos($i['name'] . ' ' . $i['slug'], $search) !== false);
}

// Duplicate meta titles are an SEO problem worth flagging.
$titleCounts = [];
foreach ($items as $i) {
    $t = strtolower(trim($i['meta_title'] !== '' ? $i['meta_title'] : $i['name']));
    $titleCounts[$t] = ($titleCounts[$t] ?? 0) + 1;
}

function content_badge(string $text, int $min, int $max): string
{
    $n = mb_strlen($text);
    if ($n === 0) {
        return '<span class="badge badge-bad">missing</span>';
    }
    return '<span class="badge ' . (($n > $max || $n < $min) ? 'badge-warn' : 'badge-ok') . '">' . $n . '</span>';
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="tabs">
    <a href="?type=posts" class="<?php echo $type === 'posts' ? 'active' : ''; ?>">Blog Posts</a>
    <a href="?type=cases" class="<?php echo $type === 'cases' ? 'active' : ''; ?>">Case Studies</a>
</div>
<div class="help-box">
    Edit the <strong>meta title, meta description, URL, image alt text, canonical, noindex and share tags</strong> for each <?php echo $type === 'posts' ? 'blog post' : 'case study'; ?> &mdash; without touching its content.
    If you change a URL, a 301 redirect from the old address is created automatically so no link or ranking is lost.
</div>

<form method="get" class="filter-bar">
    <input type="hidden" name="type" value="<?php echo h($type); ?>">
    <input type="text" name="q" value="<?php echo h($search); ?>" placeholder="Search...">
    <button type="submit" class="btn btn-secondary btn-sm">Search</button>
</form>

<div class="table-scroll">
<table class="admin-table">
    <thead>
        <tr><th><?php echo $type === 'posts' ? 'Post' : 'Case study'; ?></th><th>Meta title</th><th>Meta description</th><th>Image alt</th><th>Flags</th><th></th></tr>
    </thead>
    <tbody>
    <?php if (!$items): ?>
        <tr><td colspan="6">Nothing found.</td></tr>
    <?php endif; ?>
    <?php foreach ($items as $i):
        $path = $prefix . $i['slug'];
        $ov = $overrides[$path] ?? null;
        $effTitle = $i['meta_title'] !== '' ? $i['meta_title'] : $i['name'];
        $dup = ($titleCounts[strtolower(trim($effTitle))] ?? 0) > 1;
    ?>
        <tr>
            <td><strong><?php echo h($i['name']); ?></strong><?php echo $type === 'posts' && !$i['live'] ? ' <span class="badge badge-warn">Draft</span>' : ''; ?><br><span class="path muted"><?php echo h($path); ?></span></td>
            <td class="clip" title="<?php echo h($effTitle); ?>"><?php echo h($effTitle); ?><br><?php echo content_badge($effTitle, 25, 60); ?> <?php echo $i['meta_title'] === '' ? '<span class="badge">from title</span>' : ''; ?> <?php echo $dup ? '<span class="badge badge-bad">duplicate</span>' : ''; ?></td>
            <td class="clip" title="<?php echo h($i['meta_description']); ?>"><?php echo $i['meta_description'] !== '' ? h($i['meta_description']) : '<span class="muted">(uses excerpt / summary)</span>'; ?><br><?php echo content_badge($i['meta_description'], 70, 160); ?></td>
            <td><?php if ($i['image_path'] === ''): ?><span class="muted">no image</span><?php elseif ($i['image_alt'] === ''): ?><span class="badge badge-bad">missing</span><?php else: ?><span class="badge badge-ok">set</span><?php endif; ?></td>
            <td>
                <?php if ($ov && $ov['noindex']): ?><span class="badge badge-bad">noindex</span> <?php endif; ?>
                <?php if ($ov && $ov['canonical_url'] !== ''): ?><span class="badge badge-info">canonical</span> <?php endif; ?>
                <?php if ($ov && !$ov['in_sitemap']): ?><span class="badge badge-warn">not in sitemap</span><?php endif; ?>
            </td>
            <td><a href="seo-content-form.php?type=<?php echo h($type === 'posts' ? 'post' : 'case'); ?>&id=<?php echo (int) $i['id']; ?>" class="btn btn-secondary btn-sm">Edit SEO</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
