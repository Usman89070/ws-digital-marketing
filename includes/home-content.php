<?php
// Editable copy for the homepage sections added below the services grid
// (index.php). Edit the text here -- no layout/PHP knowledge needed. Keep the
// quotes and commas as they are.
//
// Items marked PROVISIONAL are written only from claims already made
// elsewhere on this site (FAQ, CTA, pricing) so nothing invented goes live;
// swap in the final copy when it is ready.

// ---------------------------------------------------------------- Why Choose
// PROVISIONAL copy. 'image' is any site path or full URL (square-ish or 4:5
// photos look best, ~1000px wide, under 100KB).
$whyChoose = [
    'enabled' => true,
    'eyebrow' => 'WHY CHOOSE US',
    'heading' => 'Why Australian Businesses Choose W&S Digital Marketing',
    'intro'   => 'We keep marketing simple: a plan built around your numbers, honest monthly reporting and a team that stays accountable to results.',
    'image'   => '/images/about-ws.webp',
    'image_alt' => 'The W&S Digital Marketing team',
    'points'  => [
        ['fa-handshake',         'No Lock-In Contracts',     'All plans are month-to-month. We earn your business through results, not cancellation fees.'],
        ['fa-chart-line',        'Transparent Reporting',    'Clear monthly reports covering clicks, impressions, conversions, cost per lead and ROAS, with a strategist call to walk you through them.'],
        ['fa-bullseye',          'Custom Growth Strategy',   'Every plan starts with a zero-obligation audit and is built around your goals, not a one-size-fits-all package.'],
        ['fa-layer-group',       'Full-Service Team',        'SEO, Google Ads, social media, websites, design and content from one team that works together.'],
        ['fa-wallet',            'You Control Ad Spend',     'Your ad budget is paid directly to Google or Meta and stays fully in your control.'],
        ['fa-location-dot',      'Built For Australia',      'We work with Australian trades, healthcare, ecommerce, hospitality and service businesses every day.'],
    ],
    // Optional row of headline numbers under the points (leave [] to hide).
    'badges'  => [],
];

// ---------------------------------------------------------------- Author bio
// NOT SHOWN until 'enabled' is true. Fill in the details, then flip it on.
// 'photo': leave '' to pull the photo from the Team page entry named in
// 'team_member' (exact name as saved in Admin -> Team), or set a path/URL.
$authorBio = [
    'enabled'     => false,
    'eyebrow'     => 'MEET THE CEO',
    'name'        => '',
    'role'        => 'Chief Executive Officer, W&S Digital Marketing',
    'team_member' => '',
    'photo'       => '',
    // Press Enter inside the quotes for a new paragraph.
    'bio'         => '',
    // Short expertise chips, e.g. ['SEO', 'Google Ads', 'Shopify'].
    'specialties' => [],
    // Highlight numbers, e.g. [['10+', 'Years experience'], ['150+', 'Clients']].
    'highlights'  => [],
    // Links shown as icons: ['linkedin' => 'https://...', 'facebook' => '...', 'instagram' => '...', 'email' => 'name@example.com']
    'links'       => [],
];

// ---------------------------------------------------------------- Reviews
$reviewsSection = [
    'eyebrow' => 'CLIENT REVIEWS',
    'heading' => 'Real Reviews From Our Google Business Profile',
    // Shown instead when Google reviews are not connected yet and the cards
    // come from Admin -> Reviews.
    'heading_fallback' => 'What Our Clients Say',
    // Where "Write a review" / "See all reviews" send people. Used only if the
    // Google Maps link cannot be read from the live feed.
    'google_url' => 'https://www.google.com/search?q=W%26S+Digital+Marketing+reviews',
    'max_cards'  => 9,
];

// ---------------------------------------------------------------- FAQs
// PROVISIONAL: the first six answers from the FAQ page. Answers may contain
// simple HTML links. 5-7 items work best.
$homeFaqs = [
    ['How quickly will I see results?', 'PPC campaigns typically start generating leads within days of launch. SEO is a longer-term investment, with most clients seeing meaningful ranking improvements within 3-6 months, depending on competition and starting position.'],
    ['Do you require long-term contracts?', 'No. All of our plans are month-to-month with no lock-in contracts. We earn your business through results, not through cancellation fees.'],
    ['What industries do you work with?', 'We work across trades &amp; services, healthcare, professional services, eCommerce, hospitality and automotive. See our <a href="/industries">Industries</a> page for how we tailor strategy per sector.'],
    ['How does your reporting work?', 'Every client gets transparent, easy-to-read monthly reporting covering clicks, impressions, conversions, cost per lead and ROAS, plus a strategist call to walk through what is working and what is next.'],
    ['Do you manage the ad spend budget?', 'Our plans cover strategy, management and optimisation. Ad spend (what you pay directly to Google or Meta) is billed separately and stays fully in your control.'],
    ['How do I get started?', 'Book a zero-obligation growth audit through our <a href="/contact">contact page</a>. We will review your current marketing, identify opportunities and recommend a plan tailored to your goals.'],
];
