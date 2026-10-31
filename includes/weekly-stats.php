<?php
// Weekly results for case studies, entered week by week from the admin
// ("Weekly Stats" on each case study) and stored in case_study_weekly_stats.
// Each case study's existing stats are imported once as a starting entry
// (is_baseline = 1), so totals carry on from where they were and every new
// week is added on top. Read live on every page load: saving a week in the
// admin updates the case study page, the service pages and the homepage
// totals with no code change.

// Metric column => label shown on the site. Labels for the first four match
// the "Results At A Glance" labels, so weekly totals slot straight into the
// homepage combined stats.
const WEEKLY_METRICS = [
    'organic_clicks' => 'Organic Clicks',
    'search_impressions' => 'Search Impressions',
    'gbp_interactions' => 'GBP Interactions',
    'gbp_calls' => 'Calls From GBP',
    'gbp_directions' => 'Direction Requests',
    'gbp_website_clicks' => 'Website Clicks',
    'gbp_chat_clicks' => 'Chat Clicks',
    'shop_sales' => 'Total Sales',
    'shop_orders' => 'Orders',
    'shop_sessions' => 'Sessions',
];

// The metrics that also count toward the combined stats on the homepage and
// service pages. Shop figures stay on each case study's own page -- adding
// different stores' sales together would not mean much.
const WEEKLY_COMBINED_METRICS = ['organic_clicks', 'search_impressions', 'gbp_interactions', 'gbp_calls', 'gbp_directions', 'gbp_website_clicks', 'gbp_chat_clicks'];

function weekly_stats_create_table_sql(): string
{
    $metricCols = implode(",\n    ", array_map(fn($col) => "$col DECIMAL(14,2) NULL", array_keys(WEEKLY_METRICS)));
    return "CREATE TABLE IF NOT EXISTS case_study_weekly_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    case_study_id INT NOT NULL,
    is_baseline TINYINT(1) NOT NULL DEFAULT 0,
    label VARCHAR(100) NOT NULL DEFAULT '',
    week_start DATE NULL,
    week_end DATE NULL,
    $metricCols,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_case_study (case_study_id)
)";
}

// Reads a number typed in the admin ("312", "1,998", "7.2K", "A$247.9K",
// "0.94%") as a plain number; blank means "not tracked this week".
function parse_weekly_number(?string $v): ?float
{
    $v = trim((string) $v);
    $v = preg_replace('/[^0-9.,kKmM+-]/', '', $v);
    if ($v === '' || !preg_match('/\d/', $v)) {
        return null;
    }
    return parse_stat_number($v);
}

// Display format for a weekly value or total: exact with commas below 10,000
// ("1,998"), then K with one decimal ("247.9K"), then M ("1.25M").
function format_weekly_value(string $metric, float $v): string
{
    $abs = abs($v);
    if ($abs < 10000) {
        $text = number_format($v, $v == floor($v) ? 0 : 2);
    } elseif ($abs < 1000000) {
        $text = rtrim(rtrim(number_format($v / 1000, 1, '.', ''), '0'), '.') . 'K';
    } else {
        $text = rtrim(rtrim(number_format($v / 1000000, 2, '.', ''), '0'), '.') . 'M';
    }
    return $metric === 'shop_sales' ? 'A$' . $text : $text;
}

// Every case study's weekly rows, keyed by case_study_id, starting entry
// first and then weeks in date order. [] if the table can't be read (e.g.
// not set up yet), so pages simply fall back to the manual stats.
function fetch_all_weekly_stats(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    try {
        $rows = get_db()->query('SELECT * FROM case_study_weekly_stats ORDER BY case_study_id ASC, is_baseline DESC, week_start ASC, id ASC')->fetchAll();
    } catch (PDOException $e) {
        return $cache = [];
    }
    $byStudy = [];
    foreach ($rows as $row) {
        $byStudy[(int) $row['case_study_id']][] = $row;
    }
    return $cache = $byStudy;
}

function fetch_weekly_stats(int $caseStudyId): array
{
    return fetch_all_weekly_stats()[$caseStudyId] ?? [];
}

