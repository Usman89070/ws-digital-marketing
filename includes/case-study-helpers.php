<?php
// Shared helpers used by every service page that pulls real client work and
// "Results At A Glance" stats live from the case_studies table (index.php and
// the 7 service pages -- seo.php, ecommerce.php, website-development.php,
// ppc-advertising.php, social-media.php, graphic-design.php,
// content-writing.php).

// A case study's tag can be a single label ("Ecommerce") or a slash-separated
// combo ("Ecommerce/SEO/Web Development") so one project can count as real
// client work on every matching service page at once. Matches case-
// insensitively against each "/"-separated segment.
function case_study_tag_has(string $tag, string $keyword): bool
{
    foreach (explode('/', $tag) as $segment) {
        if (stripos(trim($segment), $keyword) !== false) {
            return true;
        }
    }
    return false;
}

// Classifies a stat's raw display string so identically-labelled stats only
// ever get combined when they're actually the same kind of measurement --
// e.g. "10/18" (a ratio) and "36" (a plain count) might both be labelled
// "Keywords At #1" but come from different tracking bases, so they must
// never be summed together into one misleading number.
function stat_value_format(string $v): string
{
    $v = trim($v);
    if (str_ends_with($v, '%')) {
        return 'percent';
    }
    if (preg_match('#^-?[\d,]+(?:\.\d+)?\s*/\s*-?[\d,]+(?:\.\d+)?$#', $v)) {
        return 'ratio';
    }
    if (preg_match('/^[+-]?[\d,]+(?:\.\d+)?\s*[kKmM]?$/', $v)) {
        return 'number';
    }
    return 'text';
}

// Turns a stat's raw display string ("1.63K", "775", "28/33") into a rough
// number for sorting/summing -- the K/M suffix is the only part that
// matters here, everything else just needs to compare/add sensibly.
function parse_stat_number(string $v): float
{
    $v = trim($v);
    if (preg_match('/^([+-]?[\d,]+(?:\.\d+)?)\s*([kKmM]?)/', $v, $m)) {
        $num = (float) str_replace(',', '', $m[1]);
        $suffix = strtolower($m[2]);
        if ($suffix === 'k') {
            $num *= 1000;
        } elseif ($suffix === 'm') {
            $num *= 1000000;
        }
        return $num;
    }
    return 0.0;
}

// Reformats a combined number back into the same K/M display style used
// throughout the site (e.g. "24.1K", "775", "2.67K").
function format_stat_number(float $n): string
{
    $sign = $n < 0 ? '-' : '';
    $abs = abs($n);
    if ($abs >= 1000000) {
        $v = $abs / 1000000;
        $suffix = 'M';
    } elseif ($abs >= 1000) {
        $v = $abs / 1000;
        $suffix = 'K';
    } else {
        $v = $abs;
        $suffix = '';
    }
    $decimals = $suffix === '' ? 0 : ($v < 10 ? 2 : ($v < 100 ? 1 : 0));
    $formatted = $decimals > 0 ? rtrim(rtrim(number_format($v, $decimals, '.', ''), '0'), '.') : number_format($v, 0, '.', '');
    return $sign . $formatted . $suffix;
}

// Combines a flat list of [value, label] stat pairs (gathered across one or
// more case studies) so that stats sharing both the same label AND the same
// value format become a single combined stat, instead of one box per case
// study. Plain numbers are summed, "x/y" ratios have their numerators and
// denominators summed separately, and percentages are averaged. A label
// that appears in more than one format (see stat_value_format()) is never
// merged across formats -- each format-group still gets its own box.
function combine_stats(array $stats): array
{
    $groups = [];
    foreach ($stats as [$value, $label]) {
        $format = stat_value_format($value);
        $key = $label . '|' . $format;
        if (!isset($groups[$key])) {
            $groups[$key] = ['label' => $label, 'format' => $format, 'values' => []];
        }
        $groups[$key]['values'][] = $value;
    }

    $combined = [];
    foreach ($groups as $group) {
        $values = $group['values'];
        if (count($values) === 1) {
            $combined[] = [$values[0], $group['label']];
            continue;
        }
        switch ($group['format']) {
            case 'number':
                $sum = array_sum(array_map('parse_stat_number', $values));
                $combined[] = [format_stat_number($sum), $group['label']];
                break;
            case 'ratio':
                $numSum = 0;
                $denSum = 0;
                foreach ($values as $v) {
                    [$num, $den] = array_map('trim', explode('/', $v, 2));
                    $numSum += (float) str_replace(',', '', $num);
                    $denSum += (float) str_replace(',', '', $den);
                }
                $combined[] = [format_stat_number($numSum) . '/' . format_stat_number($denSum), $group['label']];
                break;
            case 'percent':
                $avg = array_sum(array_map('parse_stat_number', $values)) / count($values);
                $combined[] = [($avg > 0 ? '+' : '') . rtrim(rtrim(number_format($avg, 1, '.', ''), '0'), '.') . '%', $group['label']];
                break;
            default:
                // Mismatched/unrecognised formats under the same label --
                // keep every instance rather than guess at combining them.
                foreach ($values as $v) {
                    $combined[] = [$v, $group['label']];
                }
        }
    }
    return $combined;
}

