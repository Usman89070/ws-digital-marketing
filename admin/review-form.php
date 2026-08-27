<?php
require_once __DIR__ . '/includes/auth.php';
$pdo = get_db();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);
$review = ['author_name' => '', 'author_role' => '', 'quote' => '', 'rating' => 5, 'photo_path' => '', 'display_order' => 0];
$error = '';

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        header('Location: review-list.php');
        exit;
    }
    $review = $existing;
}

$page_title = $id ? 'Edit Review' : 'Add Review';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $review['author_name'] = trim($_POST['author_name'] ?? '');
    $review['author_role'] = trim($_POST['author_role'] ?? '');
    $review['quote'] = trim($_POST['quote'] ?? '');
    $review['rating'] = max(1, min(5, (int) ($_POST['rating'] ?? 5)));
    $review['display_order'] = (int) ($_POST['display_order'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');

    if ($review['author_name'] === '' || $review['quote'] === '') {
        $error = 'Name and review text are required.';
    } else {
        try {
            $uploaded = handle_image_upload('photo_file', 'images/reviews', $review['author_name']);
            if ($uploaded) {
                $review['photo_path'] = $uploaded;
            } elseif ($imageUrl !== '') {
                $review['photo_path'] = $imageUrl;
            }

            if ($id) {
                $stmt = $pdo->prepare('UPDATE reviews SET author_name=?, author_role=?, quote=?, rating=?, photo_path=?, display_order=? WHERE id=?');
                $stmt->execute([$review['author_name'], $review['author_role'], $review['quote'], $review['rating'], $review['photo_path'], $review['display_order'], $id]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO reviews (author_name, author_role, quote, rating, photo_path, display_order) VALUES (?,?,?,?,?,?)');
                $stmt->execute([$review['author_name'], $review['author_role'], $review['quote'], $review['rating'], $review['photo_path'], $review['display_order']]);
            }
            header('Location: review-list.php?saved=1');
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

        <label for="author_name">Reviewer Name</label>
        <input type="text" id="author_name" name="author_name" required value="<?php echo htmlspecialchars($review['author_name'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="author_role">Role / Company (e.g. "Director, Apex Plumbing")</label>
        <input type="text" id="author_role" name="author_role" value="<?php echo htmlspecialchars($review['author_role'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="quote">Review Text</label>
        <textarea id="quote" name="quote" rows="5" required><?php echo htmlspecialchars($review['quote'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="rating">Star Rating</label>
        <select id="rating" name="rating">
            <?php foreach ([5, 4, 3, 2, 1] as $n): ?>
                <option value="<?php echo $n; ?>" <?php echo (int) $review['rating'] === $n ? 'selected' : ''; ?>><?php echo str_repeat('★', $n) . str_repeat('☆', 5 - $n); ?> (<?php echo $n; ?>)</option>
            <?php endforeach; ?>
        </select>

        <label for="photo_file">Reviewer Photo (upload)</label>
        <input type="file" id="photo_file" name="photo_file" accept="image/jpeg,image/png,image/webp">
        <div class="hint">JPG, PNG, or WEBP, up to 5MB. Optional -- leave blank for no photo. Leave blank on edit to keep the current photo.</div>

        <label for="image_url">...or paste an image URL instead</label>
        <input type="url" id="image_url" name="image_url" placeholder="https://example.com/photo.jpg">

        <?php if ($review['photo_path']): ?>
            <div class="current-image">
                <div class="hint">Current photo:</div>
                <img src="<?php echo htmlspecialchars($review['photo_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="" onerror="this.style.display='none'">
            </div>
        <?php endif; ?>

        <label for="display_order">Display Order (lower numbers appear first)</label>
        <input type="number" id="display_order" name="display_order" value="<?php echo (int) $review['display_order']; ?>">

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Review</button>
        <a href="review-list.php" class="btn btn-secondary" style="margin-top:20px;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
