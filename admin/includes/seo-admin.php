<?php
// Helpers shared by the admin SEO screens. Include AFTER auth.php.
require_once __DIR__ . '/../../includes/seo.php';
require_once __DIR__ . '/../../includes/site-pages.php';

function h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// ------------------------------------------------------------------- flashes

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flash_render(): void
{
    foreach ($_SESSION['flash'] ?? [] as $flash) {
        echo '<div class="alert alert-' . h($flash['type']) . '">' . h($flash['message']) . '</div>';
    }
    unset($_SESSION['flash']);
}

// ------------------------------------------------------------------ database

// The SEO screens need the tables from seo-dashboard-migration.sql. If any is
// missing, show how to set them up instead of a database error.
function seo_require_tables(): void
{
    global $page_title;
    $missing = [];
    foreach (['page_seo', 'redirects', 'not_found_log', 'site_settings'] as $table) {
        try {
            get_db()->query('SELECT 1 FROM ' . $table . ' LIMIT 1');
        } catch (PDOException $e) {
            $missing[] = $table;
        }
    }
    if (!$missing) {
        return;
    }
    include __DIR__ . '/layout-header.php';
    echo '<div class="alert alert-warning">The SEO tools need a one-time database setup (missing: <strong>' . h(implode(', ', $missing)) . '</strong>).</div>'
        . '<div class="admin-card"><p>Open <strong>hPanel &rarr; Databases &rarr; phpMyAdmin</strong>, choose this site\'s database, go to the <strong>SQL</strong> tab, paste the contents of '
        . '<code>seo-dashboard-migration.sql</code> and click <strong>Go</strong>. Then reload this page.</p></div>';
    include __DIR__ . '/layout-footer.php';
    exit;
}

// ---------------------------------------------------------------- page_seo

const SEO_CHANGEFREQ = ['', 'always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];

function seo_page_row(PDO $pdo, string $path): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM page_seo WHERE path = ? LIMIT 1');
    $stmt->execute([$path]);
    return $stmt->fetch() ?: null;
}

// Rows of page_seo keyed by path, optionally limited to paths starting with $prefix.
function seo_page_rows(PDO $pdo): array
{
    $rows = [];
    foreach ($pdo->query('SELECT * FROM page_seo') as $row) {
        $rows[$row['path']] = $row;
    }
    return $rows;
}

// True when a page_seo row changes nothing from the defaults.
function seo_row_is_default(array $row): bool
{
    foreach (['meta_title', 'meta_description', 'canonical_url', 'og_title', 'og_description', 'og_image', 'sitemap_priority', 'sitemap_changefreq'] as $f) {
        if (($row[$f] ?? '') !== '') {
            return false;
        }
    }
    foreach (['no_suffix', 'noindex', 'nofollow'] as $f) {
        if (!empty($row[$f])) {
            return false;
        }
    }
    if ((int) ($row['in_sitemap'] ?? 1) !== 1) {
        return false;
    }
    return trim((string) ($row['schema_json'] ?? '')) === '' && trim((string) ($row['extra_content'] ?? '')) === '';
}

// Validates + normalises submitted page SEO fields. Returns [fields, errors].
function seo_collect_page_fields(array $post): array
{
    $errors = [];
    $f = [];
    $f['meta_title'] = trim((string) ($post['meta_title'] ?? ''));
    $f['meta_description'] = trim((string) ($post['meta_description'] ?? ''));
    $f['no_suffix'] = isset($post['no_suffix']) ? 1 : 0;
    $f['noindex'] = isset($post['noindex']) ? 1 : 0;
    $f['nofollow'] = isset($post['nofollow']) ? 1 : 0;
    $f['og_title'] = trim((string) ($post['og_title'] ?? ''));
    $f['og_description'] = trim((string) ($post['og_description'] ?? ''));

    foreach (['canonical_url' => 'Canonical URL', 'og_image' => 'Share image URL'] as $key => $label) {
        $value = trim((string) ($post[$key] ?? ''));
        if ($value === '') {
            $f[$key] = '';
        } elseif (($clean = seo_clean_target($value)) === null) {
            $errors[] = $label . ' must be a full URL (https://...) or a path starting with /.';
            $f[$key] = '';
        } else {
            $f[$key] = $clean;
        }
    }

    $f['in_sitemap'] = isset($post['in_sitemap']) ? 1 : 0;
    $priority = trim((string) ($post['sitemap_priority'] ?? ''));
    if ($priority !== '' && !preg_match('/^(?:0(?:\.\d)?|1(?:\.0)?)$/', $priority)) {
        $errors[] = 'Sitemap priority must be a number from 0.0 to 1.0.';
        $priority = '';
    }
    $f['sitemap_priority'] = $priority;
    $freq = trim((string) ($post['sitemap_changefreq'] ?? ''));
    if (!in_array($freq, SEO_CHANGEFREQ, true)) {
        $freq = '';
    }
    $f['sitemap_changefreq'] = $freq;

    $schema = seo_validate_json((string) ($post['schema_json'] ?? ''));
    if ($schema === null) {
        $errors[] = 'The structured data (JSON-LD) is not valid JSON, so it was not saved.';
        $schema = '';
    }
    $f['schema_json'] = $schema;
    $f['extra_content'] = seo_clean_extra_html((string) ($post['extra_content'] ?? ''));
    return [$f, $errors];
}