// The 7 service pages a case study can be shown on, keyed by the slug
// stored in case_studies.related_services (a comma-separated list of these
// keys, or the literal 'none' when no service page is ticked -- the study
// then only appears on /case-studies). Ticked from the "Show on these
// Service Pages" checkboxes in admin/case-form.php.
const CASE_STUDY_SERVICE_PAGES = [
    'seo' => 'SEO',
    'ecommerce' => 'Ecommerce',
    'website-development' => 'Website Development',
    'social-media' => 'Social Media',
    'ppc-advertising' => 'PPC/Paid Advertising',
    'graphic-design' => 'Graphic Design',
    'content-writing' => 'Content Writing',
];

// Turns a stored related_services value into the list of service slugs it
// names. Tolerates spacing/case differences and a few alternate spellings
// (e.g. "ppc", "web-development") so a hand-edited value still matches.
function parse_related_services(?string $value): array
{
    $aliases = [
        'ppc' => 'ppc-advertising',
        'paid-advertising' => 'ppc-advertising',
        'google-ads' => 'ppc-advertising',
        'web-development' => 'website-development',
        'website-design' => 'website-development',
        'web-design' => 'website-development',
        'social-media-marketing' => 'social-media',
    ];
    $slugs = [];
    foreach (explode(',', (string) $value) as $part) {
        $slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(trim($part))), '-');
        $slug = $aliases[$slug] ?? $slug;
        if (isset(CASE_STUDY_SERVICE_PAGES[$slug]) && !in_array($slug, $slugs, true)) {
            $slugs[] = $slug;
        }
    }
    return $slugs;
}

// Every case study ticked to appear on the given service page, in the
// admin's display_order. Returns null (rather than []) if the
// related_services column can't be read, so a page can tell "nothing is
// ticked for me" apart from "the setting isn't available".
function fetch_related_case_studies(string $serviceSlug): ?array
{
    try {
        $rows = get_db()->query('SELECT slug, name, tag, image_path, image_alt, summary, related_services, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label FROM case_studies ORDER BY display_order ASC, name ASC')->fetchAll();
    } catch (PDOException $e) {
        return null;
    }
    return array_values(array_filter(
        $rows,
        fn($row) => in_array($serviceSlug, parse_related_services($row['related_services']), true)
    ));
}

// Flattens the "Results At A Glance" stats (stat1..stat4) of the given case
// study rows into [value, label] pairs, skipping empty slots.
function collect_case_study_stats(array $rows): array
{
    $stats = [];
    foreach ($rows as $row) {
        foreach ([1, 2, 3, 4] as $n) {
            $value = trim((string) ($row["stat{$n}_value"] ?? ''));
            $label = trim((string) ($row["stat{$n}_label"] ?? ''));
            if ($value === '' && $label === '') {
                continue;
            }
            $stats[] = [$value, $label];
        }
    }
    return $stats;
}

// Every case study's "Results At A Glance" stats combined into one set
// (via combine_stats()), read live from the database on each call -- so
// adding, editing or deleting a case study in the admin updates the
// homepage totals with no code change. Sorted so the headline labels come
// first; anything else follows in its original order. Returns [] if the
// database can't be read, letting the caller fall back to placeholders.
function fetch_all_combined_stats(): array
{
    try {
        $rows = get_db()->query('SELECT stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label FROM case_studies ORDER BY display_order ASC, name ASC')->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
    $combined = combine_stats(collect_case_study_stats($rows));

    $priority = ['organic clicks', 'search impressions', 'gbp interactions', 'calls from gbp', 'direction requests', 'website clicks'];
    $rank = function (array $stat) use ($priority): int {
        $pos = array_search(strtolower(trim($stat[1])), $priority, true);
        return $pos === false ? count($priority) : $pos;
    };
    $indexed = [];
    foreach ($combined as $i => $stat) {
        $indexed[] = [$rank($stat), $i, $stat];
    }
    usort($indexed, fn($a, $b) => [$a[0], $a[1]] <=> [$b[0], $b[1]]);
    return array_map(fn($item) => $item[2], $indexed);
}

// The case studies a service page shows: those ticked for it in the admin.
// $blurbs (slug => short page-specific blurb) is the page's older curated
// list -- its studies keep that order and blurb ahead of any newly ticked
// ones, which follow in display_order with their own summary. If the
// related_services setting can't be read, the page falls back to its
// curated list alone, so it never ends up blank.
function service_page_case_studies(string $serviceSlug, array $blurbs = []): array
{
    $related = fetch_related_case_studies($serviceSlug);
    if ($related === null) {
        try {
            $related = array_values(array_filter(
                get_db()->query('SELECT slug, name, tag, image_path, image_alt, summary, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label FROM case_studies')->fetchAll(),
                fn($row) => isset($blurbs[$row['slug']])
            ));
        } catch (PDOException $e) {
            return [];
        }
    }
    $order = array_flip(array_keys($blurbs));
    $indexed = [];
    foreach ($related as $i => $row) {
        if (isset($blurbs[$row['slug']])) {
            $row['summary'] = $blurbs[$row['slug']];
        }
        $indexed[] = [$order[$row['slug']] ?? count($order), $i, $row];
    }
    usort($indexed, fn($a, $b) => [$a[0], $a[1]] <=> [$b[0], $b[1]]);
    return array_map(fn($item) => $item[2], $indexed);
}
