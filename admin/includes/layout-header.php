<?php
// Expects $page_title to be set by the including page.
$page_title = $page_title ?? 'Admin';
$current = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?> | Admin</title>
<link rel="stylesheet" href="admin.css?v=<?php echo @filemtime(__DIR__ . '/../admin.css') ?: time(); ?>">
</head>
<body>
<div class="admin-shell">
    <nav class="admin-nav">
        <div class="admin-nav-brand">W&amp;S Admin</div>
        <a href="index.php" class="<?php echo $current === 'index.php' ? 'active' : ''; ?>">Dashboard</a>
        <a href="blog-list.php" class="<?php echo in_array($current, ['blog-list.php', 'blog-form.php'], true) ? 'active' : ''; ?>">Blog Posts</a>
        <a href="team-list.php" class="<?php echo in_array($current, ['team-list.php', 'team-form.php'], true) ? 'active' : ''; ?>">Team Members</a>
        <a href="account.php" class="<?php echo $current === 'account.php' ? 'active' : ''; ?>">Account</a>
        <a href="../blog.php" target="_blank">View Site &#8594;</a>
        <a href="logout.php" class="admin-nav-logout">Log Out</a>
    </nav>
    <main class="admin-main">
        <h1><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></h1>
