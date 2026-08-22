<?php
// Session guard + CSRF helper, included at the top of every protected admin
// page. login.php is the only admin page that does NOT include this.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// One CSRF token per session, checked on every state-changing POST.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_check(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('Invalid or expired form submission. Go back and try again.');
    }
}

// Saves an uploaded image (blog cover / team headshot) into $destDir with a
// safe, unique filename. Returns the web-relative path to store in the DB, or
// null if no file was uploaded / upload was invalid.
function handle_image_upload(string $fieldName, string $destDir, string $slugHint): ?string
{
    if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed (error code ' . $file['error'] . ').');
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be under 5MB.');
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG, or WEBP images are allowed.');
    }
    $ext = $allowed[$mime];
    $slug = preg_replace('/[^a-z0-9-]+/', '-', strtolower(trim($slugHint)));
    $slug = trim($slug, '-') ?: 'image';
    $filename = $slug . '-' . substr(bin2hex(random_bytes(4)), 0, 8) . '.' . $ext;
    $destPath = rtrim($destDir, '/') . '/' . $filename;
    $destAbsoluteDir = __DIR__ . '/../../' . rtrim($destDir, '/');
    if (!is_dir($destAbsoluteDir) && !mkdir($destAbsoluteDir, 0755, true) && !is_dir($destAbsoluteDir)) {
        throw new RuntimeException('Could not create the upload folder (' . $destDir . '). Check folder permissions on the server.');
    }
    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../../' . $destPath)) {
        throw new RuntimeException('Could not save the uploaded file. Check that the "' . $destDir . '" folder exists and is writable.');
    }
    return $destPath;
}
