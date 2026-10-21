-- Combined migration: refreshes GSC/GBP stats on 4 existing case studies,
-- adds a "Google Search Console Performance" + "Google Business Profile
-- Performance" section (with the actual proof screenshots) to the summary
-- of ALL 6 case studies covered here, and adds the 2 brand new case
-- studies (AI Appliance Repairs, Fridge Repair Experts) complete with
-- those sections from the start.
--
-- Supersedes the earlier case-studies-stats-update.sql -- run THIS file
-- instead. Safe to run even if that earlier version already ran: the
-- summary-append UPDATEs below only add the sections if they aren't
-- already present (NOT LIKE guard), and the two new case studies use
-- INSERT ... ON DUPLICATE KEY UPDATE, so re-running this is harmless.
--
-- Run this in Hostinger hPanel -> phpMyAdmin. Upload the 12 screenshot
-- images in images/case-studies/ (same filenames referenced below) via
-- the admin panel or File Manager before/after running this -- the
-- <img onerror="this.remove()"> means the page still looks fine even if
-- an image hasn't landed yet.

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '886', stat1_label = 'Organic Clicks',
    stat2_value = '152K', stat2_label = 'Search Impressions',
    stat3_value = '533', stat3_label = 'GBP Interactions',
    stat4_value = '135', stat4_label = 'Calls From GBP'
WHERE slug = 'ace-fridge-repairs-sydney';

