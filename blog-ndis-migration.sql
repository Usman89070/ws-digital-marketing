-- Adds dedicated SEO meta title/description fields to blog posts, if not
-- already added by an earlier migration (safe to run either order or run
-- this one alone -- the column check is the same idempotent pattern), and
-- inserts the new "How NDIS Providers Can Generate More Relevant
-- Enquiries Online" article.
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
    'How NDIS Providers Can Generate More Relevant Enquiries Online',
    'how-ndis-providers-can-generate-relevant-enquiries-online',
    'Local SEO',
    'Help your NDIS business attract relevant enquiries with clear service pages, local SEO, useful referral information and accessible website contact options.',
    '<p>Your NDIS business may be getting website visitors, phone calls and form submissions. But are those enquiries about services you actually provide, in locations you cover, and at times when you have availability?</p>
<p>More enquiries do not always mean a better marketing result. Job applications, requests from outside your service area and enquiries about unavailable supports can take time away from helping people find suitable services.</p>
<p>Effective NDIS marketing starts with clear information. Participants, their chosen supporters and referral partners should be able to understand what your business offers, where you operate and how to contact you.</p>
<p>This guide explains how NDIS providers can improve their online presence and make it easier for people to enquire about relevant services.</p>

<h3>1. Define What a Relevant Enquiry Looks Like</h3>
<p>Before investing in more marketing, identify the types of enquiries your business can respond to effectively.</p>
<p>Consider:</p>
<ul>
<li>The supports you currently deliver.</li>
<li>The suburbs or regions you serve.</li>
<li>Your current service availability.</li>
<li>The needs your team has the skills and experience to support.</li>
<li>The information required to discuss whether your service may be suitable.</li>
</ul>
<p>A community participation provider operating in a defined area needs a different marketing approach from a provider delivering specialist services across several locations.</p>
<p>Review recent enquiries and look for repeated misunderstandings. If people regularly ask about services you do not offer, your website or advertising may need clearer wording.</p>
<p>The aim is to help people make informed decisions and reduce avoidable confusion. An enquiry can still be valuable even when the appropriate response is to explain that another service may be more suitable.</p>

<h3>2. Explain What Makes Your Service Different</h3>
<p>Statements such as "quality care" and "personalised support" say little about how your business works.</p>
<p>Give visitors practical information they can use when comparing providers.</p>
<p>Depending on your actual services, this might include:</p>
<ul>
<li>A specific area of support or professional expertise.</li>
<li>The locations where your team regularly works.</li>
<li>Languages spoken by your team.</li>
<li>How you discuss preferences and support needs.</li>
<li>The steps involved in starting a service.</li>
<li>Current availability and how to check it.</li>
</ul>
<p>For example, "Community participation support across Penrith and surrounding suburbs" communicates more than "Helping you live your best life".</p>
<p>Any statement about experience, qualifications, responsiveness or availability should be accurate and supportable. The NDIS Code of Conduct emphasises integrity, honesty, transparency and respect for individual decision-making.</p>

<h3>3. Create Clear Pages for Each Main Service</h3>
<p>A single page listing every support can leave visitors with unanswered questions.</p>
<p>Give your main services dedicated pages where there is enough useful information to justify them. Each page should explain:</p>
<ul>
<li>What the service involves.</li>
<li>How and where it is delivered.</li>
<li>Who can contact your team to discuss suitability.</li>
<li>What happens after an enquiry.</li>
<li>How to ask questions or request further information.</li>
</ul>
<p>Explain unfamiliar terms when they first appear. Participants and family members should not need industry knowledge to understand your offer.</p>
<p>Keep your registration status, qualifications and service scope accurate. Avoid wording that implies government endorsement or capabilities your business does not hold.</p>

<h4>Separate service enquiries from recruitment</h4>
<p>If you recruit support workers through your website, provide a clearly labelled careers page and application route.</p>
<p>This helps job seekers reach the right person and makes service enquiries easier to manage.</p>

<h3>4. Make Your Service Areas Easy to Find</h3>
<p>Visitors should not have to submit a form to discover whether you operate in their area.</p>
<p>State your genuine service coverage on relevant pages. Explain whether people attend your premises, receive support at home, meet in the community or use another delivery arrangement.</p>
<p>For local search visibility:</p>
<ul>
<li>Use accurate service and location wording in page titles and headings.</li>
<li>Describe the areas covered by each service.</li>
<li>Keep contact information consistent.</li>
<li>Link related service and location information.</li>
<li>Update coverage when your operations change.</li>
</ul>
<p>Avoid creating dozens of near-identical suburb pages. A location page should provide useful information about services actually available there.</p>
<p>For example, a page about community participation support in Penrith should explain the local service offer, rather than repeat another page with a different suburb name.</p>
<p>Our <a href="/seo">SEO services</a> can help structure this content correctly.</p>

