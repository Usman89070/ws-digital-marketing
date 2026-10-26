-- Adds dedicated SEO meta title/description fields to blog posts, if not
-- already added by an earlier migration (safe to run either order or run
-- this one alone -- the column check is the same idempotent pattern), and
-- inserts the new "Local SEO for Mechanics" article.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab, the same way the
-- other *-migration.sql files were run.

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
    'Local SEO for Mechanics: How to Help Nearby Customers Find Your Workshop',
    'local-seo-for-mechanics',
    'Local SEO',
    'Help nearby drivers find your workshop with practical local SEO tips for mechanics, covering Google Business Profile, reviews, service pages and booking enquiries.',
    '<p>When a driver needs a car service, brake repairs or help with a warning light, they need to know which nearby workshop can help.</p>
<p>Your business might offer the right service, but potential customers still need to find you, understand what you do and feel confident enough to make contact.</p>
<p>Local search engine optimisation, or local SEO, helps you improve that journey. It brings together your Google Business Profile, website, customer reviews and business information so nearby drivers can discover and assess your workshop.</p>
<p>For mechanics, the goal is more than website traffic. It is relevant enquiries about services your team actually delivers.</p>

<h3>How Does Local SEO Work for Mechanics?</h3>
<p>Local searches can produce different types of results, including Google Maps listings and links to workshop websites.</p>
<p>Someone searching for "mechanic near me" may compare nearby businesses in Maps. Someone searching for a specific repair may visit a service page to understand whether a workshop handles that work.</p>
<p>Google explains that local results mainly depend on three factors:</p>
<ul>
<li><strong>Relevance:</strong> How closely a business matches the search.</li>
<li><strong>Distance:</strong> How far the business is from the searcher.</li>
<li><strong>Prominence:</strong> How well known the business is, including information such as links and reviews.</li>
</ul>
<p>You cannot control a driver''s location or guarantee a particular ranking. You can improve how accurately your business is represented and how useful its information is.</p>

<h3>1. Start With an Accurate Google Business Profile</h3>
<p>Your Google Business Profile may be the first information a customer sees about your workshop.</p>
<p>Claim or obtain access to the correct profile, complete verification when required and check the details carefully.</p>
<p>Review:</p>
<ul>
<li>Your real-world business name.</li>
<li>The workshop address and map pin.</li>
<li>Your phone number and website.</li>
<li>Regular opening hours and public holiday changes.</li>
<li>Business categories and services.</li>
<li>Any available appointment or booking links.</li>
</ul>
<p>Use the name customers recognise from your signage and branding. Adding phrases such as "best cheap mechanic near me" to the business name can breach Google''s guidelines.</p>
<p>Choose the most accurate primary category available in your profile. Add secondary categories only when they describe genuine parts of your business; category names and availability can vary.</p>
<p>A workshop customers visit should show its real location. A mobile mechanic needs settings that accurately reflect how it visits customers. Do not create extra profiles for suburbs where you have no eligible business location.</p>

<h4>Add photos that help customers recognise your workshop</h4>
<p>Use current photographs of your entrance, signage, workshop and customer facilities.</p>
<p>A clear entrance photo can help someone approaching an industrial estate identify the correct driveway. If you publish images of staff or customers'' vehicles, obtain appropriate permission and avoid exposing personal information.</p>

<h3>2. Match Your Website to the Services People Need</h3>
<p>Start with the work your workshop wants and is equipped to handle.</p>
<p>Depending on your business, relevant service topics might include:</p>
<ul>
<li>Logbook servicing.</li>
<li>Brake repairs.</li>
<li>Clutch repairs.</li>
<li>Engine diagnostics.</li>
<li>Car air conditioning servicing.</li>
<li>Battery testing and replacement.</li>
<li>General mechanical repairs.</li>
</ul>
<p>Combine these services with your genuine location when researching search terms. For example, "brake repairs in Penrith" expresses a clearer service need than a broad phrase such as "automotive business".</p>
<p>These are examples, rather than verified keyword opportunities for every workshop. Use your customer enquiries and Google Search Console data to understand the wording relevant to your business.</p>
<p>Only target services and availability you can support. Do not advertise emergency repairs, same-day servicing or particular inspections unless you actually offer them and meet applicable requirements.</p>

<h4>Use location wording naturally</h4>
<p>A service page title could follow this structure:</p>
<p><strong>Brake Repairs in [Suburb] | [Workshop Name]</strong></p>
<p>The heading and body should then explain the service clearly. Repeating "mechanic near me" throughout a page makes the writing awkward and does little to help customers assess your workshop.</p>

