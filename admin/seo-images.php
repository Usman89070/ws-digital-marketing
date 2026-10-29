<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Image SEO';
$pdo = get_db();

$hasBlogAlt = true;
try {
    $pdo->query('SELECT image_alt FROM blog_posts LIMIT 1');
} catch (PDOException $e) {
    $hasBlogAlt = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $changed = 0;
    if ($hasBlogAlt) {
        $cur = [];
        foreach ($pdo->query('SELECT id, image_alt FROM blog_posts') as $r) {
            $cur[(int) $r['id']] = (string) $r['image_alt'];
        }
        $upd = $pdo->prepare('UPDATE blog_posts SET image_alt = ? WHERE id = ?');
        foreach ($_POST['blog_alt'] ?? [] as $id => $alt) {
            $alt = mb_substr(trim((string) $alt), 0, 255);
            if (isset($cur[(int) $id]) && $cur[(int) $id] !== $alt) {
                $upd->execute([$alt, (int) $id]);
                $changed++;
            }
        }
    }
    $cur = [];
    foreach ($pdo->query('SELECT id, image_alt FROM case_studies') as $r) {
        $cur[(int) $r['id']] = (string) $r['image_alt'];
    }
    $upd = $pdo->prepare('UPDATE case_studies SET image_alt = ? WHERE id = ?');
    foreach ($_POST['case_alt'] ?? [] as $id => $alt) {
        $alt = mb_substr(trim((string) $alt), 0, 255);
        if (isset($cur[(int) $id]) && $cur[(int) $id] !== $alt) {
            $upd->execute([$alt, (int) $id]);
            $changed++;
        }
    }
    flash_set('success', $changed ? 'Alt text saved for ' . $changed . ' image' . ($changed === 1 ? '' : 's') . '.' : 'No changes to save.');
    header('Location: seo-images.php');
    exit;
}

$blog = $hasBlogAlt
    ? $pdo->query("SELECT id, title AS name, slug, image_path, image_alt FROM blog_posts WHERE image_path <> '' ORDER BY created_at DESC")->fetchAll()
    : $pdo->query("SELECT id, title AS name, slug, image_path, '' AS image_alt FROM blog_posts WHERE image_path <> '' ORDER BY created_at DESC")->fetchAll();
$cases = $pdo->query("SELECT id, name, slug, image_path, image_alt FROM case_studies WHERE image_path <> '' ORDER BY display_order ASC, name ASC")->fetchAll();

// Local file facts for an image path: [exists, bytes] (null for external URLs).
function seo_image_file(string $path): ?array
{
    if (preg_match('#^https?://#i', $path)) {
        return null;
    }
    $file = realpath(__DIR__ . '/..' . $path);
    $root = realpath(__DIR__ . '/..');
    if ($file === false || $root === false || strpos($file, $root) !== 0 || !is_file($file)) {
        return [false, 0];
    }
    return [true, (int) filesize($file)];
}

function seo_image_row(array $item, string $field, ?string $note = null): void
{
    $file = seo_image_file($item['image_path']);
    $alt = (string) $item['image_alt'];
    $isLocal = $file !== null;
    ?>
    <tr>
        <td><?php if (!$isLocal || $file[0]): ?><img src="<?php echo $isLocal ? h($item['image_path']) : h($item['image_path']); ?>" alt="" loading="lazy" onerror="this.style.visibility='hidden'"><?php endif; ?></td>
        <td><strong><?php echo h($item['name']); ?></strong><br><span class="path muted"><?php echo h(basename(parse_url($item['image_path'], PHP_URL_PATH) ?: $item['image_path'])); ?></span></td>
        <td class="num">
            <?php if ($file === null): ?><span class="badge">external</span>
            <?php elseif (!$file[0]): ?><span class="badge badge-bad">file missing</span>
            <?php else: $kb = round($file[1] / 1024); ?><span class="badge <?php echo $kb > 100 ? 'badge-warn' : 'badge-ok'; ?>"><?php echo $kb; ?> KB</span><?php endif; ?>
        </td>
        <td style="min-width:300px;"><input type="text" name="<?php echo h($field); ?>[<?php echo (int) $item['id']; ?>]" value="<?php echo h($alt); ?>" maxlength="255" placeholder="Describe the image..." style="width:100%; padding:8px 10px; border:1px solid var(--border); border-radius:6px;"></td>
        <td><?php
            if ($alt === '') { echo '<span class="badge badge-bad">no alt</span>'; }
            elseif (mb_strlen($alt) < 10) { echo '<span class="badge badge-warn">too short</span>'; }
            elseif (preg_match('/\.(jpe?g|png|webp)$/i', $alt) || preg_match('/^(img|image|dsc|screenshot)[-_ ]?\d*/i', $alt)) { echo '<span class="badge badge-warn">looks like a filename</span>'; }
            else { echo '<span class="badge badge-ok">good</span>'; }
        ?></td>
    </tr>
    <?php
}

