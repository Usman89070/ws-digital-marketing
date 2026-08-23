<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: case-list.php');
    exit;
}
csrf_check();

$id = (int) ($_POST['id'] ?? 0);
$pdo = get_db();

$stmt = $pdo->prepare('SELECT image_path FROM case_studies WHERE id = ?');
$stmt->execute([$id]);
$study = $stmt->fetch();

if ($study) {
    $pdo->prepare('DELETE FROM case_studies WHERE id = ?')->execute([$id]);
    // Only remove the file if it's a local upload (/images/case-studies/...),
    // never an external URL, and never anything outside that one directory.
    if ($study['image_path'] && str_starts_with($study['image_path'], '/images/case-studies/')) {
        $fullPath = __DIR__ . '/..' . $study['image_path'];
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

header('Location: case-list.php?deleted=1');
exit;