<h3>3. Give Your Main Services Useful Pages</h3>
<p>A short list of services on your homepage may leave customers with unanswered questions.</p>
<p>Dedicated pages can help when each service needs its own explanation. You do not need a separate page for every minor task.</p>
<p>For example, a useful brake repair page could explain:</p>
<ul>
<li>The types of brake work your workshop performs.</li>
<li>What customers can expect when booking an inspection.</li>
<li>How findings and repair recommendations are communicated.</li>
<li>Where the workshop is located.</li>
<li>How to request an appointment.</li>
</ul>
<p>Use actual details about your process rather than generic paragraphs that could describe any mechanic.</p>
<p>Include relevant qualifications, experience or accreditations only when they are accurate and current. Explain pricing clearly where you publish it, including what an advertised service includes.</p>
<p>Link these pages from your main navigation or service overview so visitors can find them easily.</p>

<h3>4. Avoid Creating Dozens of Repetitive Suburb Pages</h3>
<p>A workshop may attract customers from several neighbouring suburbs. That does not automatically mean it needs a separate page for each one.</p>
<p>Start with a useful location or contact page containing your actual address, opening hours, directions, access and parking information.</p>
<p>Create additional area pages only where you can provide distinct information that helps customers. Make the workshop''s real location clear; do not imply you have premises in every suburb you mention.</p>
<p>For example, explaining how customers from a neighbouring area can reach your workshop may be useful. Copying one page repeatedly and replacing the suburb name is unlikely to add much value.</p>
<p>Google identifies pages created to rank for similar searches and funnel visitors to the same destination as a form of doorway abuse.</p>

<h3>5. Ask for Honest Customer Reviews</h3>
<p>Reviews help prospective customers understand other people''s experiences with your workshop.</p>
<p>Build a straightforward process for inviting feedback after completed work. You could provide your Google review link on a receipt, display a QR code or send an appropriate follow-up message.</p>
<p>Keep the request neutral:</p>
<blockquote><p>"Thank you for choosing our workshop. If you would like to share your experience, you can leave an honest Google review here."</p></blockquote>
<p>Avoid:</p>
<ul>
<li>Offering discounts or gifts in exchange for reviews.</li>
<li>Asking only customers expected to leave positive feedback.</li>
<li>Requesting a particular star rating or wording.</li>
<li>Buying reviews or arranging reviews from people without genuine experience.</li>
</ul>
<p>Google prohibits incentivised reviews and selectively soliciting positive feedback.</p>
<p>Respond professionally to feedback. If a complaint involves personal details or a disputed repair, invite the customer to discuss it privately rather than publishing their information.</p>

<h3>6. Make It Easy to Call or Request a Booking</h3>
<p>Visibility helps people find your workshop. Your website then needs to help them take the next step.</p>
<p>Check the site on a mobile phone. Can a visitor quickly see:</p>
<ul>
<li>What services you provide?</li>
<li>Where the workshop is?</li>
<li>When you are open?</li>
<li>How to call?</li>
<li>How to request a booking?</li>
</ul>
<p>Use a working tap-to-call link and a clearly labelled booking button.</p>
<p>Keep an initial booking request manageable. Ask for information your team needs to respond, such as contact details, vehicle details, the requested service and a preferred date.</p>
<p>Make it clear whether submitting the form confirms an appointment or simply requests one. If your team must check availability, explain that the booking is subject to confirmation.</p>
<p>Test the form regularly. A confirmation screen is not enough if the request never reaches your workshop.</p>

<p><strong>Also Read:</strong> <a href="/blog/seo-vs-google-ads-small-business">SEO vs Google Ads: Which Should Your Small Business Start With?</a></p>

<h3>7. Check the Website''s Technical Basics</h3>
<p>Your website should be accessible to customers and search engines.</p>
<p>Ask your developer or SEO specialist to check that:</p>
<ul>
<li>Important pages load successfully.</li>
<li>Service pages are available for indexing.</li>
<li>Navigation and internal links work.</li>
<li>Each main page has a descriptive title.</li>
<li>Images are appropriately sized.</li>
<li>Mobile layouts remain usable.</li>
<li>Old page addresses redirect to relevant replacements when needed.</li>
<li>Your sitemap contains the pages you want discovered.</li>
</ul>
<p>These foundations help Google discover and understand your content, although they do not guarantee indexing or rankings.</p>
<p>Your developer can also consider suitable local business structured data. This is code that describes business details such as your address and opening hours. It should match the information visitors can see and is not a guaranteed ranking boost or search enhancement.</p>

