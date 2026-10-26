-- Adds case_studies.related_services ("Show on these Service Pages" in the
-- admin case study form) and fills it in for case studies that don't have
-- a value yet.
--
-- ONLY RUN THIS IF THE COLUMN IS MISSING. Check first in phpMyAdmin:
--   SHOW COLUMNS FROM case_studies LIKE 'related_services';
-- If that returns a row, the column already exists -- do not run this file.
--
-- Safe to run more than once: the column is only added if missing, and the
-- mapping below only fills rows whose value is still empty, so it never
-- overwrites choices already made in the admin.
--
-- Stored format: comma-separated service slugs (seo, ecommerce,
-- website-development, social-media, ppc-advertising, graphic-design,
-- content-writing), or 'none' when no service page is ticked.

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'related_services'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN related_services VARCHAR(255) NOT NULL DEFAULT '''' ',
    'SELECT ''related_services already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Work out each still-unmapped study's services in a scratch table, then
-- write them back in one go.
DROP TEMPORARY TABLE IF EXISTS tmp_related_services;
CREATE TEMPORARY TABLE tmp_related_services AS
SELECT id, CONCAT_WS(',',
    -- (a) the case studies the SEO, Ecommerce and Website Development pages
    -- used to list, plus (b) each study's "Services Delivered" text.
    IF(slug IN ('clever-beavers', 'cafe-calibre', 'on-crew', 'master-fridge-repairs',
                'commercial-fridge-repairs-sydney', 'fridge-experts', 'ace-fridge-repairs-sydney',
                'fast-fridge-repairs', 'magnet-cleaning-australia', 'fast-appliance-repairs',
                'royal-fragrances', 'becoming-her-with-salma', 'northside-coffee', 'freak-eats')
       OR services LIKE '%SEO%' OR services LIKE '%Search Engine%', 'seo', NULL),
    IF(slug IN ('royal-fragrances', 'gilgit-shilajit', 'fast-fridge-spares')
       OR services LIKE '%Shopify%' OR services LIKE '%WooCommerce%' OR services LIKE '%Ecommerce%' OR services LIKE '%E-commerce%', 'ecommerce', NULL),
    IF(slug IN ('commercial-fridge-repairs-sydney', 'fast-appliance-repairs')
       OR services LIKE '%Website%' OR services LIKE '%Web Design%' OR services LIKE '%WordPress%', 'website-development', NULL),
    IF(services LIKE '%Social Media%', 'social-media', NULL),
    IF(services LIKE '%Google Ads%' OR services LIKE '%PPC%' OR services LIKE '%Paid%' OR services LIKE '%Meta Ads%', 'ppc-advertising', NULL),
    IF(services LIKE '%Graphic%' OR services LIKE '%Logo%' OR services LIKE '%Brand%', 'graphic-design', NULL),
    IF(services LIKE '%Content%' OR services LIKE '%Copywriting%' OR services LIKE '%Blog%', 'content-writing', NULL)
) AS mapped
FROM case_studies
WHERE related_services IS NULL OR related_services = '';

UPDATE case_studies cs
JOIN tmp_related_services t ON t.id = cs.id
SET cs.related_services = IF(t.mapped = '', 'none', t.mapped);

DROP TEMPORARY TABLE tmp_related_services;
