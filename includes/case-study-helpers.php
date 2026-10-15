<?php
// Shared helpers used by every service page that pulls real client work and
// "Results At A Glance" stats live from the case_studies table (ecommerce.php,
// seo.php, website-development.php, services.php).

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
