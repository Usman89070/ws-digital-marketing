<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Robots.txt';
seo_require_tables();
$pdo = get_db();

$saved = seo_setting('robots_txt');
$content = ($saved !== null && trim($saved) !== '') ? $saved : seo_default_robots();

// A "Disallow: /" that applies to every crawler would remove the whole site from Google.
function robots_blocks_everything(string $txt): bool
{
    $applies = false;
    foreach (preg_split('/\r\n|\r|\n/', $txt) as $line) {
        $line = trim(preg_replace('/#.*/', '', $line));
        if (preg_match('/^user-agent\s*:\s*(.+)$/i', $line, $m)) {
            $applies = trim($m[1]) === '*';
        } elseif ($applies && preg_match('/^disallow\s*:\s*\/\s*$/i', $line)) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'reset') {
        seo_setting_save($pdo, 'robots_txt', '');
        flash_set('success', 'robots.txt reset to the default rules.');
        header('Location: seo-robots.php');
        exit;
    }
    $content = str_replace("\r\n", "\n", (string) ($_POST['robots_txt'] ?? ''));
    if (strlen($content) > 50000) {
        flash_set('error', 'robots.txt is too large (limit 50,000 characters).');
    } elseif (robots_blocks_everything($content) && empty($_POST['confirm_block'])) {
        flash_set('error', 'This file contains "Disallow: /" for all crawlers, which would remove the ENTIRE site from Google. Nothing was saved. Tick the confirmation box if you really mean it.');
    } else {
        seo_setting_save($pdo, 'robots_txt', $content);
        flash_set('success', 'robots.txt saved and live now.');
        header('Location: seo-robots.php');
        exit;
    }
}

$warnings = [];
if (!preg_match('/^\s*Disallow\s*:\s*\/admin\/?\s*$/im', $content)) {
    $warnings[] = 'There is no <code>Disallow: /admin/</code> rule &mdash; the admin login area would be open to crawlers.';
}
if (!preg_match('/^\s*Sitemap\s*:/im', $content)) {
    $warnings[] = 'There is no <code>Sitemap:</code> line &mdash; add <code>Sitemap: ' . h(SEO_SITE_BASE) . '/sitemap.xml</code> so crawlers find your sitemap.';
}
if (robots_blocks_everything($content)) {
    $warnings[] = '<strong>This blocks the entire site for all crawlers.</strong>';
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    This is the live file at <a href="/robots.txt" target="_blank" rel="noopener"><?php echo h(SEO_SITE_BASE); ?>/robots.txt</a>. Changes apply immediately.
    <code>Disallow</code> stops well-behaved crawlers fetching a path (it does <em>not</em> remove an already-indexed page &mdash; use <strong>noindex</strong> in Pages SEO for that).
</div>
<?php foreach ($warnings as $w): ?><div class="alert alert-warning"><?php echo $w; ?></div><?php endforeach; ?>

<div class="admin-card">
    <form method="post" class="admin-form">
        <?php echo csrf_field(); ?>
        <label for="robots_txt">robots.txt</label>
        <textarea id="robots_txt" name="robots_txt" class="mono tall" rows="16" spellcheck="false"><?php echo h($content); ?></textarea>
        <div class="hint">Example rules: <code>User-agent: *</code> &middot; <code>Disallow: /private/</code> &middot; <code>Allow: /</code> &middot; <code>Sitemap: <?php echo h(SEO_SITE_BASE); ?>/sitemap.xml</code></div>
        <?php if (robots_blocks_everything($content)): ?>
            <label class="check"><input type="checkbox" name="confirm_block" value="1"> I understand this blocks the whole site from search engines</label>
        <?php endif; ?>
        <div style="margin-top:20px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save robots.txt</button>
            <?php if ($saved !== null && trim($saved) !== ''): ?>
                <button type="submit" name="action" value="reset" class="btn btn-danger" onclick="return confirm('Replace the file with the default rules?');">Reset to default</button>
            <?php endif; ?>
        </div>
    </form>
</div>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
