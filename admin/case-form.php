<?php
require_once __DIR__ . '/includes/auth.php';
$pdo = get_db();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$study = [
    'name' => '', 'tag' => '', 'image_path' => '', 'image_alt' => '',
    'summary' => '', 'services' => '', 'has_data' => 0, 'period' => '',
    'stat1_value' => '', 'stat1_label' => '', 'stat2_value' => '', 'stat2_label' => '',
    'stat3_value' => '', 'stat3_label' => '', 'stat4_value' => '', 'stat4_label' => '',
    'display_order' => 0,
];
$error = '';

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM case_studies WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        header('Location: case-list.php');
        exit;
    }
    $study = $existing;
}

$page_title = $id ? 'Edit Case Study' : 'Add Case Study';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $study['name'] = trim($_POST['name'] ?? '');
    $study['tag'] = trim($_POST['tag'] ?? '');
    $study['image_alt'] = trim($_POST['image_alt'] ?? '');
    $study['summary'] = trim($_POST['summary'] ?? '');
    $servicesLines = preg_split('/\r\n|\r|\n/', trim($_POST['services'] ?? ''));
    $study['services'] = implode("\n", array_filter(array_map('trim', $servicesLines), fn($l) => $l !== ''));
    $study['period'] = trim($_POST['period'] ?? '');
    foreach ([1, 2, 3, 4] as $n) {
        $study["stat{$n}_value"] = trim($_POST["stat{$n}_value"] ?? '');
        $study["stat{$n}_label"] = trim($_POST["stat{$n}_label"] ?? '');
    }
    // The "Results At A Glance" section shows if the checkbox is ticked OR
    // any stat is actually filled in -- either one is enough. This keeps the
    // manual checkbox as an explicit override, while fixing the original bug
    // where filling in stats but forgetting to also tick the checkbox meant
    // the saved stats silently never appeared on the live page.
    $study['has_data'] = isset($_POST['has_data']) ? 1 : 0;
    foreach ([1, 2, 3, 4] as $n) {
        if ($study["stat{$n}_value"] !== '' || $study["stat{$n}_label"] !== '') {
            $study['has_data'] = 1;
            break;
        }
    }
    $study['display_order'] = (int) ($_POST['display_order'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');

    if ($study['name'] === '') {
        $error = 'Name is required.';
    } else {
        try {
            $uploaded = handle_image_upload('image_file', 'images/case-studies', $study['name']);
            if ($uploaded) {
                $study['image_path'] = $uploaded;
            } elseif ($imageUrl !== '') {
                $study['image_path'] = $imageUrl;
            }

            // Slug: derived from the name, made unique by appending -2/-3/... if
            // needed -- same pattern as blog posts. It powers /case-studies/<slug>.
            $baseSlug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($study['name'])), '-') ?: 'case-study';
            $slug = $baseSlug;
            $suffix = 2;
            while (true) {
                $check = $pdo->prepare('SELECT id FROM case_studies WHERE slug = ? AND id != ?');
                $check->execute([$slug, $id]);
                if (!$check->fetch()) {
                    break;
                }
                $slug = $baseSlug . '-' . $suffix;
                $suffix++;
            }

            $params = [
                $study['name'], $slug, $study['tag'], $study['image_path'], $study['image_alt'],
                $study['summary'], $study['services'], $study['has_data'], $study['period'],
                $study['stat1_value'], $study['stat1_label'], $study['stat2_value'], $study['stat2_label'],
                $study['stat3_value'], $study['stat3_label'], $study['stat4_value'], $study['stat4_label'],
                $study['display_order'],
            ];

            if ($id) {
                $stmt = $pdo->prepare('UPDATE case_studies SET name=?, slug=?, tag=?, image_path=?, image_alt=?, summary=?, services=?, has_data=?, period=?, stat1_value=?, stat1_label=?, stat2_value=?, stat2_label=?, stat3_value=?, stat3_label=?, stat4_value=?, stat4_label=?, display_order=? WHERE id=?');
                $stmt->execute([...$params, $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO case_studies (name, slug, tag, image_path, image_alt, summary, services, has_data, period, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label, display_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute($params);
            }
            header('Location: case-list.php?saved=1');
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

        <label for="name">Client / Project Name</label>
        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($study['name'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="tag">Tag (short label shown on the card, e.g. "Full Suite", "Local SEO")</label>
        <input type="text" id="tag" name="tag" value="<?php echo htmlspecialchars($study['tag'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="summary">Summary (HTML allowed -- e.g. &lt;p&gt;, &lt;strong&gt;, &lt;a&gt;, &lt;ul&gt;&lt;li&gt;)</label>
        <textarea id="summary" name="summary" rows="6"><?php echo htmlspecialchars($study['summary'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        <div class="hint">Shown in full (with formatting) on the case study's own page. The listing card and "More Client Work" preview automatically strip any HTML and show plain text only.</div>

        <label for="services">Services Delivered (one per line)</label>
        <textarea id="services" name="services" rows="6"><?php echo htmlspecialchars($study['services'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="image_file">Proof Image (upload)</label>
        <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp">
        <div class="hint">JPG, PNG, or WEBP, up to 5MB. Leave blank to keep the current image.</div>

        <label for="image_url">...or paste an image URL instead</label>
        <input type="url" id="image_url" name="image_url" placeholder="https://example.com/photo.jpg">

        <?php if ($study['image_path']): ?>
            <div class="current-image">
                <div class="hint">Current image:</div>
                <img src="<?php echo htmlspecialchars($study['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="" onerror="this.style.display='none'">
            </div>
        <?php endif; ?>

        <label for="image_alt">Image Alt Text</label>
        <input type="text" id="image_alt" name="image_alt" value="<?php echo htmlspecialchars($study['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">

        <label style="display:flex; align-items:center; gap:8px; margin-top:20px;">
            <input type="checkbox" name="has_data" value="1" style="width:auto;" <?php echo $study['has_data'] ? 'checked' : ''; ?>>
            Show a "Results At A Glance" stats section on the detail page
        </label>
        <div class="hint">Optional -- filling in any stat below turns this on automatically anyway, even if left unchecked. Use this to force the section on/off explicitly.</div>

        <label for="period">Reporting Period (shown next to the stats below once any are filled in)</label>
        <input type="text" id="period" name="period" placeholder="e.g. 20 Jul – 20 Aug 2026" value="<?php echo htmlspecialchars($study['period'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="hint" style="margin-top:16px;">Up to 4 result stats (value + label), e.g. value "282" label "Organic Clicks". Leave all four blank (and the checkbox above unchecked) to show a "results coming soon" note instead.</div>
        <?php foreach ([1, 2, 3, 4] as $n): ?>
            <div style="display:flex; gap:10px; margin-top:8px;">
                <input type="text" name="stat<?php echo $n; ?>_value" placeholder="Value" value="<?php echo htmlspecialchars($study["stat{$n}_value"], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="stat<?php echo $n; ?>_label" placeholder="Label" value="<?php echo htmlspecialchars($study["stat{$n}_label"], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        <?php endforeach; ?>

        <label for="display_order" style="margin-top:20px;">Display Order (lower numbers appear first)</label>
        <input type="number" id="display_order" name="display_order" value="<?php echo (int) $study['display_order']; ?>">

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Case Study</button>
        <a href="case-list.php" class="btn btn-secondary" style="margin-top:20px;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
