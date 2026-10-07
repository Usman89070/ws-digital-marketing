<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: review-list.php');
    exit;
}
csrf_check();

$id = (int) ($_POST['id'] ?? 0);
$pdo = get_db();

$stmt = $pdo->prepare('SELECT photo_path FROM reviews WHERE id = ?');
$stmt->execute([$id]);
$review = $stmt->fetch();

if ($review) {
    $pdo->prepare('DELETE FROM reviews WHERE id = ?')->execute([$id]);
    // Only remove the file if it's a local upload (/images/reviews/...), never
    // an external URL, and never anything outside that one upload directory.
    if ($review['photo_path'] && str_starts_with($review['photo_path'], '/images/reviews/')) {
        $fullPath = __DIR__ . '/..' . $review['photo_path'];
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

header('Location: review-list.php?deleted=1');
exit;