// Inserts or updates the page_seo row for $path with the given fields only.
function seo_page_save(PDO $pdo, string $path, array $fields, string $user): void
{
    $allowed = ['meta_title', 'meta_description', 'no_suffix', 'canonical_url', 'noindex', 'nofollow', 'og_title', 'og_description',
                'og_image', 'in_sitemap', 'sitemap_priority', 'sitemap_changefreq', 'schema_json', 'extra_content'];
    $cols = [];
    $vals = [];
    foreach ($fields as $key => $value) {
        if (in_array($key, $allowed, true)) {
            $cols[] = $key;
            $vals[] = $value;
        }
    }
    $cols[] = 'updated_by';
    $vals[] = substr($user, 0, 50);
    $placeholders = implode(', ', array_fill(0, count($cols) + 1, '?'));
    $update = implode(', ', array_map(fn($c) => "$c = VALUES($c)", $cols));
    $stmt = $pdo->prepare('INSERT INTO page_seo (path, ' . implode(', ', $cols) . ') VALUES (' . $placeholders . ') ON DUPLICATE KEY UPDATE ' . $update);
    $stmt->execute(array_merge([$path], $vals));
}

// ---------------------------------------------------------------- redirects

// Adds (or updates) a redirect. Returns an error message, or null on success.
function seo_redirect_save(PDO $pdo, string $from, string $to, int $code, string $note, string $user): ?string
{
    $fromPath = seo_clean_path($from);
    if ($fromPath === null || $fromPath === '/') {
        return 'The "from" address must be a path on this site, like /old-page (the homepage can\'t be redirected).';
    }
    if (!in_array($code, [301, 302, 307, 308, 410], true)) {
        return 'Pick a valid redirect type.';
    }
    $toValue = '';
    if ($code !== 410) {
        $toClean = seo_clean_target($to);
        if ($toClean === null) {
            return 'The destination must be a path starting with / or a full https:// URL.';
        }
        $toValue = $toClean;
        if (strpos(seo_abs_url($toValue), SEO_SITE_BASE) === 0 && seo_normalize_path(seo_abs_url($toValue)) === $fromPath) {
            return 'A redirect can\'t point to its own address.';
        }
    }
    $stmt = $pdo->prepare(
        'INSERT INTO redirects (from_path, to_url, status_code, note, created_by) VALUES (?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE to_url = VALUES(to_url), status_code = VALUES(status_code), note = VALUES(note), is_active = 1'
    );
    $stmt->execute([$fromPath, $toValue, $code, substr($note, 0, 255), substr($user, 0, 50)]);
    // A URL that now has a redirect is no longer an open 404.
    $pdo->prepare('UPDATE not_found_log SET status = \'fixed\' WHERE path = ?')->execute([$fromPath]);
    return null;
}

// Called when a post / case study's address changes, so old links keep working.
function seo_redirect_for_slug_change(string $oldPath, string $newPath, string $user): void
{
    if ($oldPath === $newPath || $oldPath === '' || $newPath === '') {
        return;
    }
    try {
        seo_redirect_save(get_db(), $oldPath, $newPath, 301, 'Auto-created: address changed', $user);
        // And don't leave a redirect pointing at the old address back at itself.
        get_db()->prepare('DELETE FROM redirects WHERE from_path = ?')->execute([$newPath]);
    } catch (Throwable $e) {
        // The SEO tables may not exist yet; the save itself must still succeed.
    }
}

// ------------------------------------------------------------------ settings

function seo_setting_save(PDO $pdo, string $key, string $value): void
{
    $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)')
        ->execute([$key, $value]);
}

// ----------------------------------------------------------------- UI bits

// Live character counters ([data-counter="60"] on an input) and the Google
// result preview ([data-serp-title|desc|url]). Print once per page, at the end.
function seo_ui_script(): void
{
    static $printed = false;
    if ($printed) {
        return;
    }
    $printed = true;
    echo <<<'HTML'
<script>
(function () {
    function update(el) {
        var max = parseInt(el.getAttribute('data-counter'), 10);
        var min = parseInt(el.getAttribute('data-counter-min') || '0', 10);
        var label = el.previousElementSibling;
        var span = label && label.querySelector ? label.querySelector('.counter') : null;
        if (!span) { return; }
        var n = el.value.length;
        span.textContent = n + ' / ' + max;
        span.className = 'counter' + (n > max ? ' over' : (n >= min && n > 0 ? ' good' : ''));
    }
    document.querySelectorAll('[data-counter]').forEach(function (el) {
        update(el);
        el.addEventListener('input', function () { update(el); refreshSerp(); });
    });
    function refreshSerp() {
        var box = document.querySelector('.serp-preview');
        if (!box) { return; }
        var t = document.querySelector('[data-serp-title]');
        var d = document.querySelector('[data-serp-desc]');
        var suffix = box.getAttribute('data-suffix') || '';
        var noSuffix = document.querySelector('[name=no_suffix]');
        var title = (t && t.value) || box.getAttribute('data-default-title') || '';
        if (!(noSuffix && noSuffix.checked)) { title += suffix; }
        var desc = (d && d.value) || box.getAttribute('data-default-desc') || '';
        box.querySelector('.serp-title').textContent = title;
        box.querySelector('.serp-desc').textContent = desc.length > 160 ? desc.slice(0, 157) + '...' : desc;
    }
    document.querySelectorAll('[name=no_suffix]').forEach(function (el) { el.addEventListener('change', refreshSerp); });
    refreshSerp();
})();
</script>
HTML;
}
