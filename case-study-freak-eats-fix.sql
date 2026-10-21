-- Fixes only Freak Eats Australia. The earlier migrations targeted slug
-- 'freak-eats', but its real slug in the live database is
-- 'freak-eats-australia' (it was regenerated from the project name at
-- some point via the admin panel), so those UPDATEs never matched it.

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
WHERE slug = 'freak-eats-australia';
