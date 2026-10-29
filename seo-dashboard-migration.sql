-- SEO dashboard migration: user roles (Admin / SEO Manager), per-page SEO
-- overrides, redirects, a 404 log, site-wide settings (robots.txt, head
-- code, ...) and a blog image alt-text column.
--
-- Safe to run once against the live database, and safe to re-run: tables
-- use CREATE TABLE IF NOT EXISTS and every ALTER TABLE only runs when the
-- column is missing. Existing admin users automatically keep full "admin"
-- access (the new role column defaults to 'admin').
--
-- Until this file is run the public site keeps working exactly as before
-- (all the new code falls back silently when these tables are missing).
--
-- Run in Hostinger hPanel -> phpMyAdmin -> SQL tab (paste the whole file and
-- click Go -- not the Import/file-upload tab).

SET NAMES utf8mb4;

-- ---------------------------------------------------------------- admin_users

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'admin_users' AND COLUMN_NAME = 'role'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE admin_users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT ''admin''',
    'SELECT ''role already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'admin_users' AND COLUMN_NAME = 'is_active'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE admin_users ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1',
    'SELECT ''is_active already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'admin_users' AND COLUMN_NAME = 'last_login_at'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE admin_users ADD COLUMN last_login_at DATETIME NULL',
    'SELECT ''last_login_at already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ----------------------------------------------------------------- blog_posts

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'blog_posts' AND COLUMN_NAME = 'image_alt'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE blog_posts ADD COLUMN image_alt VARCHAR(255) NOT NULL DEFAULT ''''',
    'SELECT ''image_alt already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------------- page_seo
-- One row per URL path ("/seo", "/blog/some-post", ...). Any field left
-- empty means "use whatever the page itself sets", so a row only changes
-- what the SEO manager actually filled in.

CREATE TABLE IF NOT EXISTS page_seo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(191) NOT NULL UNIQUE,
    meta_title VARCHAR(255) NOT NULL DEFAULT '',
    meta_description VARCHAR(500) NOT NULL DEFAULT '',
    no_suffix TINYINT(1) NOT NULL DEFAULT 0,
    canonical_url VARCHAR(500) NOT NULL DEFAULT '',
    noindex TINYINT(1) NOT NULL DEFAULT 0,
    nofollow TINYINT(1) NOT NULL DEFAULT 0,
    og_title VARCHAR(255) NOT NULL DEFAULT '',
    og_description VARCHAR(500) NOT NULL DEFAULT '',
    og_image VARCHAR(500) NOT NULL DEFAULT '',
    in_sitemap TINYINT(1) NOT NULL DEFAULT 1,
    sitemap_priority VARCHAR(4) NOT NULL DEFAULT '',
    sitemap_changefreq VARCHAR(10) NOT NULL DEFAULT '',
    schema_json MEDIUMTEXT NULL,
    extra_content MEDIUMTEXT NULL,
    updated_by VARCHAR(50) NOT NULL DEFAULT '',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------------ redirects

CREATE TABLE IF NOT EXISTS redirects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_path VARCHAR(191) NOT NULL UNIQUE,
    to_url VARCHAR(500) NOT NULL DEFAULT '',
    status_code SMALLINT NOT NULL DEFAULT 301,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    hits INT NOT NULL DEFAULT 0,
    last_hit_at DATETIME NULL,
    note VARCHAR(255) NOT NULL DEFAULT '',
    created_by VARCHAR(50) NOT NULL DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------- not_found_log
-- Every URL that returned a 404 (and wasn't covered by a redirect), with a
-- hit counter and the last referrer, so broken links can be found and fixed.

CREATE TABLE IF NOT EXISTS not_found_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(191) NOT NULL UNIQUE,
    hits INT NOT NULL DEFAULT 1,
    first_seen_at DATETIME NOT NULL,
    last_seen_at DATETIME NOT NULL,
    last_referrer VARCHAR(500) NOT NULL DEFAULT '',
    status VARCHAR(10) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------- site_settings
-- Key/value store: robots_txt, head_code, body_code, footer_code,
-- title_suffix, default_og_image, schema_json, unmatched_404, ...

CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(100) NOT NULL PRIMARY KEY,
    setting_value MEDIUMTEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
