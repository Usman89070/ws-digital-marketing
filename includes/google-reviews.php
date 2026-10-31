<?php
// Live Google Business Profile reviews for the homepage.
//
// Reads GOOGLE_PLACES_API_KEY and GOOGLE_PLACE_ID from config.php (see
// config.sample.php). When either is missing, or Google cannot be reached,
// ws_google_reviews() returns null and the homepage falls back to the
// reviews managed in Admin -> Reviews, so the section never breaks.
//
// The answer is cached for an hour, so a new Google review shows on the site
// within the hour with no manual work, and the API is only called a few
// times a day. The Places API returns a maximum of 5 reviews per place.

const WS_GOOGLE_REVIEWS_TTL = 3600;       // fresh for 1 hour
const WS_GOOGLE_REVIEWS_RETRY = 600;      // after a failure, retry in 10 min

function ws_google_reviews_cache_file(): string
{
    $key = defined('GOOGLE_PLACE_ID') ? (string) GOOGLE_PLACE_ID : 'none';
    return rtrim(sys_get_temp_dir(), '/\\') . '/ws-google-reviews-' . md5($key . (defined('DB_NAME') ? DB_NAME : '')) . '.json';
}

// Turns the Places API (New) response into the structure the homepage uses.
function ws_google_reviews_parse(array $data): ?array
{
    $reviews = [];
    foreach ((array) ($data['reviews'] ?? []) as $r) {
        $text = trim((string) ($r['text']['text'] ?? $r['originalText']['text'] ?? ''));
        $rating = (int) ($r['rating'] ?? 0);
        if ($text === '' || $rating < 4) {
            continue; // text-less or low-star reviews are not featured
        }
        $reviews[] = [
            'name'   => trim((string) ($r['authorAttribution']['displayName'] ?? 'Google user')),
            'photo'  => (string) ($r['authorAttribution']['photoUri'] ?? ''),
            'url'    => (string) ($r['authorAttribution']['uri'] ?? ''),
            'rating' => min(5, $rating),
            'time'   => (string) ($r['relativePublishTimeDescription'] ?? ''),
            'text'   => $text,
        ];
    }
    if (!$reviews && empty($data['rating'])) {
        return null;
    }
    return [
        'rating'  => isset($data['rating']) ? round((float) $data['rating'], 1) : null,
        'total'   => (int) ($data['userRatingCount'] ?? 0),
        'maps_url' => (string) ($data['googleMapsUri'] ?? ''),
        'reviews' => $reviews,
    ];
}

function ws_google_reviews_fetch(): ?array
{
    $url = 'https://places.googleapis.com/v1/places/' . rawurlencode((string) GOOGLE_PLACE_ID) . '?languageCode=en';
    $headers = [
        'X-Goog-Api-Key: ' . GOOGLE_PLACES_API_KEY,
        'X-Goog-FieldMask: rating,userRatingCount,googleMapsUri,reviews',
    ];
    $body = false;
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 4,
        ]);
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        if ($status !== 200) {
            $body = false;
        }
    } else {
        $ctx = stream_context_create(['http' => ['method' => 'GET', 'header' => implode("\r\n", $headers), 'timeout' => 4]]);
        $body = @file_get_contents($url, false, $ctx);
    }
    $data = is_string($body) ? json_decode($body, true) : null;
    return is_array($data) ? ws_google_reviews_parse($data) : null;
}

// Returns ['rating' => float|null, 'total' => int, 'maps_url' => string,
// 'reviews' => [...]] or null when Google reviews are not available.
function ws_google_reviews(): ?array
{
    if (!defined('GOOGLE_PLACES_API_KEY') || !defined('GOOGLE_PLACE_ID') || GOOGLE_PLACES_API_KEY === '' || GOOGLE_PLACE_ID === '') {
        return null;
    }
    $file = ws_google_reviews_cache_file();
    $cached = null;
    $age = PHP_INT_MAX;
    if (is_file($file)) {
        $decoded = json_decode((string) @file_get_contents($file), true);
        if (is_array($decoded) && array_key_exists('data', $decoded)) {
            $cached = $decoded['data'];
            $age = time() - (int) ($decoded['fetched_at'] ?? 0);
        }
    }
    // A cached null means "Google failed recently": don't hammer it.
    if ($age < WS_GOOGLE_REVIEWS_TTL) {
        return $cached;
    }

    $fresh = ws_google_reviews_fetch();
    if ($fresh !== null) {
        @file_put_contents($file, json_encode(['fetched_at' => time(), 'data' => $fresh]), LOCK_EX);
        return $fresh;
    }
    // Google unreachable: keep serving the last good copy, retry soon.
    @file_put_contents($file, json_encode(['fetched_at' => time() - WS_GOOGLE_REVIEWS_TTL + WS_GOOGLE_REVIEWS_RETRY, 'data' => $cached]), LOCK_EX);
    return $cached;
}
