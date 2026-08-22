-- W&S Digital Marketing -- admin panel schema + seed data.
--
-- HOW TO IMPORT ON HOSTINGER:
-- 1. hPanel -> Databases -> MySQL Databases -> create a database + user if you
--    haven't already (note the DB name, username, password it gives you).
-- 2. hPanel -> Databases -> phpMyAdmin -> open your database -> "Import" tab.
-- 3. Choose this file, click "Go". It creates all 3 tables and seeds them with
--    the site's current blog posts and team members so nothing is lost.
-- 4. On the server, copy config.sample.php to config.php (same folder) and put
--    the DB name/user/password from step 1 into it (DB_NAME, DB_USER, DB_PASS).
--    config.php is never tracked by git/future updates, so do this directly on
--    Hostinger and it will not be overwritten the next time you upload new
--    files -- only ever re-upload config.sample.php, never config.php.
--
-- DEFAULT ADMIN LOGIN (created by this file) -- CHANGE THIS PASSWORD THE FIRST
-- TIME YOU LOG IN (Admin Panel -> Account -> Change Password), it's a shared
-- placeholder from setup, not something that should stay in use long-term:
--   Username: admin
--   Password: 62e80ad50bbb

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admin_users (username, password_hash) VALUES
('admin', '$2y$12$nQcG8pv56VqGIPXuDl7MzuQ1VUmm5GlenX3dyWQxMc6uqxu2HSHDa');

CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    description TEXT,
    photo_path VARCHAR(255) DEFAULT '',
    linkedin_url VARCHAR(255) DEFAULT '#',
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO team_members (name, role, description, photo_path, linkedin_url, display_order) VALUES
('Sahar Afridi', 'Managing Director / Social Media Manager', 'Oversees company direction and leads social media strategy across every client account.', 'images/team/sahar-afridi.jpg', '#', 1),
('Wishal Khan Mohammadi', 'Chief Executive Officer', 'Sets company vision and ensures every client gets a growth plan built around real numbers.', 'images/team/wishal-khan-mohammadi.jpg', '#', 2),
('Shawal Khan Mohammadi', 'Chief Executive Officer', 'Drives company strategy and long-term growth across every service we deliver.', 'images/team/shawal-khan-mohammadi.jpg', '#', 3),
('Hammad Hassan', 'Digital Marketing Manager', 'Manages day-to-day marketing execution across SEO, ads, and content.', 'images/team/hammad-hassan.jpg', '#', 4),
('Usman Zahid', 'Lead Web Developer', 'Builds fast, conversion-focused websites engineered to turn visitors into customers.', 'images/team/usman-zahid.jpg', '#', 5),
('Azhar Rasheed', 'SEO Expert', 'Drives organic growth through technical SEO, content strategy, and local search dominance.', 'images/team/azhar-rasheed.jpg', '#', 6),
('Tabarak Hussain', 'Shopify Expert', 'Builds and optimises Shopify stores engineered for conversions and repeat customers.', 'images/team/tabarak-hussain.jpg', '#', 7),
('Tariq Aziz', 'Social Media Expert', 'Plans and manages social content and campaigns that build real engagement.', 'images/team/tariq-aziz.jpg', '#', 8),
('Salim Yousaf', 'SEO Expert', 'Focuses on keyword research and on-page optimisation that lifts search rankings.', 'images/team/salim-yousaf.jpg', '#', 9);

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(50) DEFAULT '',
    excerpt TEXT,
    content LONGTEXT,
    image_path VARCHAR(255) DEFAULT '',
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO blog_posts (title, slug, category, excerpt, content, image_path, is_published) VALUES
(
    '5 Local SEO Wins Every Small Business Should Make',
    'local-seo-wins-for-small-business',
    'SEO',
    'From Google Business Profile optimization to local link building, here are the highest-leverage local SEO moves for Australian businesses.',
    '<p>Local SEO is the single highest-leverage channel for most small businesses, yet it is consistently the most neglected. Here are five changes that move the needle fastest.</p><h3>1. Fully optimise your Google Business Profile</h3><p>Complete every field, add real photos, choose accurate categories, and post updates regularly. This is the single biggest factor in local map pack rankings.</p><h3>2. Build local citations consistently</h3><p>Your business name, address, and phone number should match exactly across every directory, from your own website to third-party listings.</p><h3>3. Earn genuine local backlinks</h3><p>Local chambers of commerce, supplier partnerships, and community sponsorships all create natural, relevant links back to your site.</p><h3>4. Actively manage your reviews</h3><p>Respond to every review, good or bad. Review volume and recency are ranking factors, and responsiveness builds trust with prospective customers.</p><h3>5. Create location-specific landing pages</h3><p>If you serve multiple suburbs or regions, dedicated pages for each area outperform a single generic services page in local search.</p>',
    'https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?auto=format&fit=crop&w=800&q=80',
    1
),
(
    'How To Stop Wasting Ad Spend On Google Ads',
    'stop-wasting-ad-spend-google-ads',
    'PPC',
    'Negative keywords, dayparting, and audience layering — the tactics we use to cut cost-per-lead without sacrificing volume.',
    '<p>Most Google Ads accounts we audit are leaking 20-40% of their budget on searches that were never going to convert. Here is where that waste typically comes from and how to fix it.</p><h3>Negative keywords are non-negotiable</h3><p>Review the search terms report weekly, not monthly. Every irrelevant query that triggers your ad is money you will never get back.</p><h3>Dayparting around real buying behaviour</h3><p>Most service businesses see conversion rates fall off a cliff outside business hours. Scheduling ads around when your team can actually respond protects cost-per-lead.</p><h3>Audience layering, not just keyword targeting</h3><p>Overlaying in-market and affinity audiences on top of keyword targeting lets you bid more aggressively on the traffic most likely to convert, and pull back on the rest.</p><h3>Match types matter more than ever</h3><p>Broad match without strong automated bidding and a mature negative keyword list is one of the fastest ways to burn budget. Start tighter, expand deliberately.</p>',
    'https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&w=800&q=80',
    1
),
(
    'Why Your Website Isn''t Converting Traffic Into Leads',
    'website-not-converting-traffic-into-leads',
    'CRO',
    'Traffic isn''t the problem for most businesses — conversion is. Here''s how we audit and fix leaky landing pages.',
    '<p>Businesses often pour budget into driving more traffic when the real problem is what happens once visitors land on the page. A few of the most common leaks we find during conversion audits:</p><h3>Unclear value proposition</h3><p>If a visitor cannot understand what you do and why it matters to them within five seconds, they will leave. Headlines need to lead with the outcome, not the feature.</p><h3>Too many competing calls to action</h3><p>Every extra choice on a page reduces the odds any single one gets taken. A strong landing page has one primary action, reinforced consistently.</p><h3>Forms that ask for too much, too soon</h3><p>Every additional form field measurably reduces completion rate. Ask only for what you need to make first contact, and gather the rest later.</p><h3>No real trust signals</h3><p>Reviews, case studies, and recognisable logos do real work here. Visitors are looking for proof before they hand over their details.</p><h3>Slow load times</h3><p>Every extra second of load time on mobile compounds directly into lost conversions, especially for paid traffic where every visitor already cost you money to acquire.</p>',
    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
    1
);
