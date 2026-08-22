<?php
require_once __DIR__ . '/config.php';

$slug = $_GET['slug'] ?? '';
$post = null;
try {
    $stmt = get_db()->prepare('SELECT * FROM blog_posts WHERE slug = ? AND is_published = 1');
    $stmt->execute([$slug]);
    $post = $stmt->fetch();
} catch (PDOException $e) {
    $post = null;
}

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'Post Not Found';
    $page_description = 'This blog post could not be found.';
    include 'header.php';
    ?>
    <section class="hero">
        <div class="container hero-content">
            <h1>Post Not Found</h1>
            <p class="hero-subtitle">This article may have been moved or unpublished.</p>
            <div class="hero-buttons">
                <a href="blog.php" class="btn-primary">Back To Blog</a>
            </div>
        </div>
    </section>
    <?php
    include 'footer.php';
    exit;
}

$page_title = $post['title'];
$page_description = $post['excerpt'] ?: $post['title'];

$recentPosts = [];
try {
    $stmt = get_db()->prepare('SELECT title, slug, category, image_path FROM blog_posts WHERE is_published = 1 AND id != ? ORDER BY created_at DESC LIMIT 4');
    $stmt->execute([$post['id']]);
    $recentPosts = $stmt->fetchAll();
} catch (PDOException $e) {
    $recentPosts = [];
}

include 'header.php';
?>

    <!-- BLOG POST HERO -->
    <section class="hero" style="padding-bottom: clamp(30px, 6vw, 60px);">
        <div class="container hero-content">
            <?php if ($post['category']): ?><span class="eyebrow fade-up"><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
            <h1 class="fade-up"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>
    </section>

    <!-- BLOG POST CONTENT + SIDEBAR -->
    <section class="agency-section fade-up">
        <div class="container blog-post-layout">
            <div class="blog-post-main">
                <?php if ($post['image_path']): ?>
                    <div style="border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-hover); margin-bottom: 40px;">
                        <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; height:auto; display:block;">
                    </div>
                <?php endif; ?>
                <div class="blog-post-body">
                    <?php echo $post['content']; ?>
                </div>
                <div style="margin-top: 40px;">
                    <a href="blog.php" class="service-link"><i class="fa-solid fa-arrow-left"></i> Back To All Articles</a>
                </div>
            </div>

            <?php if ($recentPosts): ?>
            <aside class="blog-post-sidebar">
                <div class="blog-sidebar-card">
                    <h4>More From The Blog</h4>
                    <div class="blog-sidebar-list">
                        <?php foreach ($recentPosts as $recent): ?>
                        <a class="blog-sidebar-item" href="blog-post.php?slug=<?php echo urlencode($recent['slug']); ?>">
                            <?php if ($recent['image_path']): ?>
                            <div class="blog-sidebar-thumb">
                                <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($recent['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($recent['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <?php endif; ?>
                            <div class="blog-sidebar-item-text">
                                <?php if ($recent['category']): ?><span class="blog-sidebar-tag"><?php echo htmlspecialchars($recent['category'], ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                                <h5><?php echo htmlspecialchars($recent['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <a href="blog.php" class="btn-secondary blog-sidebar-btn">VIEW ALL ARTICLES <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i></a>
                </div>
            </aside>
            <?php endif; ?>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box fade-up">
                <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                <h2>Ready To Put This Into Practice?</h2>
                <p>Skip the guesswork. Let our team build and run a custom growth strategy for your business.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>
                <div class="cta-btn-wrapper">
                    <a href="contact.php" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem;">GET MY FREE GROWTH PLAN <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
