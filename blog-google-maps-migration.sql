-- Adds dedicated SEO meta title/description fields to blog posts, if not
-- already added by an earlier migration (safe to run either order or run
-- this one alone -- the column check is the same idempotent pattern), and
-- inserts the new "Why Your Business Isn't Showing Up on Google Maps"
-- article.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, against the live database,
-- the same way the other *-migration.sql files were run.

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'blog_posts' AND COLUMN_NAME = 'meta_title'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE blog_posts ADD COLUMN meta_title VARCHAR(200) DEFAULT '''' ',
    'SELECT ''meta_title already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'blog_posts' AND COLUMN_NAME = 'meta_description'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE blog_posts ADD COLUMN meta_description VARCHAR(500) DEFAULT '''' ',
    'SELECT ''meta_description already exists, skipping'''
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

INSERT INTO blog_posts (title, slug, category, excerpt, content, image_path, is_published, meta_title, meta_description) VALUES (
    'Why Your Business Isn’t Showing Up on Google Maps—and What to Check',
    'business-not-showing-on-google-maps',
    'Local SEO',
    'Business not showing on Google Maps? Check verification, profile status, business details and local ranking factors with this guide for Australian businesses.',
    '<p>You have created a Google Business Profile, added your services and started posting updates. Yet when you search for your business, you cannot find it&mdash;or competitors appear ahead of you.</p>
<p>Before making more changes, identify which problem you actually have.</p>
<p>A profile that is unavailable to the public needs a different response from one that appears for its business name but ranks poorly for service searches.</p>
<p>This guide helps Australian business owners distinguish those situations and decide what to check next.</p>

<h3>First, Identify What "Not Showing Up" Means</h3>
<p>Google Maps visibility can vary between searches. Searching for your exact business name is different from searching for "electrician near me" or "cafe in Penrith".</p>
<p>Start with these checks:</p>

<div style="overflow-x:auto; margin: 24px 0;">
<table style="width:100%; min-width:560px; border-collapse:collapse; font-size:0.95rem;">
<thead>
<tr style="background: var(--bg-secondary);">
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What you observe</th>
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What to investigate first</th>
</tr>
</thead>
<tbody>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">You cannot find the profile by its business name and location</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Verification, profile status, eligibility and possible duplicates</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">You can find the business by name, but not for service searches</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Category relevance, business information and local competition</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">The business appears near its base but less often farther away</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Searcher location and the competitiveness of each area</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Your profile suddenly disappears after changes</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Notifications, verification requests and pending or rejected edits</td></tr>
</tbody>
</table>
</div>

<p>Search for your business name and city, then check its public Maps link. Separately, sign in to the Google Account that manages the profile and review any notices. Google explains these methods in its own guide to finding your business.</p>
<p>Being able to open the management controls does not, by itself, demonstrate strong public visibility.</p>

<h3>1. Check Verification and Profile Status</h3>
<p>Verification establishes that you are authorised to manage the business. If Google is requesting verification or further information, address that request before treating the issue as a ranking problem.</p>
<p>Review the account for messages about:</p>
<ul>
<li>Verification that has not been completed.</li>
<li>A requirement to verify again.</li>
<li>Suspended or disabled profile access.</li>
<li>Business information awaiting review.</li>
<li>Changes that Google has not approved.</li>
</ul>
<p>Use the verification options Google provides for your particular business. Do not assume that every business receives the same method.</p>
<p>If the profile is suspended, review the stated issue and correct the underlying information where necessary. Follow the appropriate appeal process and provide relevant evidence when requested.</p>
<p>Do not create a replacement profile for the same business to work around a suspension &mdash; Google specifically advises against doing this in its own suspended-profile guidance.</p>

<h3>2. Confirm That Your Business and Location Are Eligible</h3>
<p>A Business Profile must represent an eligible business and its real operating arrangements.</p>
<p>Google generally requires in-person contact with customers during the business''s stated hours, with certain exceptions. Online-only businesses are among the examples Google identifies as ineligible.</p>
<p>Consider how customers interact with your business:</p>
<ul>
<li>Do they visit a staffed business location?</li>
<li>Do you travel to customers?</li>
<li>Do you both receive visitors and provide services elsewhere?</li>
</ul>
<p>For example, a plumber who visits customers and does not receive them at the business address should use the appropriate service-area setup.</p>
<p>Google says businesses that do not serve customers at their address should remove that address from the public profile. An eligible service-area business can still have a profile without displaying its street address.</p>
<p>Represent the areas you genuinely serve. Adding a location to your service-area list should not be treated as a promise that your business will rank prominently there.</p>

<h3>3. Review Your Business Information</h3>
<p>Once the profile is eligible and its status is clear, check whether the information helps customers understand the business.</p>
<h4>Business name</h4>
<p>Use the name your business actually uses. Avoid adding extra service phrases, city names or promotional claims merely to influence searches.</p>
<h4>Category</h4>
<p>Choose a primary category that accurately describes the main business. Add other categories only where they represent genuine activities.</p>
<h4>Contact details</h4>
<p>Check that the phone number reaches the correct business and that the website link opens the intended page. Look for conflicting details across the profile, website and important listings.</p>
<h4>Opening hours</h4>
<p>Use accurate customer-facing hours, including relevant special hours. Do not advertise continuous availability unless that reflects the actual service.</p>
<p>Google allows owners to maintain these details through their own Business Profile editing tools.</p>
<p>A complete profile is useful, but completing every field does not guarantee a particular ranking.</p>

<h3>4. Distinguish a Ranking Issue From a Missing Profile</h3>
<p>If customers can find your business by name, but it rarely appears for broader service searches, examine relevance, distance and prominence.</p>
<p>Google describes these as the main foundations of local ranking:</p>
<ul>
<li><strong>Relevance:</strong> how well the business matches the search.</li>
<li><strong>Distance:</strong> how far the business is from the searcher.</li>
<li><strong>Prominence:</strong> how well-known the business is, informed by factors that can include links and reviews.</li>
</ul>
<p>These factors work together. Google''s own local ranking explanation also makes clear that businesses cannot pay Google for a better organic local ranking.</p>
<p>For your own checks, record the search phrase and the location from which you searched. Comparing results from different suburbs without noting the location can create a misleading picture of progress.</p>
<p>One search from your own phone is not a complete local visibility report.</p>

<h3>5. Check for Duplicate or Outdated Listings</h3>
<p>A business that has moved, changed its name or worked with several providers may have more than one listing associated with it.</p>
<p>Search for the current name, previous name and known address details. Record any profiles that appear to describe the same business.</p>
<p>Before making changes, establish:</p>
<ul>
<li>Which profile represents the current business.</li>
<li>Who controls each profile.</li>
<li>Whether one listing has outdated information.</li>
<li>Whether separate listings genuinely represent distinct eligible operations.</li>
</ul>
<p>Do not immediately delete a profile or create another one because a duplicate appears. Review the situation and use Google''s relevant support process. Preserve records of the profile links and information involved.</p>

<h3>6. Make Your Website Consistent and Useful</h3>
<p>Your website should help visitors confirm that they have found the right business.</p>
<p>Check that it clearly explains:</p>
<ul>
<li>The services or products you provide.</li>
<li>The locations you genuinely serve.</li>
<li>How customers can contact you.</li>
<li>What happens after an enquiry.</li>
<li>Relevant experience, project examples and customer feedback.</li>
</ul>
<p>A visitor should not find one phone number on the profile and another unexplained number on the Contact page.</p>
<p>Useful service pages can also help people arriving through organic website results. However, website SEO and Business Profile troubleshooting are related activities with different checks. Improving a page title does not resolve a suspended profile.</p>
<p>Our <a href="/seo">SEO services</a> cover website improvements, local search information and content priorities around the business''s actual services.</p>

<h3>7. Build Trust Through Genuine Customer Feedback</h3>
<p>Reviews help prospective customers evaluate your business. Establish a straightforward process for asking customers to describe their real experience, and respond professionally to feedback.</p>
<p>Avoid offering discounts, gifts or other incentives in exchange for reviews. Google requires reviews to reflect genuine experiences and prohibits incentivised review activity.</p>
<p>Also keep useful photos and business information current. Show the work, products, premises or team that customers can genuinely expect to encounter.</p>
<p>These activities support a credible customer experience. They do not provide a guaranteed shortcut to the top of Maps results.</p>

<h3>8. Check Pending Changes Before Editing Again</h3>
<p>If you recently changed important information, inspect the status of that edit.</p>
<p>Google distinguishes between accepted, pending and unapproved changes. Review times vary, and a pending edit means the submitted information is still being assessed.</p>
<p>Keep a simple change record:</p>

<div style="overflow-x:auto; margin: 24px 0;">
<table style="width:100%; min-width:420px; border-collapse:collapse; font-size:0.95rem;">
<thead>
<tr style="background: var(--bg-secondary);">
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">Record</th>
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What to note</th>
</tr>
</thead>
<tbody>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Date</td><td style="padding:12px 14px; border:1px solid var(--border-light);">When you submitted the change</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Field</td><td style="padding:12px 14px; border:1px solid var(--border-light);">The name, category, address, hours or other information changed</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Reason</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Why the update was needed</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Status</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether Google accepted, rejected or is reviewing it</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Evidence</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Relevant records supporting the correct information</td></tr>
</tbody>
</table>
</div>

<p>This makes it easier to understand what happened and explain the issue if support is needed.</p>

<h3>A Practical Troubleshooting Order</h3>
<p>Before commissioning more posts or changing several settings at once, work through this sequence:</p>
<ol>
<li>Find the existing profile and save its public link.</li>
<li>Check verification, restrictions and account notifications.</li>
<li>Confirm eligibility and the correct address or service-area arrangement.</li>
<li>Correct inaccurate business details.</li>
<li>Investigate genuine duplicates or outdated listings.</li>
<li>Compare visibility using clearly recorded searches and locations.</li>
<li>Improve website information, customer feedback and relevant local content.</li>
<li>Review enquiries and customer actions alongside visibility.</li>
</ol>
<p>The aim is to resolve the actual obstacle and establish a useful baseline for further work.</p>

<h3>Frequently Asked Questions</h3>
<h4>How long does it take for a new profile or edit to appear?</h4>
<p>Timing depends on verification, review status and the type of change. Check the information shown in your account and the relevant Google guidance. Avoid treating a general timeframe as a guarantee for your profile.</p>
<h4>Will posting every day fix poor Google Maps visibility?</h4>
<p>Posts can communicate offers, updates and useful information to customers. However, posting more frequently does not resolve eligibility, verification or suspension problems, and it does not guarantee better rankings.</p>
<h4>Can my profile appear without displaying my home address?</h4>
<p>An eligible service-area business that visits customers and does not serve them at its address should use the appropriate service-area setup. Follow Google''s address-display requirements rather than exposing a home address solely in an attempt to improve visibility.</p>

<h3>Get a Clearer Picture of Your Local Visibility</h3>
<p>W&amp;S Digital Marketing can review your public business information, website and local search presence to help identify practical next steps.</p>
<p>For local service businesses, our <a href="/trades">digital marketing support for trades</a> connects service information, website enquiries and local visibility around the work you actually provide.</p>
',
    '',
    1,
    'Why Is Your Business Not Showing Up on Google Maps?',
    'Business not showing on Google Maps? Check verification, profile status, business details and local ranking factors with this guide for Australian businesses.'
);
