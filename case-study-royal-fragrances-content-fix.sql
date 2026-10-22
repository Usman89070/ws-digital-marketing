-- Restores Royal Fragrances' original summary text -- the previous
-- migration (case-study-royal-fragrances-update.sql) mistakenly
-- rewrote it when only the stats/images should have changed. This
-- fixes the content back to the original, without touching any of the
-- stat/image fields already set.

UPDATE case_studies SET
    summary = 'An e-commerce fragrance brand supported with online store development, content and ongoing digital marketing.'
WHERE slug = 'royal-fragrances';
