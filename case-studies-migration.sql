-- W&S Digital Marketing -- adds the case_studies table to an ALREADY-LIVE
-- database (one that was set up before the Case Studies admin section
-- existed). database.sql itself only runs once during initial setup and
-- won't add this table to a database that's already been imported, so this
-- file exists to bring an existing site up to date without touching
-- anything else already in the database.
--
-- HOW TO IMPORT ON HOSTINGER:
-- 1. hPanel -> Databases -> phpMyAdmin -> open your existing site database.
-- 2. Click the "Import" tab.
-- 3. Choose this file, click "Go". It only creates the new case_studies
--    table and seeds it with the 15 case studies already on the site --
--    your blog posts, team members, and admin login are untouched.
-- 4. Once imported, Case Studies appears as a new section in the admin
--    panel (Admin -> Case Studies), where you can upload real images and
--    edit text without needing code changes.
-- 5. This file only needs to be imported once. If you accidentally import
--    it a second time, it won't duplicate any rows -- each slug is UNIQUE,
--    so phpMyAdmin will just show a harmless "duplicate entry" error on
--    the INSERT and nothing in the database will change.

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS case_studies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    tag VARCHAR(100) DEFAULT '',
    image_path VARCHAR(255) DEFAULT '',
    image_alt VARCHAR(255) DEFAULT '',
    summary TEXT,
    services TEXT,
    has_data TINYINT(1) NOT NULL DEFAULT 0,
    period VARCHAR(100) DEFAULT '',
    stat1_value VARCHAR(50) DEFAULT '', stat1_label VARCHAR(100) DEFAULT '',
    stat2_value VARCHAR(50) DEFAULT '', stat2_label VARCHAR(100) DEFAULT '',
    stat3_value VARCHAR(50) DEFAULT '', stat3_label VARCHAR(100) DEFAULT '',
    stat4_value VARCHAR(50) DEFAULT '', stat4_label VARCHAR(100) DEFAULT '',
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO case_studies (name, slug, tag, image_path, image_alt, summary, services, has_data, period, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label, display_order) VALUES
(
    'Clever Beavers',
    'clever-beavers',
    'Full Suite',
    'https://wsdigitalmarketing.com.au/wp-content/uploads/2026/07/screencapture-cleverbeavers-2026-07-27-10_25_46-scaled-e1785130737259.webp',
    'Clever Beavers Workbooks and Branding',
    'Clever Beavers is an educational brand creating engaging learning resources for preschool and early childhood education. We designed and built a modern Shopify e-commerce store that showcases its educational workbooks, printable learning resources and digital products, giving parents, teachers and caregivers a fast, fully responsive and playful-yet-professional shopping experience -- from custom homepage sections and product pages to an optimised, secure checkout flow.',
    'Custom Shopify Store Development
Mobile-First Responsive Design
Product & Collection Page Optimization
Technical SEO Implementation
Payment Gateway Integration
Speed & Performance Optimization',
    0,
    '',
    '', '', '', '', '', '', '', '',
    1
),
(
    'Cafe Calibre',
    'cafe-calibre',
    'Hospitality',
    'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1200&q=80',
    'Cafe Calibre Dining and Dome Reservations',
    'A full-suite engagement covering brand identity, an online reservation experience and ongoing marketing for Cafe Calibre.',
    'AI Design
Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    2
),
(
    'On Crew',
    'on-crew',
    'Commercial',
    'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1200&q=80',
    'On Crew Professional Team',
    'A commercial engagement covering website development and ongoing digital marketing for On Crew.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    3
),
(
    'Master Fridge Repairs',
    'master-fridge-repairs',
    'Refrigeration',
    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
    'Master Fridge Repairs Service',
    'A local refrigeration repair business supported with website development and ongoing local search marketing.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    4
),
(
    'Commercial Fridge Repairs Sydney',
    'commercial-fridge-repairs-sydney',
    'Sydney Repairs',
    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80',
    'Commercial Fridge Repairs Sydney',
    'Before this engagement, Commercial Fridge Repairs Sydney had been losing organic value: a large share of the traffic being recorded was coming from outside Australia, and the Google Business Profile had almost no meaningful search presence, not even for branded searches. We rebuilt the website, re-optimised the Business Profile, and built out new suburb, brand and service-focused content across the Sydney commercial refrigeration market. The reporting period below shows the site back on a measurable ranking track across organic search, local search and Google''s AI features.',
    'Full Website Rebuild
Google Business Profile Re-optimisation
Local SEO & Suburb Content
Search Engine Optimization',
    1,
    '20 Jul – 20 Aug 2026',
    '102', 'Organic Clicks', '24.1K', 'Search Impressions', '+5.3%', 'GBP Growth YoY', '1.63K', 'AI Feature Impressions',
    5
),
(
    'Fridge Experts',
    'fridge-experts',
    'Experts',
    'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=1200&q=80',
    'Fridge Experts Technical Work',
    'Fridge Experts sells and services refrigeration equipment across Sydney, and this quarter''s SEO campaign moved the site decisively into the high-value part of Google''s results. Of 33 tracked commercial keywords, 28 now rank on page one and 13 sit in the top three, at an average tracked position of 5.8. Four keywords -- Fridge Repair Normanhurst, Husky Fridge Repairs Sydney, Bar Fridge Repairs and Skipio Fridge Repairs -- hold the number one position outright, and an estimated 85–90% of tracked keywords are already being surfaced inside AI Overviews and AI Mode.',
    'Local SEO & Keyword Tracking
Google Business Profile Management
Suburb & Brand Content
AI Search Visibility',
    1,
    '1 Jun – 21 Aug 2026',
    '514', 'Organic Clicks', '28/33', 'Keywords On Page 1', '5.8', 'Avg. Tracked Position', '232', 'GBP Interactions',
    6
),
(
    'Ace Fridge Repairs Sydney',
    'ace-fridge-repairs-sydney',
    'Local SEO',
    'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1200&q=80',
    'Ace Fridge Repairs Sydney',
    'Ace Fridge Repairs shows a strong and improving search position, especially on brand-name searches. Ranking #1 for manufacturer names such as CHiQ, GE Appliances, Makeline and Skipio captures customers who''ve already identified their appliance and are looking for someone to fix it -- the shortest path from search to booked job. 16 of 18 tracked keywords already appear inside Google''s AI Mode and AI Overview results, including two brand terms surfaced in both AI surfaces simultaneously.',
    'Brand & Suburb SEO
Google Business Profile Audit
AI Search Visibility
Local Content Programme',
    1,
    '1 Jul – 8 Aug 2026',
    '10/18', 'Keywords At #1', '220', 'Organic Clicks', '39.3K', 'Search Impressions', '16/18', 'Visible In AI Results',
    7
),
(
    'Sydney Art Flooring',
    'sydney-art-flooring',
    'Flooring',
    'https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?auto=format&fit=crop&w=1200&q=80',
    'Sydney Art Flooring Interior',
    'A flooring specialist supported with website development and ongoing digital marketing to reach more Sydney homeowners and tradespeople.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    8
),
(
    'Fast Fridge Repairs',
    'fast-fridge-repairs',
    'Repairs',
    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80',
    'Fast Fridge Repairs',
    'Fast Fridge Repairs recorded consistent, compounding growth across the reporting period: the second half of the period generated 12% more organic clicks than the first half, with search visibility spanning fridge repair, regas, coolroom and commercial refrigeration terms across Sydney suburbs. Generative AI impressions were distributed across technical guides, the homepage, and emergency repair and local service pages -- a fast-growing channel most local competitors aren''t tracking yet.',
    'Local SEO & Suburb Content
Google Business Profile Management
AI Search Visibility
Website Analytics & Reporting',
    1,
    '20 Jul – 20 Aug 2026',
    '282', 'Organic Clicks', '34.8K', 'Search Impressions', '2.68K', 'AI Overview Impressions', '+5.3%', 'GBP Growth YoY',
    9
),
(
    'Magnet Cleaning Australia',
    'magnet-cleaning-australia',
    'Cleaning',
    'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=1200&q=80',
    'Magnet Cleaning Australia',
    'A commercial and residential cleaning business supported with website development and ongoing digital marketing across Australia.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    10
),
(
    'Fast Appliance Repairs',
    'fast-appliance-repairs',
    'Appliances',
    'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
    'Fast Appliance Repairs Kitchen',
    'Fast Appliance Repairs moved from broad visibility into consistent front-page presence this quarter. Across 58 tracked keywords spanning brand, location and service terms, 57 now rank on page one -- an average position of 3.7. The Google Business Profile is doing real work too: 867 interactions including 333 phone calls, close to four inbound calls a day from the listing alone, backed by a full website redesign and 33 Business Profile posts published across the period.',
    'Website Redesign
Weekly Google Business Profile Posting
Brand & Location SEO
Keyword Rank Tracking',
    1,
    '1 Jun – 21 Aug 2026',
    '57/58', 'Keywords On Page 1', '775', 'Organic Clicks', '333', 'Calls From GBP', '71.5K', 'Search Impressions',
    11
),
(
    'Royal Fragrances',
    'royal-fragrances',
    'Ecommerce',
    'https://images.unsplash.com/photo-1615397349754-cfa2066a298e?auto=format&fit=crop&w=1200&q=80',
    'Royal Fragrances Perfume Bottle',
    'An e-commerce fragrance brand supported with online store development, content and ongoing digital marketing.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    12
),
(
    'Becoming Her With Salma',
    'becoming-her-with-salma',
    'Lifestyle',
    'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=80',
    'Becoming Her With Salma Lifestyle',
    'A personal lifestyle brand supported with website development, content and ongoing digital marketing to grow its audience.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    13
),
(
    'Northside Coffee',
    'northside-coffee',
    'Coffee',
    'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1200&q=80',
    'Northside Coffee Shop',
    'A local coffee shop supported with website development and ongoing digital marketing to grow foot traffic and local awareness.',
    'Content Writing
Ecommerce Development
Graphic Design
PPC Advertising
Search Engine Optimization
Social Media Marketing
Website Design',
    0,
    '',
    '', '', '', '', '', '', '', '',
    14
),
(
    'Freak Eats Australia',
    'freak-eats',
    'Food & Eats',
    'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=1200&q=80',
    'Freak Eats Fast Food',
    'Freak Eats Australia moved from minimal search presence to clear market leadership across Western Sydney in a single quarter. A complete website redesign plus a full Google Business Profile audit and implementation delivered 1,910 additional ranking keywords: of 56 tracked commercial terms, 53 now rank on page one and 36 hold the number one position outright, including the majority of Western Sydney suburb terms. Roughly 95% of tracked queries now appear in Google''s AI Overviews, and 50–60% are being cited by external AI assistants including ChatGPT, Gemini and Claude.',
    'Complete Website Redesign
Google Business Profile Audit & Implementation
Suburb & Dish-Level Content
AI Search Visibility',
    1,
    '1 Jun – 21 Aug 2026',
    '53/56', 'Keywords On Page 1', '36', 'Keywords At #1', '776', 'Organic Clicks', '258', 'GBP Interactions',
    15
);
