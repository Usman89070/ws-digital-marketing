-- Adds per-metric proof screenshots and the new "Generative AI features"
-- (Google Search Console) stat, plus an optional 5th Business Profile
-- metric that varies by business type (Chat Clicks for trades, Menu Views
-- for hospitality, etc.), to all 6 case studies covered this round.
--
-- Safe to run even if never run before, and safe to re-run: columns are
-- only added if missing, and every UPDATE here is unconditional per row
-- (no CONCAT/append), so re-running just re-sets the same values.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab (paste the whole
-- file and click Go -- not the Import/file-upload tab).
--
-- Upload the 28 new screenshot images in images/case-studies/ (already
-- committed to the repo under those exact filenames) via File Manager or
-- the admin panel before/after running this -- onerror="this.remove()"
-- on every proof image means the page still looks fine even if one
-- hasn't landed yet.

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_ai_value'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_ai_value VARCHAR(50) DEFAULT ''''',
    'SELECT ''gsc_ai_value already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_ai_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_ai_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gsc_ai_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_calls_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_calls_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gbp_calls_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_directions_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_directions_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gbp_directions_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_website_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_website_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gbp_website_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_extra_label'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_extra_label VARCHAR(100) DEFAULT ''''',
    'SELECT ''gbp_extra_label already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_extra_value'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_extra_value VARCHAR(50) DEFAULT ''''',
    'SELECT ''gbp_extra_value already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_extra_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_extra_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gbp_extra_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE case_studies SET
    gsc_ai_value = '6.56K',
    gsc_ai_image = '/images/case-studies/ace-fridge-repairs-sydney-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/ace-fridge-repairs-sydney-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/ace-fridge-repairs-sydney-gbp-directions.png',
    gbp_website_image = '/images/case-studies/ace-fridge-repairs-sydney-gbp-website.png',
    gbp_extra_label = 'Chat Clicks',
    gbp_extra_value = '13',
    gbp_extra_image = '/images/case-studies/ace-fridge-repairs-sydney-gbp-extra.png'
WHERE slug = 'ace-fridge-repairs-sydney';

UPDATE case_studies SET
    gsc_ai_value = '2.83K',
    gsc_ai_image = '/images/case-studies/freak-eats-australia-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/freak-eats-australia-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/freak-eats-australia-gbp-directions.png',
    gbp_website_image = '/images/case-studies/freak-eats-australia-gbp-website.png',
    gbp_extra_label = 'Menu Views',
    gbp_extra_value = '28',
    gbp_extra_image = '/images/case-studies/freak-eats-australia-gbp-extra.png'
WHERE slug = 'freak-eats-australia';

UPDATE case_studies SET
    gsc_ai_value = '22.3K',
    gsc_ai_image = '/images/case-studies/fridge-experts-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/fridge-experts-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/fridge-experts-gbp-directions.png',
    gbp_website_image = '/images/case-studies/fridge-experts-gbp-website.png',
    gbp_extra_label = 'Chat Clicks',
    gbp_extra_value = '5',
    gbp_extra_image = '/images/case-studies/fridge-experts-gbp-extra.png'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    gsc_ai_value = '8.22K',
    gsc_ai_image = '/images/case-studies/fast-appliance-repairs-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/fast-appliance-repairs-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/fast-appliance-repairs-gbp-directions.png',
    gbp_website_image = '/images/case-studies/fast-appliance-repairs-gbp-website.png'
WHERE slug = 'fast-appliance-repairs';

UPDATE case_studies SET
    gsc_ai_value = '1.41K',
    gsc_ai_image = '/images/case-studies/ai-appliance-repairs-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/ai-appliance-repairs-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/ai-appliance-repairs-gbp-directions.png',
    gbp_website_image = '/images/case-studies/ai-appliance-repairs-gbp-website.png',
    gbp_extra_label = 'Chat Clicks',
    gbp_extra_value = '7',
    gbp_extra_image = '/images/case-studies/ai-appliance-repairs-gbp-extra.png'
WHERE slug = 'ai-appliance-repairs';

UPDATE case_studies SET
    gsc_ai_value = '16K',
    gsc_ai_image = '/images/case-studies/fridge-repair-experts-gsc-ai.png',
    gbp_calls_image = '/images/case-studies/fridge-repair-experts-gbp-calls.png',
    gbp_directions_image = '/images/case-studies/fridge-repair-experts-gbp-directions.png',
    gbp_website_image = '/images/case-studies/fridge-repair-experts-gbp-website.png'
WHERE slug = 'fridge-repair-experts';