<h3>8. Keep Business Listings Reliable</h3>
<p>Check important directory listings, industry memberships and other websites that describe your workshop.</p>
<p>Prioritise correcting:</p>
<ul>
<li>Old addresses.</li>
<li>Disconnected phone numbers.</li>
<li>Incorrect website links.</li>
<li>Duplicate or outdated business listings.</li>
<li>Claims about services you no longer offer.</li>
</ul>
<p>The aim is accurate, recognisable information. Minor formatting differences such as "Street" and "St" are less useful to focus on than a phone number that sends customers to the wrong business.</p>
<p>Look for relevant local or automotive organisations where your workshop genuinely belongs. Avoid buying large packages of unrelated directory listings or links.</p>

<h3>9. Measure Enquiries and Bookings, Not Just Rankings</h3>
<p>A ranking report cannot tell you whether your workshop is receiving suitable work.</p>
<p>Review the whole journey:</p>

<div style="overflow-x:auto; margin: 24px 0;">
<table style="width:100%; min-width:560px; border-collapse:collapse; font-size:0.95rem;">
<thead>
<tr style="background: var(--bg-secondary);">
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">Measure</th>
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What it helps you understand</th>
</tr>
</thead>
<tbody>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Relevant searches in Search Console</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Which searches bring visibility and website visits</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Visits to service pages</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Which services attract attention</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Business Profile interactions</td><td style="padding:12px 14px; border:1px solid var(--border-light);">How people engage with your listing</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Completed booking requests</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether visitors submit enquiries</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Confirmed appointments</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether enquiries become booked work</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Enquiries about unavailable services</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether your information needs clarification</td></tr>
</tbody>
</table>
</div>

<p>Google Business Profile reports some interactions, including website clicks, direction requests and call-button clicks. A call-button click does not prove that a call connected or became a booking.</p>
<p>Compare online activity with your actual booking records. If enquiries rise but confirmed appointments do not, check availability, missed calls and response times before assuming you need more traffic.</p>

<h3>What Should a Workshop Prioritise First?</h3>
<p>If you are starting local SEO, use this practical order:</p>
<ol>
<li><strong>Correct your Google Business Profile:</strong> Fix business details, categories, hours and links.</li>
<li><strong>Make contact and booking work:</strong> Test the mobile experience, phone links and forms.</li>
<li><strong>Improve your main service pages:</strong> Explain the work you offer and your actual location.</li>
<li><strong>Introduce a consistent review process:</strong> Invite honest feedback without incentives or filtering.</li>
<li><strong>Measure results and resolve technical problems:</strong> Connect visibility and enquiry data with real workshop bookings.</li>
</ol>
<p>This is a suggested starting order, rather than a universal ranking formula. A broken website or inaccessible Business Profile may need immediate attention before anything else.</p>

<h3>Frequently Asked Questions</h3>
<h4>How much should a mechanic pay for local SEO?</h4>
<p>There is no single suitable price for every workshop. The scope depends on your website''s condition, local competition, number of locations and the work included.</p>
<p>Ask for a proposal that explains the initial fixes, ongoing activities, reporting and ownership of your accounts. Compare the deliverables rather than choosing solely by price or promised rankings.</p>
<h4>What is the best first step for local SEO?</h4>
<p>Start by checking whether customers can find accurate business information and contact your workshop successfully. An accurate Business Profile and a usable website provide a practical foundation.</p>
<h4>How can I get more customers into my mechanic shop?</h4>
<p>Focus on being discoverable for services you actually provide, giving customers useful reasons to consider your workshop and responding reliably to enquiries. Local SEO supports discovery, while service quality and follow-up help turn enquiries into lasting customer relationships.</p>
<h4>How long does local SEO take?</h4>
<p>There is no fixed timeframe. Google notes that search changes can take anything from hours to several months to be reflected. Results also depend on competition, your starting position and the changes made.</p>

<h3>Help Nearby Drivers Find Your Workshop</h3>
<p>W&amp;S Digital Marketing helps automotive businesses improve local visibility, present their services clearly and make online enquiries easier.</p>
<p>Whether your workshop needs clearer service pages, Google Business Profile improvements or a review of its booking journey, we can help identify practical next steps. Explore our <a href="/automotive">automotive digital marketing services</a> or <a href="/contact">get in touch</a> to talk about your workshop.</p>
',
    '',
    1,
    'Local SEO for Mechanics',
    'Help nearby drivers find your workshop with practical local SEO tips for mechanics, covering Google Business Profile, reviews, service pages and booking enquiries.'
);
