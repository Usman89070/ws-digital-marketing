-- Adds the "Shopify Store Performance" fields to case studies (a separate
-- section on the case study page, edited in the admin case study form) and
-- fills them in for Royal Fragrances from its Shopify dashboard
-- (1 May – 30 Sept 2026 vs 29 Nov 2025 – 30 Apr 2026).
--
-- These are separate from the "Results At A Glance" stats, so the homepage
-- combined stats do not change.
--
-- Safe to run more than once: columns are only added if missing, and the
-- UPDATE just re-sets the same values.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab (paste the whole
-- file and click Go).

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_period'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_period VARCHAR(100) DEFAULT ''''',
    'SELECT ''shop_period already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_sales'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_sales VARCHAR(50) DEFAULT ''''',
    'SELECT ''shop_sales already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_sales_growth'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_sales_growth VARCHAR(20) DEFAULT ''''',
    'SELECT ''shop_sales_growth already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_sessions'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_sessions VARCHAR(50) DEFAULT ''''',
    'SELECT ''shop_sessions already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_sessions_growth'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_sessions_growth VARCHAR(20) DEFAULT ''''',
    'SELECT ''shop_sessions_growth already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_orders'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_orders VARCHAR(50) DEFAULT ''''',
    'SELECT ''shop_orders already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_orders_growth'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_orders_growth VARCHAR(20) DEFAULT ''''',
    'SELECT ''shop_orders_growth already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_conversion'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_conversion VARCHAR(50) DEFAULT ''''',
    'SELECT ''shop_conversion already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_conversion_growth'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_conversion_growth VARCHAR(20) DEFAULT ''''',
    'SELECT ''shop_conversion_growth already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'shop_image'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN shop_image VARCHAR(255) DEFAULT ''''',
    'SELECT ''shop_image already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE case_studies SET
    shop_period = '1 May – 30 Sept 2026, compared with the previous period',
    shop_sales = 'A$247.9K', shop_sales_growth = '+228%',
    shop_sessions = '12.2K', shop_sessions_growth = '+352%',
    shop_orders = '1,998', shop_orders_growth = '+181%',
    shop_conversion = '0.94%', shop_conversion_growth = '',
    shop_image = '/images/case-studies/royal-fragrances-shopify.jpg'
WHERE slug = 'royal-fragrances';