<h3>5. Keep Your Google Business Profile Accurate</h3>
<p>If your business meets Google''s eligibility requirements, a Google Business Profile can help people find your services through local search and Maps.</p>
<p>Eligibility depends on how the business operates. Google generally requires in-person contact with customers during stated hours, so an online-only operation should not assume it qualifies.</p>
<p>For an eligible profile, check:</p>
<ul>
<li>Your business name and category.</li>
<li>Your address or service-area settings.</li>
<li>Your phone number, website and opening hours.</li>
<li>Your service descriptions.</li>
<li>Your photos and business information.</li>
</ul>
<p>Make sure the profile and website describe the same business and services.</p>
<p>Google says local results mainly depend on relevance, distance and prominence. Accurate information helps Google understand your business, but no provider or marketing agency can guarantee a particular Maps position.</p>

<h3>6. Give Referral Partners Useful Information</h3>
<p>Support coordinators and other referral partners need clear, current information when helping someone explore service options.</p>
<p>Create a dedicated referrer page or a short, accessible service overview covering:</p>
<ul>
<li>Available supports.</li>
<li>Service locations.</li>
<li>Current capacity and how to confirm it.</li>
<li>Relevant team expertise.</li>
<li>Enquiry and referral steps.</li>
<li>A named business contact or monitored contact channel.</li>
</ul>
<p>Keep this information consistent with your website. An outdated capacity document can create unnecessary calls and unsuitable referrals.</p>
<p>Online information can also support relationships developed through local professional networks, community organisations and relevant events.</p>
<p>The purpose is to make your services easier to understand while preserving participant choice. Referral relationships should be transparent, and actual or perceived conflicts of interest should be managed appropriately, in line with the NDIA''s conflict-of-interest guidance.</p>

<h3>7. Make Your Website Easier to Use</h3>
<p>A visitor may understand your service but still struggle to contact you.</p>
<p>Small text, confusing navigation, inaccessible forms and buttons that are difficult to use can interrupt an enquiry.</p>
<p>Review practical accessibility features such as:</p>
<ul>
<li>Clear headings and readable text.</li>
<li>Sufficient colour contrast.</li>
<li>Keyboard access to menus, buttons and forms.</li>
<li>Descriptive links and properly labelled form fields.</li>
<li>Helpful error messages.</li>
<li>Captions for relevant video content.</li>
<li>Layouts that remain usable when visitors enlarge text.</li>
</ul>
<p>Provide more than one contact method where your team can support it. Some visitors may prefer email or an online form to a phone call.</p>
<p>These are starting points, rather than proof that a website meets a particular accessibility standard. Appropriate testing is needed to identify barriers.</p>

<h3>8. Keep the First Enquiry Simple</h3>
<p>An initial contact form should help someone begin a conversation. It does not always need to collect everything required for a full service intake.</p>
<p>Consider whether you initially need only:</p>
<ul>
<li>A name and contact method.</li>
<li>A general service enquiry.</li>
<li>A suburb or postcode.</li>
<li>A preferred way to receive a response.</li>
</ul>
<p>Explain what happens after submission and who will respond. Only publish a response timeframe your team can reasonably meet.</p>
<p>Avoid asking visitors to upload detailed plans, medical records or other sensitive documents through a general marketing form unless there is a clear need and an appropriate collection process.</p>
<p>Where the Australian Privacy Principles apply, personal information collection must meet relevant necessity requirements, and sensitive information has additional protections. Review your forms against the obligations that apply to your organisation, referencing the OAIC''s collection guidance.</p>
<p>Test the entire enquiry process regularly, including confirmation messages and delivery to the correct team member.</p>

<h3>9. Publish Content That Answers Service Questions</h3>
<p>Helpful content can address questions people ask before contacting a provider.</p>
<p>Useful topics may include:</p>
<ul>
<li>What happens after someone contacts your team.</li>
<li>How your particular support service works.</li>
<li>Questions to ask when comparing providers.</li>
<li>How to check your service locations and availability.</li>
<li>What information helps your team discuss service suitability.</li>
<li>How participants can communicate preferences or concerns.</li>
</ul>
<p>Keep the content within your expertise. Avoid presenting general information as an individual funding decision or personalised clinical advice.</p>
<p>Link articles to the relevant service page so readers can find practical next steps.</p>
<p>If information relates to NDIS rules or processes, reference the official source and review it when guidance changes.</p>

<h3>10. Use Email Updates Thoughtfully</h3>
<p>Relevant updates can help referral partners and interested contacts stay informed about your services.</p>
<p>An update might explain a new service location, a change in availability or a useful resource your team has published.</p>
<p>Keep messages specific and useful. Do not automatically add everyone who submits a service enquiry to a promotional mailing list.</p>
<p>For commercial email marketing, ACMA''s guidance requires recipient consent, clear sender identification and an easy way to unsubscribe. Maintain records of consent and honour unsubscribe requests.</p>

