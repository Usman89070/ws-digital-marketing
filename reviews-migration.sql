-- W&S Digital Marketing -- adds the reviews table to an ALREADY-LIVE
-- database (one that was set up before the Reviews admin section existed).
-- database.sql itself only runs once during initial setup and won't add
-- this table to a database that's already been imported, so this file
-- exists to bring an existing site up to date without touching anything
-- else already in the database.
--
-- HOW TO IMPORT ON HOSTINGER:
-- 1. hPanel -> Databases -> phpMyAdmin -> open your existing site database.
-- 2. Click the "Import" tab.
-- 3. Choose this file, click "Go". It only creates the new reviews table
--    and seeds it with the 4 testimonials already shown on the Reviews
--    page -- your blog posts, team members, case studies, and admin
--    login are untouched.
-- 4. Once imported, Reviews appears as a new section in the admin panel
--    (Admin -> Reviews), where you can edit or replace these with real
--    Google reviews, and add new ones, without needing code changes.
-- 5. This file only needs to be imported once. If you accidentally import
--    it a second time, it will just add 4 duplicate rows (there's no
--    unique constraint like slug to prevent it) -- if that happens,
--    delete the extra 4 from Admin -> Reviews.

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(150) NOT NULL,
    author_role VARCHAR(200) DEFAULT '',
    quote TEXT NOT NULL,
    rating TINYINT NOT NULL DEFAULT 5,
    photo_path VARCHAR(255) DEFAULT '',
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO reviews (author_name, author_role, quote, rating, photo_path, display_order) VALUES
('John Smith', 'Director, Apex Plumbing', 'WS Digital helped us generate significantly more qualified enquiries while actively reducing our cost per lead by 32%. The entire team is transparent and responsive.', 5, 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=150&q=80', 1),
('Sarah Collins', 'Owner, Luxe Homes', 'Our overall online bookings increased by a massive 68% in just 3 short months. I highly recommend their custom strategies and clear monthly reporting processes!', 5, 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80', 2),
('Michael Brown', 'CEO, Premium Brands', 'Extremely professional, incredibly proactive and they always deliver exactly the results they promise. Our ROAS has quite frankly never been better since we switched to them!', 5, 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&q=80', 3),
('Emma Rodriguez', 'Marketing Manager, Bright Dental Group', 'The reporting alone is worth it -- for the first time we can actually see where every dollar goes. Bookings are up and our front desk isn''t drowning in no-shows anymore.', 5, 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80', 4);
