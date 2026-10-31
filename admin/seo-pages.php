<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Pages SEO';
seo_require_tables();
$pdo = get_db();

// "Add a custom address" jumps straight to the edit form for that path.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    csrf_check();
    $custom = seo_clean_path((string) ($_POST['custom_path'] ?? ''));
    if ($custom === null || strpos($custom, '/admin') === 0) {
        flash_set('error', 'Enter a valid path on this site, like /landing-page or /blog/my-post.');
        header('Location: seo-pages.php');
    } else {
        header('Location: seo-page-form.php?path=' . rawurlencode($custom));
    }
    exit;
}

$overrides = seo_page_rows($pdo);
$catalog = site_static_pages();
$knownPaths = array_column($catalog, 'path');
$search = trim((string) ($_GET['q'] ?? ''));
$groupFilter = (string) ($_GET['group'] ?? '');
$groups = array_values(array_unique(array_column($catalog, 'group')));

$rows = [];
foreach ($catalog as $page) {
    $ov = $overrides[$page['path']] ?? null;
    $def = site_page_defaults($page['path']);
    $rows[] = [
        'path' => $page['path'], 'label' => $page['label'], 'group' => $page['group'], 'ov' => $ov,
        'title' => ($ov['meta_title'] ?? '') !== '' ? $ov['meta_title'] : (string) $def['title'],
        'desc' => ($ov['meta_description'] ?? '') !== '' ? $ov['meta_description'] : (string) $def['description'],
        'titleCustom' => ($ov['meta_title'] ?? '') !== '', 'descCustom' => ($ov['meta_description'] ?? '') !== '',
    ];
}
// Overrides for addresses that aren't in the standard page list (landing pages etc.)
foreach ($overrides as $path => $ov) {
    if (in_array($path, $knownPaths, true) || strpos($path, '/blog/') === 0 || strpos($path, '/case-studies/') === 0) {
        continue;
    }
    $rows[] = [
        'path' => $path, 'label' => 'Custom address', 'group' => 'Custom', 'ov' => $ov,
        'title' => $ov['meta_title'], 'desc' => $ov['meta_description'],
        'titleCustom' => $ov['meta_title'] !== '', 'descCustom' => $ov['meta_description'] !== '',
    ];
}

$rows = array_filter($rows, function ($r) use ($search, $groupFilter) {
    if ($groupFilter !== '' && $r['group'] !== $groupFilter) {
        return false;
    }
    if ($search !== '' && stripos($r['path'] . ' ' . $r['label'] . ' ' . $r['title'], $search) === false) {
        return false;
    }
    return true;
});

function seo_length_badge(string $text, int $min, int $max): string
{
    $n = mb_strlen($text);
    if ($n === 0) {
        return '<span class="badge badge-bad">missing</span>';
    }
    if ($n > $max || $n < $min) {
        return '<span class="badge badge-warn">' . $n . ' chars</span>';
    }
    return '<span class="badge badge-ok">' . $n . ' chars</span>';
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    Set the <strong>title, meta description, canonical URL, noindex, social-share tags, structured data and an extra copy block</strong> for any page.
    Anything left blank keeps the page's built-in value, and changes go live immediately &mdash; no code deploy needed.
    Page copy that's part of the design (headings, sections) is still edited in the code; use the <em>Extra content block</em> to add keyword text to a page without touching code.
</div>

<form method="get" class="filter-bar">
    <input type="text" name="q" value="<?php echo h($search); ?>" placeholder="Search pages...">
    <select name="group" onchange="this.form.submit()">
        <option value="">All groups</option>
        <?php foreach (array_merge($groups, ['Custom']) as $g): ?>
            <option value="<?php echo h($g); ?>" <?php echo $groupFilter === $g ? 'selected' : ''; ?>><?php echo h($g); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
</form>

<div class="table-scroll">
<table class="admin-table">
    <thead>
        <tr><th>Page</th><th>Title</th><th>Meta description</th><th>Flags</th><th></th></tr>
    </thead>
    <tbody>
    <?php if (!$rows): ?>
        <tr><td colspan="5">No pages match.</td></tr>
    <?php endif; ?>
    <?php foreach ($rows as $r): $ov = $r['ov']; ?>
        <tr>
            <td><strong><?php echo h($r['label']); ?></strong><br><span class="path muted"><?php echo h($r['path']); ?></span><br><span class="badge"><?php echo h($r['group']); ?></span></td>
            <td class="clip" title="<?php echo h($r['title']); ?>"><?php echo $r['title'] !== '' ? h($r['title']) : '<span class="muted">(set in code)</span>'; ?><br>
                <?php echo seo_length_badge($r['title'], 25, 60); ?> <?php echo $r['titleCustom'] ? '<span class="badge badge-info">custom</span>' : ''; ?></td>
            <td class="clip" title="<?php echo h($r['desc']); ?>"><?php echo $r['desc'] !== '' ? h($r['desc']) : '<span class="muted">(set in code)</span>'; ?><br>
                <?php echo seo_length_badge($r['desc'], 70, 160); ?> <?php echo $r['descCustom'] ? '<span class="badge badge-info">custom</span>' : ''; ?></td>
            <td>
                <?php if ($ov && $ov['noindex']): ?><span class="badge badge-bad">noindex</span> <?php endif; ?>
                <?php if ($ov && $ov['nofollow']): ?><span class="badge badge-warn">nofollow</span> <?php endif; ?>
                <?php if ($ov && $ov['canonical_url'] !== ''): ?><span class="badge badge-info">canonical</span> <?php endif; ?>
                <?php if ($ov && trim((string) $ov['schema_json']) !== ''): ?><span class="badge badge-info">schema</span> <?php endif; ?>
                <?php if ($ov && trim((string) $ov['extra_content']) !== ''): ?><span class="badge badge-info">content</span> <?php endif; ?>
                <?php if ($ov && !$ov['in_sitemap']): ?><span class="badge badge-warn">not in sitemap</span><?php endif; ?>
            </td>
            <td><a href="seo-page-form.php?path=<?php echo rawurlencode($r['path']); ?>" class="btn btn-secondary btn-sm">Edit SEO</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<div class="admin-card" style="max-width:560px; margin-top:24px;">
    <strong>Add SEO settings for any other address</strong>
    <p class="muted" style="font-size:0.85rem;">For a landing page, or any URL that isn't in the list above (blog posts and case studies have their own screen under "Posts &amp; Case Studies").</p>
    <form method="post" class="admin-form" style="display:flex; gap:10px;">
        <?php echo csrf_field(); ?>
        <input type="text" name="custom_path" placeholder="/my-landing-page" required>
        <button type="submit" class="btn btn-primary" style="white-space:nowrap;">Edit this address</button>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
