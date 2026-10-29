<?php
// The shared SEO field set used by the Pages SEO and Posts & Case Studies forms.
//
// $v = current values; $o = options:
//   default_title / default_desc  what the page uses when a field is left blank
//   path                          the page's address (for the preview + placeholders)
//   show_extra                    show the "extra content block" editor
//   title_placeholder_note        optional hint text under the title field
function seo_render_fields(array $v, array $o): void
{
    $suffix = seo_setting('title_suffix', SEO_DEFAULT_TITLE_SUFFIX);
    $defaultTitle = (string) ($o['default_title'] ?? '');
    $defaultDesc = (string) ($o['default_desc'] ?? '');
    $path = (string) ($o['path'] ?? '/');
    $selfUrl = SEO_SITE_BASE . ($path === '/' ? '/' : $path);
    ?>
    <div class="section-title">Search appearance</div>
    <div class="form-grid">
        <div class="full">
            <label for="meta_title">Meta title <span class="counter"></span></label>
            <input type="text" id="meta_title" name="meta_title" data-counter="60" data-counter-min="30" data-serp-title
                   value="<?php echo h($v['meta_title'] ?? ''); ?>" placeholder="<?php echo h($defaultTitle); ?>">
            <div class="hint">Aim for 30&ndash;60 characters, with the main keyword near the start. The site name (<code><?php echo h(trim($suffix)); ?></code>) is added automatically unless you tick the box below.</div>

            <label for="meta_description">Meta description <span class="counter"></span></label>
            <textarea id="meta_description" name="meta_description" rows="3" data-counter="160" data-counter-min="70" data-serp-desc
                      placeholder="<?php echo h($defaultDesc); ?>"><?php echo h($v['meta_description'] ?? ''); ?></textarea>
            <div class="hint">Aim for 70&ndash;160 characters that sell the click. Google may rewrite it, but a good one lifts click-through.</div>

            <label class="check"><input type="checkbox" name="no_suffix" value="1" <?php echo !empty($v['no_suffix']) ? 'checked' : ''; ?>> Don't add the site name to this title</label>

            <div class="serp-preview" data-suffix="<?php echo h($suffix); ?>" data-default-title="<?php echo h($defaultTitle); ?>" data-default-desc="<?php echo h($defaultDesc); ?>">
                <div class="serp-url"><?php echo h($selfUrl); ?></div>
                <div class="serp-title"></div>
                <div class="serp-desc"></div>
            </div>
        </div>
    </div>

    <div class="section-title">Indexing &amp; canonical</div>
    <label for="canonical_url">Canonical URL</label>
    <input type="text" id="canonical_url" name="canonical_url" value="<?php echo h($v['canonical_url'] ?? ''); ?>" placeholder="<?php echo h($selfUrl); ?>">
    <div class="hint">Leave blank for a self-referencing canonical (recommended). Only set this when this page is a duplicate of another URL that should get the ranking credit.</div>
    <label class="check"><input type="checkbox" name="noindex" value="1" <?php echo !empty($v['noindex']) ? 'checked' : ''; ?>> <strong>noindex</strong> &mdash; ask search engines not to show this page (it's also removed from the sitemap)</label>
    <label class="check"><input type="checkbox" name="nofollow" value="1" <?php echo !empty($v['nofollow']) ? 'checked' : ''; ?>> <strong>nofollow</strong> &mdash; ask search engines not to follow links on this page</label>

    <div class="section-title">Social sharing (Facebook, LinkedIn, X, WhatsApp)</div>
    <div class="form-grid">
        <div>
            <label for="og_title">Share title</label>
            <input type="text" id="og_title" name="og_title" value="<?php echo h($v['og_title'] ?? ''); ?>" placeholder="Uses the meta title">
        </div>
        <div>
            <label for="og_image">Share image URL</label>
            <input type="text" id="og_image" name="og_image" value="<?php echo h($v['og_image'] ?? ''); ?>" placeholder="/images/... or https://...">
        </div>
        <div class="full">
            <label for="og_description">Share description</label>
            <input type="text" id="og_description" name="og_description" value="<?php echo h($v['og_description'] ?? ''); ?>" placeholder="Uses the meta description">
            <div class="hint">Best share image: 1200&times;630px JPG or PNG. If blank, the page's own image (or the site default from Site Settings) is used.</div>
        </div>
    </div>

    <div class="section-title">Sitemap</div>
    <label class="check"><input type="checkbox" name="in_sitemap" value="1" <?php echo !isset($v['in_sitemap']) || !empty($v['in_sitemap']) ? 'checked' : ''; ?>> Include this page in <code>sitemap.xml</code></label>
    <div class="form-grid">
        <div>
            <label for="sitemap_priority">Priority (0.0 &ndash; 1.0)</label>
            <input type="text" id="sitemap_priority" name="sitemap_priority" value="<?php echo h($v['sitemap_priority'] ?? ''); ?>" placeholder="Default">
        </div>
        <div>
            <label for="sitemap_changefreq">Change frequency</label>
            <select id="sitemap_changefreq" name="sitemap_changefreq">
                <?php foreach (SEO_CHANGEFREQ as $freq): ?>
                    <option value="<?php echo h($freq); ?>" <?php echo ($v['sitemap_changefreq'] ?? '') === $freq ? 'selected' : ''; ?>><?php echo $freq === '' ? 'Default' : h(ucfirst($freq)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="section-title">Structured data (JSON-LD)</div>
    <label for="schema_json">Schema for this page</label>
    <textarea id="schema_json" name="schema_json" class="mono tall" rows="8" placeholder='{"@context":"https://schema.org","@type":"Service", ...}'><?php echo h($v['schema_json'] ?? ''); ?></textarea>
    <div class="hint">Paste a JSON-LD object (Service, FAQPage, Article, LocalBusiness...) &mdash; without the <code>&lt;script&gt;</code> tags. It's validated on save and added to this page's <code>&lt;head&gt;</code>.</div>

    <?php if (!empty($o['show_extra'])): ?>
    <div class="section-title">Extra content block</div>
    <label for="extra_content">HTML shown at the bottom of the page, above the footer</label>
    <textarea id="extra_content" name="extra_content" class="mono tall" rows="10" placeholder="<h2>Heading</h2>&#10;<p>Keyword-rich copy, FAQs, links to related pages...</p>"><?php echo h($v['extra_content'] ?? ''); ?></textarea>
    <div class="hint">Use headings, paragraphs, lists and links (<code>&lt;h2&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;a href&gt;</code>). Scripts and inline event handlers are removed for safety. Shown in the site's normal text style.</div>
    <?php endif; ?>
    <?php
}
