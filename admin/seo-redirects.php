<?php
require_once __DIR__ . '/includes/auth.php';
require_role(['admin', 'seo']);
require_once __DIR__ . '/includes/seo-admin.php';
$page_title = 'Redirects';
seo_require_tables();
$pdo = get_db();
$user = (string) $_SESSION['admin_username'];

const REDIRECT_TYPES = [301 => '301 Permanent', 302 => '302 Temporary', 307 => '307 Temporary (keep method)', 308 => '308 Permanent (keep method)', 410 => '410 Gone (page removed)'];

if (($_GET['export'] ?? '') === '1') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="redirects.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['from', 'to', 'type', 'active', 'hits', 'note']);
    foreach ($pdo->query('SELECT from_path, to_url, status_code, is_active, hits, note FROM redirects ORDER BY from_path') as $r) {
        fputcsv($out, [$r['from_path'], $r['to_url'], $r['status_code'], $r['is_active'], $r['hits'], $r['note']]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'add') {
        $err = seo_redirect_save($pdo, (string) ($_POST['from'] ?? ''), (string) ($_POST['to'] ?? ''), (int) ($_POST['code'] ?? 301), (string) ($_POST['note'] ?? ''), $user);
        $err ? flash_set('error', $err) : flash_set('success', 'Redirect saved.');
    } elseif ($action === 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare('SELECT from_path FROM redirects WHERE id = ?');
        $stmt->execute([$id]);
        $existing = $stmt->fetchColumn();
        if ($existing === false) {
            flash_set('error', 'Redirect not found.');
        } else {
            $err = seo_redirect_save($pdo, $existing, (string) ($_POST['to'] ?? ''), (int) ($_POST['code'] ?? 301), (string) ($_POST['note'] ?? ''), $user);
            $err ? flash_set('error', $err) : flash_set('success', 'Redirect updated.');
        }
    } elseif ($action === 'toggle') {
        $pdo->prepare('UPDATE redirects SET is_active = 1 - is_active WHERE id = ?')->execute([(int) ($_POST['id'] ?? 0)]);
        flash_set('success', 'Redirect switched.');
    } elseif ($action === 'delete') {
        $pdo->prepare('DELETE FROM redirects WHERE id = ?')->execute([(int) ($_POST['id'] ?? 0)]);
        flash_set('success', 'Redirect deleted.');
    } elseif ($action === 'import') {
        $added = 0;
        $failed = [];
        foreach (preg_split('/\r\n|\r|\n/', (string) ($_POST['bulk'] ?? '')) as $n => $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            $parts = array_map('trim', str_getcsv($line));
            if (count($parts) === 1) {
                $parts = preg_split('/\s+/', $line);
            }
            $code = isset($parts[2]) && ctype_digit($parts[2]) ? (int) $parts[2] : 301;
            $err = seo_redirect_save($pdo, $parts[0] ?? '', $parts[1] ?? '', $code, 'Bulk import', $user);
            $err ? $failed[] = 'Line ' . ($n + 1) . ': ' . $err : $added++;
        }
        flash_set($added ? 'success' : 'error', $added . ' redirect(s) imported.' . ($failed ? ' ' . count($failed) . ' line(s) skipped:' : ''));
        foreach (array_slice($failed, 0, 5) as $f) {
            flash_set('error', $f);
        }
    }
    header('Location: seo-redirects.php' . (isset($_GET['q']) ? '?q=' . rawurlencode($_GET['q']) : ''));
    exit;
}

$search = trim((string) ($_GET['q'] ?? ''));
$perPage = 100;
$pageNum = max(1, (int) ($_GET['page'] ?? 1));
$where = '';
$args = [];
if ($search !== '') {
    $where = 'WHERE from_path LIKE ? OR to_url LIKE ? OR note LIKE ?';
    $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $search) . '%';
    $args = [$like, $like, $like];
}
$countStmt = $pdo->prepare('SELECT COUNT(*) FROM redirects ' . $where);
$countStmt->execute($args);
$total = (int) $countStmt->fetchColumn();
$pages = max(1, (int) ceil($total / $perPage));
$pageNum = min($pageNum, $pages);
$stmt = $pdo->prepare('SELECT * FROM redirects ' . $where . ' ORDER BY updated_at DESC, id DESC LIMIT ' . $perPage . ' OFFSET ' . (($pageNum - 1) * $perPage));
$stmt->execute($args);
$redirects = $stmt->fetchAll();

// Flag chains: a destination that is itself redirected somewhere else.
$allFrom = [];
foreach ($pdo->query('SELECT from_path FROM redirects WHERE is_active = 1') as $r) {
    $allFrom[strtolower($r['from_path'])] = true;
}

include __DIR__ . '/includes/layout-header.php';
flash_render();
?>
<div class="help-box">
    A redirect sends visitors (and Google) from an <strong>old address to a new one</strong>. Use <strong>301</strong> for permanent moves (passes ranking), <strong>302/307</strong> for temporary ones, and <strong>410</strong> to tell Google a page was removed on purpose.
    Redirects apply to addresses that don't exist as a page any more, plus any page you point somewhere else here. When a blog post or case study URL is changed in <em>Posts &amp; Case Studies</em>, its redirect is created for you.