// Totals across every row, plus the latest week and the one before it (for
// the "vs previous week" change). null when there is nothing to show.
function summarise_weekly_stats(array $rows): ?array
{
    if (!$rows) {
        return null;
    }
    $totals = array_fill_keys(array_keys(WEEKLY_METRICS), null);
    // CTR over the total period only uses entries that have both numbers:
    // an entry with clicks but no impressions (common for the starting
    // entry) would otherwise inflate it.
    $rateSums = ['clicks' => 0.0, 'impressions' => 0.0];
    $baseline = null;
    $weeks = [];
    foreach ($rows as $row) {
        $clicks = $row['organic_clicks'] ?? null;
        $impressions = $row['search_impressions'] ?? null;
        if ($clicks !== null && $clicks !== '' && $impressions !== null && $impressions !== '' && (float) $impressions > 0) {
            $rateSums['clicks'] += (float) $clicks;
            $rateSums['impressions'] += (float) $impressions;
        }
        foreach (WEEKLY_METRICS as $metric => $label) {
            $value = $row[$metric] ?? null;
            if ($value !== null && $value !== '') {
                $totals[$metric] = ($totals[$metric] ?? 0) + (float) $value;
            }
        }
        if ((int) $row['is_baseline'] === 1) {
            $baseline = $row;
        } else {
            $weeks[] = $row;
        }
    }
    if (count(array_filter($totals, fn($v) => $v !== null)) === 0) {
        return null;
    }
    $latest = $weeks ? $weeks[count($weeks) - 1] : null;
    $previous = count($weeks) > 1 ? $weeks[count($weeks) - 2] : null;

    $start = $baseline ? ($baseline['label'] !== '' ? $baseline['label'] : 'Before weekly tracking') : format_week_date($weeks[0]['week_start'] ?? null);
    $end = $latest ? format_week_date($latest['week_end'] ?: $latest['week_start']) : '';

    $totals['_ctr'] = $rateSums['impressions'] > 0 ? $rateSums['clicks'] / $rateSums['impressions'] * 100 : null;

    return [
        'totals' => $totals,
        'latest' => $latest,
        'previous' => $previous,
        'period' => $end === '' || $start === $end ? $start : ($baseline ? "$start, plus weekly updates to $end" : "$start – $end"),
        'latest_period' => $latest ? format_week_range($latest['week_start'], $latest['week_end']) : '',
    ];
}

function format_week_date(?string $date): string
{
    $ts = $date ? strtotime($date) : false;
    return $ts ? date('j M Y', $ts) : '';
}

function format_week_range(?string $start, ?string $end): string
{
    $s = $start ? strtotime($start) : false;
    $e = $end ? strtotime($end) : false;
    if (!$s) {
        return '';
    }
    if (!$e || $e === $s) {
        return date('j M Y', $s);
    }
    return date('M', $s) === date('M', $e) ? date('j', $s) . '–' . date('j M Y', $e) : date('j M', $s) . ' – ' . date('j M Y', $e);
}

// The stat boxes for one week (or the totals): [value, label, change] for
// every metric with a value, plus the click-through rate worked
// out from the underlying numbers rather than added up.
function weekly_stat_boxes(array $values, ?array $previous = null): array
{
    $boxes = [];
    foreach (WEEKLY_METRICS as $metric => $label) {
        $v = $values[$metric] ?? null;
        if ($v === null || $v === '') {
            continue;
        }
        $change = null;
        $prev = $previous[$metric] ?? null;
        if ($previous !== null && $prev !== null && $prev !== '' && (float) $prev != 0) {
            $change = ((float) $v - (float) $prev) / (float) $prev * 100;
        }
        $boxes[] = [format_weekly_value($metric, (float) $v), $label, $change];
    }
    // Totals carry their CTR precomputed (_ctr, see summarise_weekly_stats());
    // a single week's CTR comes straight from its own numbers. Conversion
    // rate is deliberately not worked out here: Shopify calculates it its own
    // way (converted sessions, not orders / sessions), so ours would not
    // match the figure clients see in Shopify.
    $ctr = array_key_exists('_ctr', $values) ? $values['_ctr'] : weekly_rate($values['organic_clicks'] ?? null, $values['search_impressions'] ?? null);
    if ($ctr !== null) {
        $boxes[] = [weekly_percent($ctr), 'Average CTR', null];
    }
    return $boxes;
}

function weekly_rate($part, $whole): ?float
{
    if ($part === null || $part === '' || $whole === null || $whole === '' || (float) $whole <= 0) {
        return null;
    }
    return (float) $part / (float) $whole * 100;
}

function weekly_percent(float $v): string
{
    return rtrim(rtrim(number_format($v, 2), '0'), '.') . '%';
}

