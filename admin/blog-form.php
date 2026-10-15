<?php
require_once __DIR__ . '/includes/auth.php';
$pdo = get_db();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$post = ['title' => '', 'category' => '', 'excerpt' => '', 'content' => '', 'image_path' => '', 'is_published' => 1];
$error = '';

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        header('Location: blog-list.php');
        exit;
    }
    $post = $existing;
}

$page_title = $id ? 'Edit Blog Post' : 'Add Blog Post';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $post['title'] = trim($_POST['title'] ?? '');
    $post['category'] = trim($_POST['category'] ?? '');
    $post['excerpt'] = trim($_POST['excerpt'] ?? '');
    $post['content'] = $_POST['content'] ?? '';
    $post['is_published'] = isset($_POST['is_published']) ? 1 : 0;
    $imageUrl = trim($_POST['image_url'] ?? '');

    if ($post['title'] === '') {
        $error = 'Title is required.';
    } else {
        try {
            $uploaded = handle_image_upload('image_file', 'images/blog', $post['title']);
            if ($uploaded) {
                $post['image_path'] = $uploaded;
            } elseif ($imageUrl !== '') {
                $post['image_path'] = $imageUrl;
            }

            // Slug: derived from the title, made unique by appending -2/-3/... if needed.
            $baseSlug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($post['title'])), '-') ?: 'post';
            $slug = $baseSlug;
            $suffix = 2;
            while (true) {
                $check = $pdo->prepare('SELECT id FROM blog_posts WHERE slug = ? AND id != ?');
                $check->execute([$slug, $id]);
                if (!$check->fetch()) {
                    break;
                }
                $slug = $baseSlug . '-' . $suffix;
                $suffix++;
            }

            if ($id) {
                $stmt = $pdo->prepare('UPDATE blog_posts SET title=?, slug=?, category=?, excerpt=?, content=?, image_path=?, is_published=? WHERE id=?');
                $stmt->execute([$post['title'], $slug, $post['category'], $post['excerpt'], $post['content'], $post['image_path'], $post['is_published'], $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO blog_posts (title, slug, category, excerpt, content, image_path, is_published) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute([$post['title'], $slug, $post['category'], $post['excerpt'], $post['content'], $post['image_path'], $post['is_published']]);
            }
            header('Location: blog-list.php?saved=1');
            exit;
        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }
    }
}

include __DIR__ . '/includes/layout-header.php';
?>
<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="admin-card">
    <form method="post" enctype="multipart/form-data" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

        <label for="title">Title</label>
        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="category">Category (e.g. SEO, PPC, CRO)</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="excerpt">Excerpt (short summary shown on the blog listing card)</label>
        <textarea id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="content">Full Content (HTML allowed -- e.g. &lt;p&gt;, &lt;h3&gt;)</label>
        <textarea id="content" name="content" rows="14"><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="image_file">Cover Image (upload)</label>
        <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp">
        <div class="hint">JPG, PNG, or WEBP, up to 5MB. Leave blank to keep the current image.</div>

        <label for="image_url">...or paste an image URL instead</label>
        <input type="url" id="image_url" name="image_url" placeholder="https://example.com/photo.jpg">

        <?php if ($post['image_path']): ?>
            <div class="current-image">
                <div class="hint">Current image:</div>
                <img src="<?php echo htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
            </div>
        <?php endif; ?>

        <label style="display:flex; align-items:center; gap:8px; margin-top:20px;">
            <input type="checkbox" name="is_published" value="1" style="width:auto;" <?php echo $post['is_published'] ? 'checked' : ''; ?>>
            Published (visible on the live site)
        </label>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Blog Post</button>
        <a href="blog-list.php" class="btn btn-secondary" style="margin-top:20px;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
