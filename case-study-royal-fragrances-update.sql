-- Adds real Search Console / Generative AI / Business Profile numbers and
-- a results summary to Royal Fragrances, which previously had no stats
-- (has_data = 0, empty summary placeholder).
--
-- Note: the Business Profile screenshot supplied for this project shows
-- "Views" and "Search appearances" (not the Calls/Directions/Website
-- Clicks breakdown used for the other case studies), so it's recorded
-- via the flexible gbp_extra_* field rather than invented action numbers.
--
-- Run this in Hostinger hPanel -> phpMyAdmin, SQL tab.

UPDATE case_studies SET
    has_data = 1,
    period = 'May – Oct 2026',
    summary = 'Royal Fragrances built strong organic visibility over the reporting period, generating 7.2K organic clicks from 268K search impressions at an average position of 10.9. The brand''s visibility in Google''s Generative AI features also grew to 17.4K impressions, showing up in AI-powered search results alongside traditional listings. On Google Business Profile, the brand recorded 72,764 profile views and 14,088 search appearances, with branded terms such as "perfume", "fragrance" and "private blends brisbane" driving consistent discovery.',
    gsc_clicks = '7.2K', gsc_impressions = '268K', gsc_ctr = '2.7', gsc_position = '10.9',
    gsc_image = '/images/case-studies/royal-fragrances-gsc.jpg',
    gsc_ai_value = '17.4K', gsc_ai_image = '/images/case-studies/royal-fragrances-gsc-ai.jpg',
    gbp_extra_label = 'Business Profile Views', gbp_extra_value = '72,764',
    gbp_extra_image = '/images/case-studies/royal-fragrances-gbp.jpg'
WHERE slug = 'royal-fragrances';
