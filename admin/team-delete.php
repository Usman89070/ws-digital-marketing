<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: team-list.php');
    exit;
}
csrf_check();

$id = (int) ($_POST['id'] ?? 0);
$pdo = get_db();

$stmt = $pdo->prepare('SELECT photo_path FROM team_members WHERE id = ?');
$stmt->execute([$id]);
$member = $stmt->fetch();

if ($member) {
    $pdo->prepare('DELETE FROM team_members WHERE id = ?')->execute([$id]);
    // Only remove the file if its path is inside images/team/ -- covers
    // photos uploaded through this panel (stored root-relative, leading
    // slash) but never anything outside that one directory. Pre-seeded team
    // photos placed manually still use the older path format without a
    // leading slash and are intentionally left alone here.
    if ($member['photo_path'] && str_starts_with($member['photo_path'], '/images/team/')) {
        $fullPath = __DIR__ . '/..' . $member['photo_path'];
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

header('Location: team-list.php?deleted=1');
exit;