// ---- Static page image audit (read-only): <img> tags in the page templates.
function seo_static_image_audit(): array
{
    $found = [];
    $files = glob(__DIR__ . '/../*.php') ?: [];
    foreach ($files as $file) {
        $name = basename($file);
        if (in_array($name, ['config.php', 'config.sample.php', 'cache-reset.php', 'sitemap.php', 'robots.php'], true)) {
            continue;
        }
        $src = @file_get_contents($file);
        if ($src === false) {
            continue;
        }
        // Blank out the embedded PHP tags (keeping line numbers) so PHP inside an
        // attribute can't be mistaken for the end of the img tag.
        $collapsed = preg_replace_callback('/<\?(?:php|=).*?\?>/s', fn($m) => 'PHP' . str_repeat("\n", substr_count($m[0], "\n")), $src);
        if (!preg_match_all('/<img\b[^>]*>/i', $collapsed, $matches, PREG_OFFSET_CAPTURE)) {
            continue;
        }
        foreach ($matches[0] as [$tag, $offset]) {
            $hasAlt = (bool) preg_match('/\balt\s*=/i', $tag);
            $emptyAlt = (bool) preg_match('/\balt\s*=\s*(""|\'\')/', $tag);
            if ($hasAlt && !$emptyAlt) {
                continue;
            }
            preg_match('/\bsrc\s*=\s*["\']([^"\']*)["\']/i', $tag, $sm);
            $found[] = [
                'file' => $name,
                'line' => substr_count(substr($collapsed, 0, $offset), "\n") + 1,
                'src' => $sm[1] ?? '(dynamic)',
                'kind' => $hasAlt ? 'empty' : 'missing',
            ];
        }
    }
    usort($found, fn($a, $b) => [$a['kind'] === 'missing' ? 0 : 1, $a['file'], $a['line']] <=> [$b['kind'] === 'missing' ? 0 : 1, $b['file'], $b['line']]);
    return $found;
}
$audit = seo_static_image_audit();
$auditMissing = count(array_filter($audit, fn($a) => $a['kind'] === 'missing'));

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    <strong>Alt text</strong> describes an image for people using screen readers and helps Google understand (and rank) it in image search.
    Write a short, natural description &mdash; not a filename and not keyword stuffing. Below you can edit alt text for blog post and case study images,
    see each image's file size (the site's rule is under 100&nbsp;KB), and check the images that are hard-coded into page templates.
</div>
<?php if (!$hasBlogAlt): ?>
    <div class="alert alert-warning">Alt text for blog posts needs the one-time database update (<code>seo-dashboard-migration.sql</code>). Case study alt text works already.</div>
<?php endif; ?>

<form method="post" class="admin-form">
    <?php echo csrf_field(); ?>
    <h2 style="font-size:1.05rem;">Blog post images (<?php echo count($blog); ?>)</h2>
    <div class="table-scroll"><table class="admin-table">
        <thead><tr><th></th><th>Post / file</th><th class="num">Size</th><th>Alt text</th><th>Check</th></tr></thead>
        <tbody>
        <?php if (!$blog): ?><tr><td colspan="5">No blog post images.</td></tr><?php endif; ?>
        <?php foreach ($blog as $item) { seo_image_row($item, 'blog_alt'); } ?>
        </tbody>
    </table></div>

    <h2 style="font-size:1.05rem; margin-top:28px;">Case study images (<?php echo count($cases); ?>)</h2>
    <div class="table-scroll"><table class="admin-table">
        <thead><tr><th></th><th>Case study / file</th><th class="num">Size</th><th>Alt text</th><th>Check</th></tr></thead>
        <tbody>
        <?php if (!$cases): ?><tr><td colspan="5">No case study images.</td></tr><?php endif; ?>
        <?php foreach ($cases as $item) { seo_image_row($item, 'case_alt'); } ?>
        </tbody>
    </table></div>
    <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Alt Text</button>
</form>

<h2 style="font-size:1.05rem; margin-top:36px;">Images in page templates (read-only audit)</h2>
<p class="muted" style="font-size:0.88rem;">
    <?php echo $auditMissing; ?> image<?php echo $auditMissing === 1 ? ' has' : 's have'; ?> <strong>no alt attribute at all</strong> (fix these first), and <?php echo count($audit) - $auditMissing; ?> have an <em>empty</em> alt (correct only for purely decorative images).
    These are written in the page code, so send the list to the developer to change.
</p>
<div class="table-scroll"><table class="admin-table">
    <thead><tr><th>File</th><th>Line</th><th>Image</th><th>Issue</th></tr></thead>
    <tbody>
    <?php if (!$audit): ?><tr><td colspan="4">All template images have alt text.</td></tr><?php endif; ?>
    <?php foreach (array_slice($audit, 0, 200) as $a): ?>
        <tr>
            <td class="path"><?php echo h($a['file']); ?></td>
            <td class="num"><?php echo (int) $a['line']; ?></td>
            <td class="path clip" title="<?php echo h($a['src']); ?>"><?php echo h($a['src']); ?></td>
            <td><?php echo $a['kind'] === 'missing' ? '<span class="badge badge-bad">no alt attribute</span>' : '<span class="badge badge-info">empty alt (decorative?)</span>'; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table></div>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