</div>

<div class="admin-card">
    <strong>Add a redirect</strong>
    <form method="post" class="admin-form" style="margin-top:10px;">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="action" value="add">
        <div class="form-grid">
            <div><label for="from">From (old address)</label><input type="text" id="from" name="from" placeholder="/old-page" required></div>
            <div><label for="to">To (new address)</label><input type="text" id="to" name="to" placeholder="/new-page or https://..."></div>
            <div><label for="code">Type</label>
                <select id="code" name="code"><?php foreach (REDIRECT_TYPES as $c => $l): ?><option value="<?php echo $c; ?>"><?php echo h($l); ?></option><?php endforeach; ?></select></div>
            <div><label for="note">Note (optional)</label><input type="text" id="note" name="note" maxlength="255" placeholder="Why this redirect exists"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:16px;">Add Redirect</button>
    </form>
</div>

<form method="get" class="filter-bar">
    <input type="text" name="q" value="<?php echo h($search); ?>" placeholder="Search redirects...">
    <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    <span class="muted"><?php echo $total; ?> redirect<?php echo $total === 1 ? '' : 's'; ?></span>
    <a href="?export=1" class="btn btn-secondary btn-sm" style="margin-left:auto;">Export CSV</a>
</form>

<div class="table-scroll">
<table class="admin-table">
    <thead><tr><th>From</th><th>To</th><th>Type</th><th class="num">Hits</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php if (!$redirects): ?><tr><td colspan="6">No redirects yet.</td></tr><?php endif; ?>
    <?php foreach ($redirects as $r):
        $toPath = $r['to_url'] !== '' ? strtolower(seo_normalize_path(seo_abs_url($r['to_url']))) : '';
        $isChain = $r['status_code'] != 410 && $r['is_active'] && strpos(seo_abs_url($r['to_url']), SEO_SITE_BASE) === 0 && isset($allFrom[$toPath]);
    ?>
        <tr class="inline-edit">
            <td class="path"><?php echo h($r['from_path']); ?><?php echo $r['note'] !== '' ? '<br><span class="muted" style="font-size:0.78rem;">' . h($r['note']) . '</span>' : ''; ?></td>
            <td colspan="2">
                <form method="post" style="display:flex; gap:6px; align-items:center;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>">
                    <input type="hidden" name="note" value="<?php echo h($r['note']); ?>">
                    <input type="text" name="to" value="<?php echo h($r['to_url']); ?>" <?php echo $r['status_code'] == 410 ? 'placeholder="(not needed for 410)"' : ''; ?>>
                    <select name="code" style="padding:7px 8px; border:1px solid var(--border); border-radius:6px;"><?php foreach (REDIRECT_TYPES as $c => $l): ?><option value="<?php echo $c; ?>" <?php echo (int) $r['status_code'] === $c ? 'selected' : ''; ?>><?php echo $c; ?></option><?php endforeach; ?></select>
                    <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                </form>
            </td>
            <td class="num"><?php echo (int) $r['hits']; ?><br><span class="muted" style="font-size:0.75rem;"><?php echo $r['last_hit_at'] ? h(substr($r['last_hit_at'], 0, 10)) : 'never'; ?></span></td>
            <td><?php echo $r['is_active'] ? '<span class="badge badge-ok">Active</span>' : '<span class="badge">Off</span>'; ?><?php echo $isChain ? ' <span class="badge badge-warn" title="The destination is itself redirected. Point this straight at the final page.">chain</span>' : ''; ?></td>
            <td>
                <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>"><button type="submit" class="btn btn-secondary btn-sm"><?php echo $r['is_active'] ? 'Turn off' : 'Turn on'; ?></button></form>
                <form method="post" onsubmit="return confirm('Delete this redirect?');"><?php echo csrf_field(); ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>"><button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php if ($pages > 1): ?>
<div class="tabs" style="margin-top:16px;">
    <?php for ($p = 1; $p <= $pages; $p++): ?>
        <a href="?page=<?php echo $p; ?><?php echo $search !== '' ? '&q=' . rawurlencode($search) : ''; ?>" class="<?php echo $p === $pageNum ? 'active' : ''; ?>"><?php echo $p; ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<div class="admin-card" style="margin-top:24px;">
    <strong>Bulk import</strong>
    <p class="muted" style="font-size:0.85rem;">One redirect per line: <code>/old-url, /new-url</code> &mdash; optionally add a type: <code>/old-url, /new-url, 302</code>. Lines starting with # are ignored.</p>
    <form method="post" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="action" value="import">
        <textarea name="bulk" class="mono" rows="6" placeholder="/old-service, /services&#10;/2019/old-post, /blog/new-post&#10;/discontinued, , 410"></textarea>
        <button type="submit" class="btn btn-secondary" style="margin-top:12px;">Import</button>
    </form>
</div>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
