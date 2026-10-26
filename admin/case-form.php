<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/case-study-helpers.php';
$pdo = get_db();

// "Show on these Service Pages" is stored in case_studies.related_services
// (added by case-studies-related-services-migration.sql). If that column is
// ever missing, the form still saves everything else and says so, rather
// than failing outright.
try {
    $pdo->query('SELECT related_services FROM case_studies LIMIT 1');
    $hasRelatedServices = true;
} catch (PDOException $e) {
    $hasRelatedServices = false;
}

// Shopify store performance fields (case-studies-shopify-stats-migration.sql),
// saved separately for the same reason.
$shopFields = ['shop_period', 'shop_sales', 'shop_sales_growth', 'shop_sessions', 'shop_sessions_growth', 'shop_orders', 'shop_orders_growth', 'shop_conversion', 'shop_conversion_growth', 'shop_image'];
try {
    $pdo->query('SELECT shop_sales FROM case_studies LIMIT 1');
    $hasShopFields = true;
} catch (PDOException $e) {
    $hasShopFields = false;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$study = [
    'name' => '', 'tag' => '', 'image_path' => '', 'image_alt' => '',
    'summary' => '', 'services' => '', 'has_data' => 0, 'period' => '',
    'stat1_value' => '', 'stat1_label' => '', 'stat2_value' => '', 'stat2_label' => '',
    'stat3_value' => '', 'stat3_label' => '', 'stat4_value' => '', 'stat4_label' => '',
    'display_order' => 0, 'meta_title' => '', 'meta_description' => '',
    'gsc_clicks' => '', 'gsc_impressions' => '', 'gsc_ctr' => '', 'gsc_position' => '', 'gsc_image' => '',
    'gsc_ai_value' => '', 'gsc_ai_image' => '',
    'gbp_interactions' => '', 'gbp_calls' => '', 'gbp_calls_image' => '',
    'gbp_directions' => '', 'gbp_directions_image' => '',
    'gbp_website_clicks' => '', 'gbp_website_image' => '', 'gbp_image' => '',
    'gbp_extra_label' => '', 'gbp_extra_value' => '', 'gbp_extra_image' => '',
    'related_services' => 'none',
];
foreach ($shopFields as $field) {
    $study[$field] = '';
}
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
    $study['meta_title'] = trim($_POST['meta_title'] ?? '');
    $study['meta_description'] = trim($_POST['meta_description'] ?? '');
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
    // Only known service slugs are kept; nothing ticked is stored as 'none'
    // (the study then only appears on /case-studies).
    $ticked = array_values(array_intersect(array_keys(CASE_STUDY_SERVICE_PAGES), (array) ($_POST['related_services'] ?? [])));
    $study['related_services'] = $ticked ? implode(',', $ticked) : 'none';
    foreach ($shopFields as $field) {
        $study[$field] = trim($_POST[$field] ?? '');
    }
    $study['gsc_clicks'] = trim($_POST['gsc_clicks'] ?? '');
    $study['gsc_impressions'] = trim($_POST['gsc_impressions'] ?? '');
    $study['gsc_ctr'] = trim($_POST['gsc_ctr'] ?? '');
    $study['gsc_position'] = trim($_POST['gsc_position'] ?? '');
    $study['gsc_image'] = trim($_POST['gsc_image'] ?? '');
    $study['gsc_ai_value'] = trim($_POST['gsc_ai_value'] ?? '');
    $study['gsc_ai_image'] = trim($_POST['gsc_ai_image'] ?? '');
    $study['gbp_interactions'] = trim($_POST['gbp_interactions'] ?? '');
    $study['gbp_calls'] = trim($_POST['gbp_calls'] ?? '');
    $study['gbp_calls_image'] = trim($_POST['gbp_calls_image'] ?? '');
    $study['gbp_directions'] = trim($_POST['gbp_directions'] ?? '');
    $study['gbp_directions_image'] = trim($_POST['gbp_directions_image'] ?? '');
    $study['gbp_website_clicks'] = trim($_POST['gbp_website_clicks'] ?? '');
    $study['gbp_website_image'] = trim($_POST['gbp_website_image'] ?? '');
    $study['gbp_image'] = trim($_POST['gbp_image'] ?? '');
    $study['gbp_extra_label'] = trim($_POST['gbp_extra_label'] ?? '');
    $study['gbp_extra_value'] = trim($_POST['gbp_extra_value'] ?? '');
    $study['gbp_extra_image'] = trim($_POST['gbp_extra_image'] ?? '');
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
                $study['display_order'], $study['meta_title'], $study['meta_description'],
                $study['gsc_clicks'], $study['gsc_impressions'], $study['gsc_ctr'], $study['gsc_position'], $study['gsc_image'],
                $study['gsc_ai_value'], $study['gsc_ai_image'],
                $study['gbp_interactions'], $study['gbp_calls'], $study['gbp_calls_image'],
                $study['gbp_directions'], $study['gbp_directions_image'],
                $study['gbp_website_clicks'], $study['gbp_website_image'], $study['gbp_image'],
                $study['gbp_extra_label'], $study['gbp_extra_value'], $study['gbp_extra_image'],
            ];

            if ($hasRelatedServices && $id) {
                $stmt = $pdo->prepare('UPDATE case_studies SET related_services=? WHERE id=?');
                $stmt->execute([$study['related_services'], $id]);
            }
            if ($hasShopFields && $id) {
                $stmt = $pdo->prepare('UPDATE case_studies SET ' . implode('=?, ', $shopFields) . '=? WHERE id=?');
                $stmt->execute([...array_map(fn($f) => $study[$f], $shopFields), $id]);
            }
            if ($id) {
                $stmt = $pdo->prepare('UPDATE case_studies SET name=?, slug=?, tag=?, image_path=?, image_alt=?, summary=?, services=?, has_data=?, period=?, stat1_value=?, stat1_label=?, stat2_value=?, stat2_label=?, stat3_value=?, stat3_label=?, stat4_value=?, stat4_label=?, display_order=?, meta_title=?, meta_description=?, gsc_clicks=?, gsc_impressions=?, gsc_ctr=?, gsc_position=?, gsc_image=?, gsc_ai_value=?, gsc_ai_image=?, gbp_interactions=?, gbp_calls=?, gbp_calls_image=?, gbp_directions=?, gbp_directions_image=?, gbp_website_clicks=?, gbp_website_image=?, gbp_image=?, gbp_extra_label=?, gbp_extra_value=?, gbp_extra_image=? WHERE id=?');
                $stmt->execute([...$params, $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO case_studies (name, slug, tag, image_path, image_alt, summary, services, has_data, period, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label, display_order, meta_title, meta_description, gsc_clicks, gsc_impressions, gsc_ctr, gsc_position, gsc_image, gsc_ai_value, gsc_ai_image, gbp_interactions, gbp_calls, gbp_calls_image, gbp_directions, gbp_directions_image, gbp_website_clicks, gbp_website_image, gbp_image, gbp_extra_label, gbp_extra_value, gbp_extra_image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute($params);
                $newId = (int) $pdo->lastInsertId();
                if ($hasRelatedServices) {
                    $stmt = $pdo->prepare('UPDATE case_studies SET related_services=? WHERE id=?');
                    $stmt->execute([$study['related_services'], $newId]);
                }
                if ($hasShopFields) {
                    $stmt = $pdo->prepare('UPDATE case_studies SET ' . implode('=?, ', $shopFields) . '=? WHERE id=?');
                    $stmt->execute([...array_map(fn($f) => $study[$f], $shopFields), $newId]);
                }
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

        <div class="hint" style="margin-top:24px; font-weight:700;">Google Search Console Performance (optional separate section, shown below the stats above)</div>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gsc_clicks" placeholder="Organic Clicks (e.g. 886)" value="<?php echo htmlspecialchars($study['gsc_clicks'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gsc_impressions" placeholder="Search Impressions (e.g. 152K)" value="<?php echo htmlspecialchars($study['gsc_impressions'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gsc_ctr" placeholder="Average CTR, no % sign (e.g. 0.6)" value="<?php echo htmlspecialchars($study['gsc_ctr'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gsc_position" placeholder="Average Position (e.g. 23.9)" value="<?php echo htmlspecialchars($study['gsc_position'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <input type="text" name="gsc_image" placeholder="/images/case-studies/your-screenshot.png (Search Performance proof screenshot)" style="margin-top:8px;" value="<?php echo htmlspecialchars($study['gsc_image'], ENT_QUOTES, 'UTF-8'); ?>">
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gsc_ai_value" placeholder="AI Overview Impressions (e.g. 6.56K)" value="<?php echo htmlspecialchars($study['gsc_ai_value'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gsc_ai_image" placeholder="/images/case-studies/your-screenshot.png (Generative AI features proof)" value="<?php echo htmlspecialchars($study['gsc_ai_image'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="hint" style="margin-top:24px; font-weight:700;">Google Business Profile Performance (optional separate section)</div>
        <input type="text" name="gbp_interactions" placeholder="Total Interactions (e.g. 533)" value="<?php echo htmlspecialchars($study['gbp_interactions'], ENT_QUOTES, 'UTF-8'); ?>">
        <input type="text" name="gbp_image" placeholder="/images/case-studies/your-screenshot.png (Overview proof screenshot)" style="margin-top:8px;" value="<?php echo htmlspecialchars($study['gbp_image'], ENT_QUOTES, 'UTF-8'); ?>">

        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gbp_calls" placeholder="Phone Calls (e.g. 135)" value="<?php echo htmlspecialchars($study['gbp_calls'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gbp_calls_image" placeholder="/images/case-studies/your-screenshot.png (Calls proof)" value="<?php echo htmlspecialchars($study['gbp_calls_image'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gbp_directions" placeholder="Direction Requests (e.g. 254)" value="<?php echo htmlspecialchars($study['gbp_directions'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gbp_directions_image" placeholder="/images/case-studies/your-screenshot.png (Directions proof)" value="<?php echo htmlspecialchars($study['gbp_directions_image'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gbp_website_clicks" placeholder="Website Clicks (e.g. 131)" value="<?php echo htmlspecialchars($study['gbp_website_clicks'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gbp_website_image" placeholder="/images/case-studies/your-screenshot.png (Website Clicks proof)" value="<?php echo htmlspecialchars($study['gbp_website_image'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="hint" style="margin-top:12px;">Optional 5th GBP metric -- varies by business type (e.g. "Chat Clicks" for trades, "Menu Views" for hospitality). Leave the label blank to omit this stat entirely.</div>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <input type="text" name="gbp_extra_label" placeholder="Label (e.g. Chat Clicks)" value="<?php echo htmlspecialchars($study['gbp_extra_label'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gbp_extra_value" placeholder="Value (e.g. 13)" value="<?php echo htmlspecialchars($study['gbp_extra_value'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="gbp_extra_image" placeholder="/images/case-studies/your-screenshot.png (proof)" value="<?php echo htmlspecialchars($study['gbp_extra_image'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="hint" style="margin-top:24px; font-weight:700;">Shopify Store Performance (optional separate section, for online stores)</div>
        <?php if ($hasShopFields): ?>
            <input type="text" name="shop_period" placeholder="Period (e.g. 1 May – 30 Sept 2026 vs previous period)" style="margin-top:8px;" value="<?php echo htmlspecialchars($study['shop_period'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <?php foreach (['shop_sales' => 'Total Sales (e.g. A$247.9K)', 'shop_sessions' => 'Sessions (e.g. 12.2K)', 'shop_orders' => 'Orders (e.g. 1,998)', 'shop_conversion' => 'Conversion Rate (e.g. 0.94%)'] as $field => $placeholder): ?>
                <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
                    <input type="text" name="<?php echo $field; ?>" placeholder="<?php echo htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($study[$field] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="text" name="<?php echo $field; ?>_growth" placeholder="Growth vs previous period (e.g. +228%)" value="<?php echo htmlspecialchars($study[$field . '_growth'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            <?php endforeach; ?>
            <input type="text" name="shop_image" placeholder="/images/case-studies/your-screenshot.jpg (Shopify proof screenshot)" style="margin-top:8px;" value="<?php echo htmlspecialchars($study['shop_image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <div class="hint">Shown as its own section on the case study page. Does not change the homepage combined stats.</div>
        <?php else: ?>
            <div class="hint">Not available yet -- run case-studies-shopify-stats-migration.sql once in phpMyAdmin to enable it.</div>
        <?php endif; ?>

        <div class="hint" style="margin-top:24px; font-weight:700;">Show on these Service Pages</div>
        <?php if ($hasRelatedServices): ?>
            <?php $selectedServices = parse_related_services($study['related_services'] ?? ''); ?>
            <div style="display:flex; flex-wrap:wrap; gap:8px 20px; margin-top:8px;">
                <?php foreach (CASE_STUDY_SERVICE_PAGES as $serviceSlug => $serviceName): ?>
                    <label style="display:flex; align-items:center; gap:8px; margin:0; font-weight:normal;">
                        <input type="checkbox" name="related_services[]" value="<?php echo htmlspecialchars($serviceSlug, ENT_QUOTES, 'UTF-8'); ?>" style="width:auto;" <?php echo in_array($serviceSlug, $selectedServices, true) ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8'); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="hint">This case study appears in the "Client Projects" section of each ticked service page. Leave all unticked to show it only on the main Case Studies page.</div>
        <?php else: ?>
            <div class="hint">Not available yet -- the database is missing the related_services column. Run case-studies-related-services-migration.sql once in phpMyAdmin to enable it.</div>
        <?php endif; ?>

        <label for="display_order" style="margin-top:20px;">Display Order (lower numbers appear first)</label>
        <input type="number" id="display_order" name="display_order" value="<?php echo (int) $study['display_order']; ?>">

        <label for="meta_title" style="margin-top:20px;">SEO Meta Title (optional -- leave blank to use the project name above)</label>
        <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($study['meta_title'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="meta_description">SEO Meta Description (optional -- leave blank to use the summary above)</label>
        <textarea id="meta_description" name="meta_description" rows="3"><?php echo htmlspecialchars($study['meta_description'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Case Study</button>
        <a href="case-list.php" class="btn btn-secondary" style="margin-top:20px;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
