-- Adds dedicated Search Console / Business Profile stat columns to
-- case_studies, so each gets its own "Results At A Glance"-style section
-- (not just plain text in the summary). Populates them for the 6 projects
-- covered this round, re-using the proof screenshots already uploaded to
-- images/case-studies/.
--
-- Also removes the old plain-text "Google Search Console Performance" /
-- "Google Business Profile Performance" blocks that an earlier migration
-- appended directly into the summary field for these same 6 case studies
-- -- that text is now replaced by the new dedicated sections on the page,
-- so leaving it in the summary would show it twice.
--
-- Safe to run even if it's never been run before, and safe to re-run:
-- columns are only added if missing, and the summary cleanup only touches
-- rows where that old block is actually still present.
--
-- Run this in Hostinger hPanel -> phpMyAdmin.

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_clicks'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_clicks VARCHAR(50) DEFAULT ''''',
    'SELECT ''gsc_clicks already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_impressions'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_impressions VARCHAR(50) DEFAULT ''''',
    'SELECT ''gsc_impressions already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_ctr'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_ctr VARCHAR(20) DEFAULT ''''',
    'SELECT ''gsc_ctr already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_position'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_position VARCHAR(20) DEFAULT ''''',
    'SELECT ''gsc_position already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gsc_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gsc_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gsc_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_interactions'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_interactions VARCHAR(50) DEFAULT ''''',
    'SELECT ''gbp_interactions already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_calls'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_calls VARCHAR(50) DEFAULT ''''',
    'SELECT ''gbp_calls already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_directions'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_directions VARCHAR(50) DEFAULT ''''',
    'SELECT ''gbp_directions already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_website_clicks'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_website_clicks VARCHAR(50) DEFAULT ''''',
    'SELECT ''gbp_website_clicks already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'gbp_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN gbp_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''gbp_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Remove the old appended GSC/GBP text blocks from the summary, now that
-- they have their own dedicated sections below the main stats grid.
UPDATE case_studies
SET summary = TRIM(SUBSTRING(summary, 1, LOCATE('<h3>Google Search Console Performance', summary) - 1))
WHERE slug IN ('ace-fridge-repairs-sydney', 'freak-eats', 'fridge-experts', 'fast-appliance-repairs', 'ai-appliance-repairs', 'fridge-repair-experts')
  AND LOCATE('<h3>Google Search Console Performance', summary) > 0;

UPDATE case_studies SET
    gsc_clicks = '886', gsc_impressions = '152K',
    gsc_ctr = '0.6', gsc_position = '23.9',
    gsc_image = '/images/case-studies/ace-fridge-repairs-sydney-gsc.png',
    gbp_interactions = '533', gbp_calls = '135',
    gbp_directions = '254', gbp_website_clicks = '131',
    gbp_image = '/images/case-studies/ace-fridge-repairs-sydney-gbp.png'
WHERE slug = 'ace-fridge-repairs-sydney';

UPDATE case_studies SET
    gsc_clicks = '1.45K', gsc_impressions = '93.9K',
    gsc_ctr = '1.5', gsc_position = '15.3',
    gsc_image = '/images/case-studies/freak-eats-gsc.png',
    gbp_interactions = '561', gbp_calls = '15',
    gbp_directions = '253', gbp_website_clicks = '260',
    gbp_image = '/images/case-studies/freak-eats-gbp.png'
WHERE slug = 'freak-eats';

UPDATE case_studies SET
    gsc_clicks = '1.01K', gsc_impressions = '176K',
    gsc_ctr = '0.6', gsc_position = '21.5',
    gsc_image = '/images/case-studies/fridge-experts-gsc.png',
    gbp_interactions = '492', gbp_calls = '99',
    gbp_directions = '283', gbp_website_clicks = '105',
    gbp_image = '/images/case-studies/fridge-experts-gbp.png'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    gsc_clicks = '1.6K', gsc_impressions = '152K',
    gsc_ctr = '1.1', gsc_position = '18.7',
    gsc_image = '/images/case-studies/fast-appliance-repairs-gsc.png',
    gbp_interactions = '1,845', gbp_calls = '709',
    gbp_directions = '308', gbp_website_clicks = '828',
    gbp_image = '/images/case-studies/fast-appliance-repairs-gbp.png'
WHERE slug = 'fast-appliance-repairs';

UPDATE case_studies SET
    gsc_clicks = '524', gsc_impressions = '22.4K',
    gsc_ctr = '2.3', gsc_position = '11.8',
    gsc_image = '/images/case-studies/ai-appliance-repairs-gsc.png',
    gbp_interactions = '425', gbp_calls = '79',
    gbp_directions = '56', gbp_website_clicks = '283',
    gbp_image = '/images/case-studies/ai-appliance-repairs-gbp.png'
WHERE slug = 'ai-appliance-repairs';

UPDATE case_studies SET
    gsc_clicks = '971', gsc_impressions = '162K',
    gsc_ctr = '0.6', gsc_position = '26',
    gsc_image = '/images/case-studies/fridge-repair-experts-gsc.png',
    gbp_interactions = '334', gbp_calls = '37',
    gbp_directions = '223', gbp_website_clicks = '74',
    gbp_image = '/images/case-studies/fridge-repair-experts-gbp.png'
WHERE slug = 'fridge-repair-experts';