UPDATE case_studies SET
    summary = CONCAT(summary, '

<h3>Google Search Console Performance</h3>
<p><strong>886</strong> organic clicks from <strong>152K</strong> search impressions over the last 6 months, at an average CTR of 0.6% and an average position of 23.9.</p>
<img src="/images/case-studies/ace-fridge-repairs-sydney-gsc.png" alt="Ace Fridge Repairs Sydney Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>533</strong> total Business Profile interactions, including <strong>135</strong> calls, <strong>254</strong> direction requests and <strong>131</strong> website clicks.</p>
<img src="/images/case-studies/ace-fridge-repairs-sydney-gbp.png" alt="Ace Fridge Repairs Sydney Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">')
WHERE slug = 'ace-fridge-repairs-sydney' AND summary NOT LIKE '%Google Search Console Performance%';

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.45K', stat1_label = 'Organic Clicks',
    stat2_value = '93.9K', stat2_label = 'Search Impressions',
    stat3_value = '561', stat3_label = 'GBP Interactions',
    stat4_value = '15', stat4_label = 'Calls From GBP'
WHERE slug = 'freak-eats';

UPDATE case_studies SET
    summary = CONCAT(summary, '

<h3>Google Search Console Performance</h3>
<p><strong>1.45K</strong> organic clicks from <strong>93.9K</strong> search impressions over the last 6 months, at an average CTR of 1.5% and an average position of 15.3.</p>
<img src="/images/case-studies/freak-eats-gsc.png" alt="Freak Eats Australia Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>561</strong> total Business Profile interactions, including <strong>15</strong> calls, <strong>253</strong> direction requests and <strong>260</strong> website clicks.</p>
<img src="/images/case-studies/freak-eats-gbp.png" alt="Freak Eats Australia Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">')
WHERE slug = 'freak-eats' AND summary NOT LIKE '%Google Search Console Performance%';

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.01K', stat1_label = 'Organic Clicks',
    stat2_value = '176K', stat2_label = 'Search Impressions',
    stat3_value = '492', stat3_label = 'GBP Interactions',
    stat4_value = '99', stat4_label = 'Calls From GBP'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    summary = CONCAT(summary, '

<h3>Google Search Console Performance</h3>
<p><strong>1.01K</strong> organic clicks from <strong>176K</strong> search impressions over the last 6 months, at an average CTR of 0.6% and an average position of 21.5.</p>
<img src="/images/case-studies/fridge-experts-gsc.png" alt="Fridge Experts Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>492</strong> total Business Profile interactions, including <strong>99</strong> calls, <strong>283</strong> direction requests and <strong>105</strong> website clicks.</p>
<img src="/images/case-studies/fridge-experts-gbp.png" alt="Fridge Experts Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">')
WHERE slug = 'fridge-experts' AND summary NOT LIKE '%Google Search Console Performance%';

UPDATE case_studies SET
    period = 'Jun – Oct 2026',
    stat1_value = '1.6K', stat1_label = 'Organic Clicks',
    stat2_value = '152K', stat2_label = 'Search Impressions',
    stat3_value = '1,845', stat3_label = 'GBP Interactions',
    stat4_value = '709', stat4_label = 'Calls From GBP'
WHERE slug = 'fast-appliance-repairs';

UPDATE case_studies SET
    summary = CONCAT(summary, '

<h3>Google Search Console Performance</h3>
<p><strong>1.6K</strong> organic clicks from <strong>152K</strong> search impressions over the last 6 months, at an average CTR of 1.1% and an average position of 18.7.</p>
<img src="/images/case-studies/fast-appliance-repairs-gsc.png" alt="Fast Appliance Repairs Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>1,845</strong> total Business Profile interactions, including <strong>709</strong> calls, <strong>308</strong> direction requests and <strong>828</strong> website clicks.</p>
<img src="/images/case-studies/fast-appliance-repairs-gbp.png" alt="Fast Appliance Repairs Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">')
WHERE slug = 'fast-appliance-repairs' AND summary NOT LIKE '%Google Search Console Performance%';

INSERT INTO case_studies (
    name, slug, tag, image_path, image_alt, summary, services, has_data, period,
    stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label,
    display_order, meta_title, meta_description
) VALUES (
    'AI Appliance Repairs',
    'ai-appliance-repairs',
    'Appliances',
    '',
    'AI Appliance Repairs',
    'AI Appliance Repairs saw rapid growth in organic visibility this quarter: organic clicks rose from 40 to 524 (a 13x increase) and search impressions grew from 614 to 22,400 over the same six-month comparison. The Google Business Profile recorded 425 interactions, including 79 phone calls, 283 website clicks and 56 direction requests, giving the business a strong, newly-established base of local search demand.

<h3>Google Search Console Performance</h3>
<p><strong>524</strong> organic clicks from <strong>22.4K</strong> search impressions over the last 6 months, at an average CTR of 2.3% and an average position of 11.8.</p>
<img src="/images/case-studies/ai-appliance-repairs-gsc.png" alt="AI Appliance Repairs Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>425</strong> total Business Profile interactions, including <strong>79</strong> calls, <strong>56</strong> direction requests and <strong>283</strong> website clicks.</p>
<img src="/images/case-studies/ai-appliance-repairs-gbp.png" alt="AI Appliance Repairs Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">',
    'Local SEO & Keyword Optimisation
Google Business Profile Setup & Management
Website Click & Call Tracking
Ongoing Performance Reporting',
    1,
    'May – Oct 2026',
    '524', 'Organic Clicks', '22.4K', 'Search Impressions', '425', 'GBP Interactions', '79', 'Calls From GBP',
    16,
    'AI Appliance Repairs Local SEO Case Study',
    'See our local SEO project for AI Appliance Repairs, growing organic search clicks 13x and building a strong Google Business Profile presence from the ground up.'
) ON DUPLICATE KEY UPDATE
    tag = VALUES(tag),
    summary = VALUES(summary),
    services = VALUES(services),
    has_data = VALUES(has_data),
    period = VALUES(period),
    stat1_value = VALUES(stat1_value), stat1_label = VALUES(stat1_label),
    stat2_value = VALUES(stat2_value), stat2_label = VALUES(stat2_label),
    stat3_value = VALUES(stat3_value), stat3_label = VALUES(stat3_label),
    stat4_value = VALUES(stat4_value), stat4_label = VALUES(stat4_label),
    display_order = VALUES(display_order),
    meta_title = VALUES(meta_title),
    meta_description = VALUES(meta_description);

INSERT INTO case_studies (
    name, slug, tag, image_path, image_alt, summary, services, has_data, period,
    stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label,
    display_order, meta_title, meta_description
) VALUES (
    'Fridge Repair Experts',
    'fridge-repair-experts',
    'Fridge Repairs',
    '',
    'Fridge Repair Experts',
    'Fridge Repair Experts entered this period building its organic search and Google Business Profile presence from the ground up. Over six months, the site generated 971 organic clicks from 162K search impressions, while the Google Business Profile drove 334 direct interactions -- including 37 phone calls, 223 direction requests and 74 website clicks -- giving the business a steady, measurable flow of local enquiries.

<h3>Google Search Console Performance</h3>
<p><strong>971</strong> organic clicks from <strong>162K</strong> search impressions over the last 6 months, at an average CTR of 0.6% and an average position of 26.</p>
<img src="/images/case-studies/fridge-repair-experts-gsc.png" alt="Fridge Repair Experts Google Search Console performance" loading="lazy" decoding="async" onerror="this.remove()">

<h3>Google Business Profile Performance</h3>
<p><strong>334</strong> total Business Profile interactions, including <strong>37</strong> calls, <strong>223</strong> direction requests and <strong>74</strong> website clicks.</p>
<img src="/images/case-studies/fridge-repair-experts-gbp.png" alt="Fridge Repair Experts Google Business Profile performance" loading="lazy" decoding="async" onerror="this.remove()">',
    'Local SEO & Google Business Profile Management
Call & Enquiry Tracking
Service Area Content
Ongoing Performance Reporting',
    1,
    'May – Oct 2026',
    '971', 'Organic Clicks', '162K', 'Search Impressions', '334', 'GBP Interactions', '37', 'Calls From GBP',
    17,
    'Fridge Repair Experts Local SEO Case Study',
    'Explore our local SEO project for Fridge Repair Experts, building organic search visibility and Google Business Profile performance to a steady flow of local enquiries.'
) ON DUPLICATE KEY UPDATE
    tag = VALUES(tag),
    summary = VALUES(summary),
    services = VALUES(services),
    has_data = VALUES(has_data),
    period = VALUES(period),
    stat1_value = VALUES(stat1_value), stat1_label = VALUES(stat1_label),
    stat2_value = VALUES(stat2_value), stat2_label = VALUES(stat2_label),
    stat3_value = VALUES(stat3_value), stat3_label = VALUES(stat3_label),
    stat4_value = VALUES(stat4_value), stat4_label = VALUES(stat4_label),
    display_order = VALUES(display_order),
    meta_title = VALUES(meta_title),
    meta_description = VALUES(meta_description);

