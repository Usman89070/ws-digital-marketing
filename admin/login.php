<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

// Basic brute-force throttling: after 5 failed attempts, force a short wait.
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['login_locked_until'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (time() < $_SESSION['login_locked_until']) {
        $error = 'Too many failed attempts. Please wait a minute and try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        try {
            $pdo = get_db();
            $stmt = $pdo->prepare('SELECT id, password_hash FROM admin_users WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $username;
                unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
                header('Location: index.php');
                exit;
            }

            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['login_locked_until'] = time() + 60;
                $_SESSION['login_attempts'] = 0;
            }
            $error = 'Incorrect username or password.';
        } catch (PDOException $e) {
            $error = 'Could not connect to the database. Check config.php credentials.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Admin Login</title>
<link rel="stylesheet" href="admin.css?v=<?php echo @filemtime(__DIR__ . '/admin.css') ?: time(); ?>">
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <h1>W&amp;S Admin Login</h1>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="post" class="admin-form">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:24px;">Log In</button>
        </form>
    </div>
</div>
</body>
</html>
