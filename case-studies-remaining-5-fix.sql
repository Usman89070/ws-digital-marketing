-- Simple, direct fix for the 5 projects that the earlier migrations
-- never actually reached (only ace-fridge-repairs-sydney's row was
-- ever updated by either case-studies-stats-update.sql or
-- case-studies-gsc-gbp-sections-migration.sql -- everything after it in
-- those files silently never applied).
--
-- No PREPARE/EXECUTE, no dynamic SQL, no ALTER TABLE here -- the gsc_*/
-- gbp_* columns already exist (confirmed in the admin panel). This file
-- is just plain UPDATE/INSERT statements, one per project, so there is
-- nothing that can silently stop partway through.
--
-- Please run this via phpMyAdmin's SQL tab (paste the whole file into the
-- query box and click Go), not the Import/file-upload tab -- that way any
-- error shows up immediately and we can see exactly which statement it's
-- on, if anything goes wrong again.

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.45K', stat1_label = 'Organic Clicks',
    stat2_value = '93.9K', stat2_label = 'Search Impressions',
    stat3_value = '561', stat3_label = 'GBP Interactions',
    stat4_value = '15', stat4_label = 'Calls From GBP',
    has_data = 1,
    gsc_clicks = '1.45K', gsc_impressions = '93.9K',
    gsc_ctr = '1.5', gsc_position = '15.3',
    gsc_image = '/images/case-studies/freak-eats-gsc.png',
    gbp_interactions = '561', gbp_calls = '15',
    gbp_directions = '253', gbp_website_clicks = '260',
    gbp_image = '/images/case-studies/freak-eats-gbp.png'
WHERE slug = 'freak-eats';

UPDATE case_studies SET
    period = 'May – Oct 2026',
    stat1_value = '1.01K', stat1_label = 'Organic Clicks',
    stat2_value = '176K', stat2_label = 'Search Impressions',
    stat3_value = '492', stat3_label = 'GBP Interactions',
    stat4_value = '99', stat4_label = 'Calls From GBP',
    has_data = 1,
    gsc_clicks = '1.01K', gsc_impressions = '176K',
    gsc_ctr = '0.6', gsc_position = '21.5',
    gsc_image = '/images/case-studies/fridge-experts-gsc.png',
    gbp_interactions = '492', gbp_calls = '99',
    gbp_directions = '283', gbp_website_clicks = '105',
    gbp_image = '/images/case-studies/fridge-experts-gbp.png'
WHERE slug = 'fridge-experts';

UPDATE case_studies SET
    period = 'Jun – Oct 2026',
    stat1_value = '1.6K', stat1_label = 'Organic Clicks',
    stat2_value = '152K', stat2_label = 'Search Impressions',
    stat3_value = '1,845', stat3_label = 'GBP Interactions',
    stat4_value = '709', stat4_label = 'Calls From GBP',
    has_data = 1,
    gsc_clicks = '1.6K', gsc_impressions = '152K',
    gsc_ctr = '1.1', gsc_position = '18.7',
    gsc_image = '/images/case-studies/fast-appliance-repairs-gsc.png',
    gbp_interactions = '1,845', gbp_calls = '709',
    gbp_directions = '308', gbp_website_clicks = '828',
    gbp_image = '/images/case-studies/fast-appliance-repairs-gbp.png'
WHERE slug = 'fast-appliance-repairs';

INSERT INTO case_studies (
    name, slug, tag, image_path, image_alt, summary, services, has_data, period,
    stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label,
    display_order, meta_title, meta_description,
    gsc_clicks, gsc_impressions, gsc_ctr, gsc_position, gsc_image,
    gbp_interactions, gbp_calls, gbp_directions, gbp_website_clicks, gbp_image
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
    'See our local SEO project for AI Appliance Repairs, growing organic search clicks 13x and building a strong Google Business Profile presence from the ground up.',
    '524', '22.4K', '2.3', '11.8', '/images/case-studies/ai-appliance-repairs-gsc.png',
    '425', '79', '56', '283', '/images/case-studies/ai-appliance-repairs-gbp.png'
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
    meta_description = VALUES(meta_description),
    gsc_clicks = VALUES(gsc_clicks), gsc_impressions = VALUES(gsc_impressions),
    gsc_ctr = VALUES(gsc_ctr), gsc_position = VALUES(gsc_position), gsc_image = VALUES(gsc_image),
    gbp_interactions = VALUES(gbp_interactions), gbp_calls = VALUES(gbp_calls),
    gbp_directions = VALUES(gbp_directions), gbp_website_clicks = VALUES(gbp_website_clicks), gbp_image = VALUES(gbp_image);

INSERT INTO case_studies (
    name, slug, tag, image_path, image_alt, summary, services, has_data, period,
    stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label,
    display_order, meta_title, meta_description,
    gsc_clicks, gsc_impressions, gsc_ctr, gsc_position, gsc_image,
    gbp_interactions, gbp_calls, gbp_directions, gbp_website_clicks, gbp_image
) VALUES (
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
    'Explore our local SEO project for Fridge Repair Experts, building organic search visibility and Google Business Profile performance to a steady flow of local enquiries.',
    '971', '162K', '0.6', '26', '/images/case-studies/fridge-repair-experts-gsc.png',
    '334', '37', '223', '74', '/images/case-studies/fridge-repair-experts-gbp.png'
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
    meta_description = VALUES(meta_description),
    gsc_clicks = VALUES(gsc_clicks), gsc_impressions = VALUES(gsc_impressions),
    gsc_ctr = VALUES(gsc_ctr), gsc_position = VALUES(gsc_position), gsc_image = VALUES(gsc_image),
    gbp_interactions = VALUES(gbp_interactions), gbp_calls = VALUES(gbp_calls),
    gbp_directions = VALUES(gbp_directions), gbp_website_clicks = VALUES(gbp_website_clicks), gbp_image = VALUES(gbp_image);

