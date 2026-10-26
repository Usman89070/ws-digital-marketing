<?php
// "Client Projects" section for a service page that has no curated showcase
// of its own (ppc-advertising.php, social-media.php, graphic-design.php,
// content-writing.php): shows every case study ticked for this page under
// "Show on these Service Pages" in the admin, read live from the database.
// Renders nothing if no case study is ticked for the page.
//
// Set before including:
//   $relatedServiceSlug  one of the CASE_STUDY_SERVICE_PAGES keys, e.g. 'ppc-advertising'
//   $relatedHeading      section heading (optional)
//   $relatedIntro        short intro line under the heading (optional)
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/case-study-helpers.php';

$relatedCaseStudies = fetch_related_case_studies($relatedServiceSlug) ?? [];
$relatedHeading = $relatedHeading ?? 'Explore Related Client Work';
$relatedIntro = $relatedIntro ?? 'See projects where this service formed part of the work delivered. Each case study explains the client\'s requirements and what our team delivered.';
?>
<?php if ($relatedCaseStudies): ?>
    <!-- CLIENT PROJECTS: the case studies ticked for this page in the admin
         ("Show on these Service Pages"), pulled live. -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">CLIENT PROJECTS</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;"><?php echo htmlspecialchars($relatedHeading, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p style="color: var(--text-muted); max-width: 700px; margin: 15px auto 0; font-size: 1.05rem;"><?php echo htmlspecialchars($relatedIntro, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="case-grid">
                <?php foreach ($relatedCaseStudies as $cs): ?>
                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag"><?php echo htmlspecialchars($cs['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($cs['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($cs['image_alt'], ENT_QUOTES, 'UTF-8'); ?>" onerror="this.remove()">
                        <h3><?php echo htmlspecialchars(strtoupper($cs['name']), ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 15px;"><?php echo htmlspecialchars(strip_tags((string) $cs['summary']), ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div>
                            <a href="/case-studies/<?php echo htmlspecialchars($cs['slug'], ENT_QUOTES, 'UTF-8'); ?>" class="service-link">View Project <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div style="text-align: center; margin-top: clamp(30px, 4vw, 40px);">
                <a href="/case-studies" class="btn-secondary">VIEW ALL CASE STUDIES <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i></a>
            </div>
        </div>
    </section>
<?php endif; ?>
