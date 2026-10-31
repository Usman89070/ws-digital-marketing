<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Sitemap';
seo_require_tables();
$pdo = get_db();
$user = (string) $_SESSION['admin_username'];

// Every URL the sitemap can contain, with its default priority / frequency.
$entries = [];
foreach (site_static_pages() as $p) {
    $entries[] = ['path' => $p['path'], 'label' => $p['label'], 'group' => $p['group'], 'priority' => $p['priority'], 'freq' => $p['freq']];
}
foreach ($pdo->query('SELECT slug, name FROM case_studies ORDER BY display_order ASC, name ASC') as $cs) {
    $entries[] = ['path' => '/case-studies/' . $cs['slug'], 'label' => $cs['name'], 'group' => 'Case studies', 'priority' => '0.7', 'freq' => 'monthly'];
}
foreach ($pdo->query('SELECT slug, title FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC') as $bp) {
    $entries[] = ['path' => '/blog/' . $bp['slug'], 'label' => $bp['title'], 'group' => 'Blog posts', 'priority' => '0.6', 'freq' => 'monthly'];
}
$overrides = seo_page_rows($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $rows = $_POST['rows'] ?? [];
    $changed = 0;
    foreach ($entries as $e) {
        $key = md5($e['path']);
        $in = isset($rows[$key]['in_sitemap']) ? 1 : 0;
        $priority = trim((string) ($rows[$key]['priority'] ?? ''));
        $freq = (string) ($rows[$key]['freq'] ?? '');
        if ($priority !== '' && !preg_match('/^(?:0(?:\.\d)?|1(?:\.0)?)$/', $priority)) {
            $priority = '';
        }
        if (!in_array($freq, SEO_CHANGEFREQ, true)) {
            $freq = '';
        }
        $ov = $overrides[$e['path']] ?? null;
        $isDefault = $in === 1 && $priority === '' && $freq === '';
        $unchanged = $ov
            ? ((int) $ov['in_sitemap'] === $in && $ov['sitemap_priority'] === $priority && $ov['sitemap_changefreq'] === $freq)
            : $isDefault;
        if ($unchanged) {
            continue;
        }
        seo_page_save($pdo, $e['path'], ['in_sitemap' => $in, 'sitemap_priority' => $priority, 'sitemap_changefreq' => $freq], $user);
        $changed++;
    }
    flash_set('success', $changed ? 'Sitemap settings saved (' . $changed . ' page' . ($changed === 1 ? '' : 's') . ' changed). The live sitemap.xml is updated.' : 'No changes to save.');
    header('Location: seo-sitemap.php');
    exit;
}

$included = 0;
foreach ($entries as $e) {
    $ov = $overrides[$e['path']] ?? null;
    if (!$ov || ((int) $ov['in_sitemap'] === 1 && (int) $ov['noindex'] === 0)) {
        $included++;
    }
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    <strong>sitemap.xml</strong> is generated live from your pages, case studies and published blog posts &mdash; new ones appear automatically.
    Use the table to leave a page out, or change its priority / change frequency. Pages set to <strong>noindex</strong> are always left out.
    View it at <a href="/sitemap.xml" target="_blank" rel="noopener"><?php echo h(SEO_SITE_BASE); ?>/sitemap.xml</a> &middot; <strong><?php echo $included; ?></strong> of <?php echo count($entries); ?> URLs are currently included.
    To get new pages crawled faster, submit the sitemap in Google Search Console &rarr; Sitemaps.
</div>

<form method="post" class="admin-form">
    <?php echo csrf_field(); ?>
    <div class="table-scroll">
    <table class="admin-table">
        <thead><tr><th style="width:60px;">In sitemap</th><th>Page</th><th>Group</th><th style="width:110px;">Priority</th><th style="width:140px;">Change frequency</th></tr></thead>
        <tbody>
        <?php foreach ($entries as $e):
            $ov = $overrides[$e['path']] ?? null;
            $key = md5($e['path']);
            $noindex = $ov && (int) $ov['noindex'] === 1;
            $inSitemap = !$ov || (int) $ov['in_sitemap'] === 1;
        ?>
            <tr>
                <td><input type="checkbox" name="rows[<?php echo $key; ?>][in_sitemap]" value="1" <?php echo $inSitemap ? 'checked' : ''; ?>></td>
                <td><strong><?php echo h($e['label']); ?></strong> <?php echo $noindex ? '<span class="badge badge-bad">noindex &mdash; excluded</span>' : ''; ?><br><span class="path muted"><?php echo h($e['path']); ?></span></td>
                <td><span class="badge"><?php echo h($e['group']); ?></span></td>
                <td><input type="text" name="rows[<?php echo $key; ?>][priority]" value="<?php echo h($ov['sitemap_priority'] ?? ''); ?>" placeholder="<?php echo h($e['priority']); ?>" style="width:80px; padding:7px 9px; border:1px solid var(--border); border-radius:6px;"></td>
                <td>
                    <select name="rows[<?php echo $key; ?>][freq]" style="padding:7px 8px; border:1px solid var(--border); border-radius:6px;">
                        <?php foreach (SEO_CHANGEFREQ as $f): ?>
                            <option value="<?php echo h($f); ?>" <?php echo ($ov['sitemap_changefreq'] ?? '') === $f ? 'selected' : ''; ?>><?php echo $f === '' ? 'Default (' . h($e['freq']) . ')' : h(ucfirst($f)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Sitemap Settings</button>
</form>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
