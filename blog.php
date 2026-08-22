<?php
$page_title = 'Blog';
$page_description = 'Digital marketing insights, SEO tips, and growth strategies from the W&S Digital Marketing team to help Australian businesses grow online.';

require_once __DIR__ . '/config.php';
try {
    $posts = get_db()->query('SELECT id, title, slug, category, excerpt, image_path FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC')->fetchAll();
} catch (PDOException $e) {
    // Falls back to an empty grid (with the CTA still showing) rather than a
    // fatal error if config.php hasn't been filled in with real DB credentials
    // yet, or the database is briefly unreachable.
    $posts = [];
}

include 'header.php';
?>

    <!-- BLOG HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">INSIGHTS</span>
            <h1 class="fade-up">GROWTH STRATEGIES, <br><span class="text-gradient">STRAIGHT FROM THE TEAM.</span></h1>
            <p class="hero-subtitle fade-up">Practical SEO, PPC and growth marketing insights to help you make smarter decisions about your online presence.</p>
        </div>
    </section>

    <!-- BLOG GRID SECTION -->
    <section class="case-studies-section fade-up">
        <div class="container">
            <?php if ($posts): ?>
            <div class="case-grid">
                <?php foreach ($posts as $post): ?>
                <article class="case-card">
                    <div class="case-image">
                        <?php if ($post['category']): ?><span class="case-tag"><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                        <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        <h3><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div>
                            <a href="blog-post.php?slug=<?php echo urlencode($post['slug']); ?>" class="service-link">Read More <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="text-align:center; color: var(--text-muted);">No posts published yet -- check back soon.</p>
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