<h3>11. Prepare Before Paying for Advertising</h3>
<p>Paid advertising can introduce people to your services, but it works best when the destination page and enquiry process are ready.</p>
<p>Before launching a campaign, check that:</p>
<ul>
<li>The advertised service is available.</li>
<li>The service area is accurate.</li>
<li>The landing page matches the advertisement.</li>
<li>The contact process works.</li>
<li>Your team can respond to enquiries.</li>
<li>You have a clear budget and measurement plan.</li>
</ul>
<p>Use factual, service-led wording. Avoid promises such as "guaranteed NDIS approval" or "instant funding access" that imply control over decisions your business does not make.</p>
<p>The ACCC explains that businesses must not make misleading claims or promises they cannot support. These consumer-law requirements are separate from NDIS obligations and advertising platform policies.</p>
<p>Targeting also needs care. For example, Google restricts personalised advertising involving sensitive interests, including health-related categories. Check the rules that apply to your services and campaign setup before using audience targeting or remarketing.</p>

<h3>12. Measure Enquiry Relevance and Follow-Up</h3>
<p>Traffic and clicks show activity. They do not tell you whether your marketing helps people find suitable services.</p>
<p>Review your enquiry journey using measures such as:</p>

<div style="overflow-x:auto; margin: 24px 0;">
<table style="width:100%; min-width:560px; border-collapse:collapse; font-size:0.95rem;">
<thead>
<tr style="background: var(--bg-secondary);">
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What to review</th>
<th style="text-align:left; padding:12px 14px; border:1px solid var(--border-light); color: var(--navy); font-weight:800;">What it helps you understand</th>
</tr>
</thead>
<tbody>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Enquiries by service</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether your main services attract interest</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Enquiries by general location</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether marketing reaches your actual coverage area</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Recruitment enquiries reaching service forms</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether contact routes need clearer separation</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Enquiries about unavailable services</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether advertising or service information needs updating</td></tr>
<tr><td style="padding:12px 14px; border:1px solid var(--border-light);">Response times and missed contacts</td><td style="padding:12px 14px; border:1px solid var(--border-light);">Whether follow-up is limiting useful conversations</td></tr>
</tbody>
</table>
</div>

<p>Keep reporting proportionate and protect personal information. Use broad categories rather than copying sensitive enquiry details into marketing dashboards.</p>
<p>If you use Google Analytics, ensure personal information is not sent through form tracking, page addresses or event data.</p>
<p>Assign responsibility for checking enquiries and updating availability. More advertising will have limited value if messages remain unanswered or service information is out of date.</p>

<h3>Where Should Your NDIS Business Start?</h3>
<p>Choose one service you currently have capacity to deliver and review its entire online journey.</p>
<p>Search for the service, read the page on a mobile phone and test the contact options. Ask someone unfamiliar with your business whether they can understand:</p>
<ul>
<li>What you offer.</li>
<li>Where you operate.</li>
<li>How to discuss suitability.</li>
<li>What happens after they contact you.</li>
</ul>
<p>Fix unclear information and broken enquiry steps before expanding your marketing.</p>

<h3>Frequently Asked Questions</h3>
<h4>Can a new NDIS provider generate enquiries without a large advertising budget?</h4>
<p>Yes, a new provider can begin with clear service information, accurate local details, useful referral resources and reliable follow-up. The volume and timing of enquiries will depend on factors such as demand, competition, service availability and visibility.</p>
<h4>Should an NDIS provider website focus on participants or support coordinators?</h4>
<p>It should make information useful to participants, their chosen supporters and relevant referral partners. A clear participant-facing service page can sit alongside more detailed referrer information.</p>
<h4>Do NDIS providers need paid advertising?</h4>
<p>Paid advertising is optional. First review whether people can find your services, understand your offer and contact your team easily. Advertising may then help extend your reach when your services and response process are ready.</p>

<h3>Make Your NDIS Services Easier to Find and Understand</h3>
<p>W&amp;S Digital Marketing helps NDIS providers improve how they present their services online through clearer websites, local search visibility, referrer information and straightforward enquiry pathways.</p>
<p>If your business is receiving enquiries that do not match your services&mdash;or visitors struggle to understand your offer&mdash;we can review where the journey needs improvement. Our <a href="/ndis">NDIS provider marketing services</a> are built around exactly this kind of clarity.</p>
',
    '',
    1,
    'How NDIS Providers Can Generate More Relevant Enquiries Online',
    'Help your NDIS business attract relevant enquiries with clear service pages, local SEO, useful referral information and accessible website contact options.'
);
