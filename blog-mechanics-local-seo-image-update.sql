-- Sets the featured image for the "Local SEO for Mechanics" blog post.
-- Uses the automotive image already live on the site (automotive.php).
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab, only if
-- blog-mechanics-local-seo-migration.sql was already run without an image.

UPDATE blog_posts
SET image_path = '/images/industries/automotive.webp'
WHERE slug = 'local-seo-for-mechanics';
