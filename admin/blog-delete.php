<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: blog-list.php');
    exit;
}
csrf_check();

$id = (int) ($_POST['id'] ?? 0);
$pdo = get_db();

$stmt = $pdo->prepare('SELECT image_path FROM blog_posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if ($post) {
    $pdo->prepare('DELETE FROM blog_posts WHERE id = ?')->execute([$id]);
    // Only remove the file if it's a local upload (images/blog/...), never an
    // external URL, and never anything outside that one upload directory.
    if ($post['image_path'] && str_starts_with($post['image_path'], 'images/blog/')) {
        $fullPath = __DIR__ . '/../' . $post['image_path'];
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

header('Location: blog-list.php?deleted=1');
exit;
