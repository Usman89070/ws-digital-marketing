<?php
// Editable copy for the homepage sections added below the services grid
// (index.php). Edit the text here -- no layout/PHP knowledge needed. Keep the
// quotes and commas as they are.
//
// The Author Bio stays hidden until its details are filled in.

// ---------------------------------------------------------------- Why Choose
// 'image' is any site path or full URL. The supplied brief names the final
// file ws-digital-marketing-team-sydney.webp -- upload it to /images/ and
// change the path below (keep it under 150 KB; set image_w / image_h to its
// real pixel size so the page does not jump while loading).
// Each point is [icon, title, text, link-or-null]; a link turns the title
// into an internal link.
$whyChoose = [
    'enabled'   => true,
    'eyebrow'   => 'WHY BUSINESSES CHOOSE US',
    'heading'   => 'Why Choose W&S Digital Marketing?',
    'intro'     => 'Choosing a digital marketing agency comes down to one question: will they actually grow your business? W&S Digital Marketing is a Sydney-based company helping Australian businesses win more customers through SEO, Google Ads, social media, website design and content. We don’t judge success by likes or “brand awareness”. We judge it by calls, enquiries and sales, and we show you those numbers every single month.',
    'image'     => '/images/about-ws.webp',
    'image_w'   => 1448,
    'image_h'   => 1086,
    'image_alt' => 'WS Digital Marketing team in Sydney planning SEO and Google Ads campaigns for Australian businesses',
    'points'    => [
        ['fa-chart-line', 'Proven, Measurable Results', 'Between May and September 2026, our combined client work generated 6.54K organic clicks, 782K search impressions and 1,070 phone calls straight from Google Business Profiles. These are real numbers from real Australian businesses, not projections.', '/case-studies'],
        ['fa-handshake', 'Month-to-Month, No Lock-In Contracts', 'We keep clients by delivering results, not by tying them into long contracts. Every plan runs month to month, so you stay because the work is paying off.', null],
        ['fa-file-lines', 'Reporting You Can Actually Understand', 'Each month you get a clear report on clicks, impressions, conversions, cost per lead and ROAS, plus a call with your strategist to explain what is working and what comes next.', null],
        ['fa-users', 'A Team You Know by Name', 'Your campaigns are run by people you can meet, led by our CEOs, Managing Director and Digital Marketing Manager. You will always know who is working on your account and who to call.', '/our-team'],
        ['fa-diagram-project', 'Every Channel, One Connected Strategy', 'SEO, Google Ads, Meta advertising, social media, website design, graphic design and content writing are planned together, so every channel pushes toward the same goal.', null],
        ['fa-briefcase', 'Industry Know-How Across 14 Sectors', 'From appliance repairs and construction to dental, legal, real estate, car detailing, healthcare and ecommerce, we adapt keywords, messaging and ads to how customers in your industry actually search and buy.', '/industries'],
    ],
    // Results strip under the cards: [value, label]. Always keep the date range.
    'results'      => [['782K', 'search impressions'], ['6.54K', 'organic clicks'], ['4.19K', 'Google Business Profile interactions'], ['1.07K', 'calls from Google']],
    'results_note' => 'Combined client results, May–September 2026',
    'cta_primary'   => ['Get My Free Growth Plan', '/contact'],
    'cta_secondary' => ['See Our Case Studies', '/case-studies'],
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
// Answers may contain simple HTML links. The FAQPage structured data is built
// from this same list, so the visible answers and the schema always match.
$homeFaqsIntro = 'Straight answers to the questions Australian business owners ask us most before getting started. Need more detail? Visit our <a href="/faq">full FAQ page</a> or <a href="/contact">speak with our team</a>.';
$homeFaqs = [
    ['What does W&S Digital Marketing do?', 'W&S Digital Marketing (often searched as WS Digital Marketing) is an Australian digital marketing agency that helps businesses attract more customers online. Our services include search engine optimisation (SEO), Google Ads and paid social advertising, social media marketing, website design and development, Shopify and WooCommerce ecommerce stores, graphic design and content writing. Every service is planned around one outcome: more enquiries, calls and sales for your business.'],
    ['Where is W&S Digital Marketing located, and which areas do you serve?', 'W&S Digital Marketing is based at 3 Weebill St, Melonba NSW 2765, in Sydney’s north-west, and works with businesses right across Australia. Because most of our work is delivered online, location is no barrier. Whether you run a local trades business in Sydney or an online store shipping nationwide, we build your strategy around the suburbs, cities or regions where your customers are searching.'],
    ['How can local SEO help my business get more calls from Google Maps?', 'Local SEO puts your business in front of nearby customers at the exact moment they search for your service. We optimise your Google Business Profile, keep your business details consistent across directories, strengthen your location pages and help you earn genuine reviews, so you appear more often in Google Maps and the local pack. From May to September 2026, our clients’ Google Business Profiles generated 4,190 interactions and 1,070 phone calls.'],
    ['Which industries does W&S Digital Marketing work with?', 'We work with businesses across 14 industries, including appliance repairs, construction and building, dental, healthcare and medical, legal, accounting and finance, real estate, automotive, hospitality and tourism, hotels and motels, NDIS providers, franchises, ecommerce and small businesses. Each sector has different customers, search habits and advertising rules, so we tailor keywords, messaging and campaigns to your industry instead of using a one-size-fits-all template.'],
    ['Who will manage my marketing at W&S Digital Marketing?', 'Your marketing is handled by the W&S team, led by CEOs Wishal Khan Mohammadi and Shawal Khan Mohammadi and Managing Director Sahar Afridi, who also leads social media strategy. Day-to-day work across SEO, ads and content is managed by our Digital Marketing Manager, Hammad Hassan. You will always know who is working on your campaigns, with a strategist available to walk you through your results.'],
    ['Can W&S Digital Marketing help my business appear in AI search results like Google AI Overviews and GEO?', 'Yes. Alongside traditional SEO, we make your business easier for AI search tools to understand and recommend. That includes clear, question-led website content, consistent business details across Google, directories and social profiles, structured data, and mentions on trusted Australian websites. No agency can guarantee an AI citation, but these same foundations strengthen your visibility in both Google results and AI-generated answers.'],
    ['What happens when I request a free growth plan?', 'You receive a zero-obligation review of your current marketing. Our team looks at your website, search visibility, Google Business Profile, ads and social channels, identifies your biggest opportunities, and recommends a plan built around your goals. There is no pressure to sign up, and if you go ahead, every plan runs month to month with no lock-in contract. Request yours on our <a href="/contact">contact page</a> or call <a href="tel:+61403889630">+61 403 889 630</a>.'],
];
