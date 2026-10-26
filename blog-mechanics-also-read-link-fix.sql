-- Fixes the "Also Read" link in the "Local SEO for Mechanics" post.
--
-- The link pointed to /blog/seo-vs-google-ads-small-business, but the live
-- "SEO vs Google Ads" post uses a different slug (it can change when the
-- post is saved from the admin). This looks up that post's real slug and
-- points the link at it.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab. Safe to run again.

SET @seo_ads_slug = (
    SELECT slug FROM blog_posts
    WHERE title LIKE 'SEO vs Google Ads%'
    ORDER BY id ASC
    LIMIT 1
);

UPDATE blog_posts
SET content = REPLACE(content, '/blog/seo-vs-google-ads-small-business', CONCAT('/blog/', @seo_ads_slug))
WHERE slug = 'local-seo-for-mechanics'
  AND @seo_ads_slug IS NOT NULL;

-- Shows the slug the link now uses, so you can check it.
SELECT @seo_ads_slug AS also_read_link_now_points_to;
