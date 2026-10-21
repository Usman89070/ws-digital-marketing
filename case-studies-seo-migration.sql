-- Adds dedicated SEO meta title/description fields to case studies, and
-- sets them for the 17 case studies currently live, so each project's
-- <title> and meta description can read differently to the on-page
-- heading/summary (e.g. "Clever Beavers Shopify Case Study" as the meta
-- title, vs. "Clever Beavers" as the on-page heading).
--
-- Safe to run once against the existing, already-live case_studies table:
-- ADD COLUMN only runs if the column doesn't already exist, and every
-- UPDATE matches by slug, touching only the rows listed below.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, against the live database,
-- the same way case-studies-migration.sql and reviews-migration.sql were
-- run.

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'meta_title'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN meta_title VARCHAR(200) DEFAULT '''' ',
    'SELECT ''meta_title already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'case_studies' AND COLUMN_NAME = 'meta_description'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE case_studies ADD COLUMN meta_description VARCHAR(500) DEFAULT '''' ',
    'SELECT ''meta_description already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE case_studies SET
    meta_title = 'Clever Beavers Shopify Case Study',
    meta_description = 'Explore our Shopify store project for Clever Beavers, bringing educational workbooks, printable resources and digital products into a clear shopping journey.'
WHERE slug = 'clever-beavers';

UPDATE case_studies SET
    meta_title = 'Cafe Calibre Shopify Case Study',
    meta_description = 'See our Shopify website project for Cafe Calibre, combining café branding, organised product collections and integrated checkout for online ordering.'
WHERE slug = 'cafe-calibre';

UPDATE case_studies SET
    meta_title = 'OnCrew SEO Case Study',
    meta_description = 'Explore our SEO project for workforce platform OnCrew, covering keyword research, on-page optimisation, technical improvements and content strategy.'
WHERE slug = 'on-crew';

UPDATE case_studies SET
    meta_title = 'Master Fridge Repairs Website Case Study',
    meta_description = 'See our WordPress website project for Master Fridge Repairs, with clear Sydney service information, coverage areas and residential and commercial enquiries.'
WHERE slug = 'master-fridge-repairs';

UPDATE case_studies SET
    meta_title = 'Commercial Fridge Repairs Sydney Case Study',
    meta_description = 'Explore our WordPress project for Commercial Fridge Repairs Sydney, presenting refrigeration repairs, maintenance services and business enquiry options.'
WHERE slug = 'commercial-fridge-repairs-sydney';

UPDATE case_studies SET
    meta_title = 'Fridge Experts Website Case Study',
    meta_description = 'See our WordPress website project for Fridge Experts, presenting Sydney repair services, service areas and enquiry options through mobile-friendly layouts.'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    meta_title = 'Ace Fridge Repairs Sydney Case Study',
    meta_description = 'Explore our WordPress project for Ace Fridge Repairs Sydney, with clear refrigeration services, mobile-friendly navigation and repair enquiry options.'
WHERE slug = 'ace-fridge-repairs-sydney';

UPDATE case_studies SET
    meta_title = 'Sydney Art Flooring Website Case Study',
    meta_description = 'See our website project for Sydney Art Flooring, showcasing flooring collections and installation services with clear navigation and consultation enquiries.'
WHERE slug = 'sydney-art-flooring';

UPDATE case_studies SET
    meta_title = 'Fast Fridge Repairs Website Case Study',
    meta_description = 'Explore our WordPress project for Fast Fridge Repairs, bringing Sydney refrigeration services, coverage information and repair enquiries into one website.'
WHERE slug = 'fast-fridge-repairs';

UPDATE case_studies SET
    meta_title = 'Magnet Cleaning Australia Case Study',
    meta_description = 'See our WordPress project for Magnet Cleaning Australia, presenting commercial cleaning services, Sydney coverage areas and straightforward enquiry options.'
WHERE slug = 'magnet-cleaning-australia';

UPDATE case_studies SET
    meta_title = 'Fast Appliance Repairs Website Case Study',
    meta_description = 'Explore our WordPress project for Fast Appliance Repairs, with clear fridge, washing machine and dryer repair services and customer enquiry options.'
WHERE slug = 'fast-appliance-repairs';

UPDATE case_studies SET
    meta_title = 'Royal Fragrances Shopify Case Study',
    meta_description = 'See our Shopify store project for Royal Fragrances, with organised perfume collections, detailed product information and a clear online shopping journey.'
WHERE slug = 'royal-fragrances';

UPDATE case_studies SET
    meta_title = 'Becoming Her With Salma Case Study',
    meta_description = 'Explore our website project for Becoming Her With Salma, presenting coaching programs, Salma''s approach and enquiry options through welcoming design.'
WHERE slug = 'becoming-her-with-salma';

UPDATE case_studies SET
    meta_title = 'Northside Coffee Website Case Study',
    meta_description = 'See our website project for Northside Coffee, showcasing its café identity, menu and business information through clear, mobile-friendly page layouts.'
WHERE slug = 'northside-coffee';

UPDATE case_studies SET
    meta_title = 'Freak Eats Australia Website Case Study',
    meta_description = 'Explore our website project for Freak Eats Australia, showcasing street food, menus, events and locations through design shaped around its brand.'
WHERE slug = 'freak-eats';

UPDATE case_studies SET
    meta_title = 'Gilgit Shilajit Ecommerce Case Study',
    meta_description = 'See our ecommerce and marketing project for Gilgit Shilajit, combining store design, SEO, product content, graphic design, paid ads and social media.'
WHERE slug = 'gilgit-shilajit';

UPDATE case_studies SET
    meta_title = 'Fast Fridge Spares Ecommerce Case Study',
    meta_description = 'Explore our ecommerce project for Fast Fridge Spares, with organised parts, clear product information and support across search, advertising and social media.'
WHERE slug = 'fast-fridge-spares';