// A case study's stats for the combined totals: once it has weekly data,
// its weekly totals replace the matching "Results At A Glance" stats; any
// other manual stats (e.g. "Keywords At #1") still count as before.
function case_study_combined_stats(array $row): array
{
    $manual = [];
    foreach ([1, 2, 3, 4] as $n) {
        $value = trim((string) ($row["stat{$n}_value"] ?? ''));
        $label = trim((string) ($row["stat{$n}_label"] ?? ''));
        if ($value !== '' || $label !== '') {
            $manual[] = [$value, $label];
        }
    }
    $summary = isset($row['id']) ? summarise_weekly_stats(fetch_weekly_stats((int) $row['id'])) : null;
    if (!$summary) {
        return $manual;
    }
    $tracked = array_map('strtolower', array_map(fn($m) => WEEKLY_METRICS[$m], WEEKLY_COMBINED_METRICS));
    $stats = array_values(array_filter($manual, fn($s) => !in_array(strtolower($s[1]), $tracked, true)));
    foreach (WEEKLY_COMBINED_METRICS as $metric) {
        if ($summary['totals'][$metric] !== null) {
            $stats[] = [format_weekly_value($metric, $summary['totals'][$metric]), WEEKLY_METRICS[$metric]];
        }
    }
    return $stats;
}

// End date of the most recent week entered for any case study, or null.
function weekly_stats_latest_end(): ?string
{
    $latest = null;
    foreach (fetch_all_weekly_stats() as $rows) {
        foreach ($rows as $row) {
            $end = $row['week_end'] ?: $row['week_start'];
            if (!(int) $row['is_baseline'] && $end && ($latest === null || $end > $latest)) {
                $latest = $end;
            }
        }
    }
    return $latest;
}

// Adds any metric column the table doesn't have yet (e.g. a metric added
// after the table was first set up). Run from the admin's Weekly Stats page.
function weekly_stats_ensure_columns(PDO $pdo): void
{
    foreach (array_keys(WEEKLY_METRICS) as $metric) {
        try {
            $pdo->query("SELECT $metric FROM case_study_weekly_stats LIMIT 1");
        } catch (PDOException $e) {
            $pdo->exec("ALTER TABLE case_study_weekly_stats ADD COLUMN $metric DECIMAL(14,2) NULL");
        }
    }
}

// One-time setup from the admin: creates the table if missing, then gives
// every case study without weekly data a starting entry holding its current
// stats, so totals continue from today's numbers. Safe to run again -- case
// studies that already have weekly rows are left alone. Returns how many
// starting entries were added.
function weekly_stats_setup(PDO $pdo): int
{
    $pdo->exec(weekly_stats_create_table_sql());

    $labelToMetric = [];
    foreach (['organic_clicks', 'search_impressions', 'gbp_interactions', 'gbp_calls'] as $metric) {
        $labelToMetric[strtolower(WEEKLY_METRICS[$metric])] = $metric;
    }
    $existing = $pdo->query('SELECT DISTINCT case_study_id FROM case_study_weekly_stats')->fetchAll(PDO::FETCH_COLUMN);
    $existing = array_map('intval', $existing);

    $cols = array_keys(WEEKLY_METRICS);
    $insert = $pdo->prepare('INSERT INTO case_study_weekly_stats (case_study_id, is_baseline, label, ' . implode(', ', $cols) . ') VALUES (?, 1, ?, ' . implode(', ', array_fill(0, count($cols), '?')) . ')');

    $added = 0;
    foreach ($pdo->query('SELECT * FROM case_studies')->fetchAll() as $study) {
        if (in_array((int) $study['id'], $existing, true)) {
            continue;
        }
        $values = array_fill_keys($cols, null);
        foreach ([1, 2, 3, 4] as $n) {
            $metric = $labelToMetric[strtolower(trim((string) ($study["stat{$n}_label"] ?? '')))] ?? null;
            $number = parse_weekly_number($study["stat{$n}_value"] ?? '');
            if ($metric && $number !== null && stat_value_format((string) $study["stat{$n}_value"]) === 'number') {
                $values[$metric] = $number;
            }
        }
        foreach (['shop_sales' => 'shop_sales', 'shop_orders' => 'shop_orders', 'shop_sessions' => 'shop_sessions'] as $metric => $field) {
            if (isset($study[$field])) {
                $values[$metric] = parse_weekly_number($study[$field]);
            }
        }
        if (count(array_filter($values, fn($v) => $v !== null)) === 0) {
            continue;
        }
        $label = trim((string) ($study['period'] ?? '')) ?: 'Before weekly tracking';
        $insert->execute([(int) $study['id'], mb_substr($label, 0, 100), ...array_values($values)]);
        $added++;
    }
    return $added;
}
