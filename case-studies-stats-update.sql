-- Refreshes the "Results At A Glance" stats on 4 existing case studies with
-- new Search Console + Google Business Profile numbers, and adds 2 brand
-- new case studies (AI Appliance Repairs, Fridge Repair Experts).
--
-- The 4 UPDATEs replace each case study's previous stat1-4 (which held
-- older keyword-rank-tracking figures) with a consistent set across all of
-- them: Organic Clicks, Search Impressions, GBP Interactions, Calls From
-- GBP -- matching the exact label wording already used elsewhere in this
-- table (e.g. "GBP Interactions", "Calls From GBP"), sourced from GSC/GBP
-- screenshots covering roughly the last 6 months.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, the same way the other
-- *-migration.sql files were run.

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '886', stat1_label = 'Organic Clicks',
    stat2_value = '152K', stat2_label = 'Search Impressions',
    stat3_value = '533', stat3_label = 'GBP Interactions',
    stat4_value = '135', stat4_label = 'Calls From GBP'
WHERE slug = 'ace-fridge-repairs-sydney';

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.45K', stat1_label = 'Organic Clicks',
    stat2_value = '93.9K', stat2_label = 'Search Impressions',
    stat3_value = '561', stat3_label = 'GBP Interactions',
    stat4_value = '15', stat4_label = 'Calls From GBP'
WHERE slug = 'freak-eats';

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.01K', stat1_label = 'Organic Clicks',
    stat2_value = '176K', stat2_label = 'Search Impressions',
    stat3_value = '492', stat3_label = 'GBP Interactions',
    stat4_value = '99', stat4_label = 'Calls From GBP'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    period = 'Jun – Oct 2026',
    stat1_value = '1.6K', stat1_label = 'Organic Clicks',
    stat2_value = '152K', stat2_label = 'Search Impressions',
    stat3_value = '1,845', stat3_label = 'GBP Interactions',
    stat4_value = '709', stat4_label = 'Calls From GBP'
WHERE slug = 'fast-appliance-repairs';

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
    'AI Appliance Repairs saw rapid growth in organic visibility this quarter: organic clicks rose from 40 to 524 (a 13x increase) and search impressions grew from 614 to 22,400 over the same six-month comparison. The Google Business Profile recorded 425 interactions, including 79 phone calls, 283 website clicks and 56 direction requests, giving the business a strong, newly-established base of local search demand.',
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
),
(
    'Fridge Repair Experts',
    'fridge-repair-experts',
    'Fridge Repairs',
    '',
    'Fridge Repair Experts',
    'Fridge Repair Experts entered this period building its organic search and Google Business Profile presence from the ground up. Over six months, the site generated 971 organic clicks from 162K search impressions, while the Google Business Profile drove 334 direct interactions -- including 37 phone calls, 223 direction requests and 74 website clicks -- giving the business a steady, measurable flow of local enquiries.',
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
);
