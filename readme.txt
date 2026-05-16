=== VonSEO ===
Contributors: vondereich, kurama87
Tags: seo, toc, schema, sitemap, indexnow
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 2.3.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A premium, lightweight SEO toolkit with Table of Contents, System Health, XML Sitemaps, and Content Analysis.

== Description ==

VonSEO is a **premium-grade, ultra-lightweight SEO toolkit** ported from the **VonCMS** ecosystem. Designed for high-performance modern WordPress websites, it focuses on what actually matters: **High-Performance Metadata**, **Security**, and a **Clean User Experience**.

It eliminates the "operating system inside WordPress" bloat found in legacy SEO plugins, delivering a **state-of-the-art dashboard**, **automatic Table of Contents**, **XML sitemaps**, **IndexNow integration**, and **System Health** diagnostics in a lean footprint.

### Why Choose VonSEO?

While other SEO plugins constantly force you to upgrade to their "PRO" version to unlock basic features (like Redirection or TOC), VonSEO gives you everything out of the box.

*   **No Paywalls**: What you see is what you get. No hidden "Pro" tabs.
*   **Set & Forget**: Configure global settings once, and let the plugin handle the automations.
*   **Database Cleanliness**: We don't create custom tables. We use native WordPress `post_meta` and `wp_options`.
*   **Developer Friendly**: Hooks and filters available for extending functionality.

### Comprehensive Feature List

#### 1. Automated Smart Schema (JSON-LD)
We automatically generate Google-compliant Structured Data for your site:
*   **Article & WebPage**: Core schema for all content.
*   **FAQ & Video**: Rich snippets for enhanced search visibility.
*   **Review Ratings**: Add star ratings to your pages.
*   **Breadcrumbs**: Helps Google understand your site structure.

#### 2. Advanced Tools
*   **SEO Table of Contents (TOC)**: Automatic and interactive TOC with smooth transitions.
*   **XML Sitemaps**: Auto-generated `sitemap.xml` for Google/Bing.
*   **Instant Indexing (IndexNow)**: Notify search engines immediately about new content.
*   **System Health Monitor**: Real-time technical diagnostics in your dashboard.
*   **Redirection Manager**: Monitor 404s and create 301 redirects instantly.
*   **Image SEO**: Auto-add ALT and Title tags to images.

#### 3. Social Media Optimization
Look perfect when shared on social platforms:
*   **Open Graph**: Automatic `og:title`, `og:description`, `og:image`.
*   **Twitter Cards**: Support for `summary` and `summary_large_image` cards.

#### 4. State-of-the-Art Dashboard
*   **Content Analysis**: Real-time scoring of your content quality.
*   **Social Previews**: See how your post looks on Facebook before publishing.
*   **Granular Control**: Per-post NOINDEX and TOC toggle settings.

== Installation ==

1. Go to **Plugins > Add New** in your WordPress dashboard.
2. Search for **"VonSEO"**.
3. Click **Install Now** and then **Activate**.
4. Navigate to **VonSEO** in the sidebar to configure your settings.
5. Save changes, and you're done! Your site now emits premium SEO tags.

== Frequently Asked Questions ==

= Does this modify my database structure? =
**No.** VonSEO is extremely clean. It operates using a single `wp_options` row for global settings and standard `post_meta` for individual posts. It creates **0 custom tables**.

= Will this slow down my site? =
**Absolutely not.** VonSEO is designed with performance as a priority. It uses a lightweight frontend asset layer and does not load any heavy libraries.

= Is it compatible with Yoast or RankMath? =
VonSEO is a replacement for ти plugins. We recommend deactivating other general SEO plugins when using VonSEO.

= Is it compatible with Elementor, Divi, and Block Themes? =
**Yes.** VonSEO works with any properly coded theme or page builder, including Full Site Editing (FSE) themes.

== Upgrade Notice ==

= 2.3.0 =
Major release: Adds automatic Table of Contents, System Health diagnostics, advanced developer documentation, and a full security audit for production stability.

= 2.2.7 =
Stabilization release: Fixed admin Quick Edit responsiveness and finalized the RSS protection module.

= 2.2.6 =
Attachment redirects are now fully functional, sending media attachment pages to their published parent post with a safe fallback when needed.

== Screenshots ==

1. **Premium Dashboard** - The new centered, clean interface for global settings.
2. **Post Meta Box** - Per-post controls with real-time Google Search Preview.

== Changelog ==

= 2.2.6 =
*   **Added**: Attachment pages can now redirect to their published parent post, with a safe fallback to the media file URL when no parent is available.
*   **Fixed**: The existing Redirect Attachment URLs dashboard setting now performs the expected frontend 301 redirect behavior.
*   **Fixed**: Expanded shared WordPress stubs to cover the attachment-related core functions used by the redirect module.
*   **Maintenance**: Aligned plugin, package, docs, dist, and release artifact metadata for v2.2.6.

= 2.2.5 =
*   **Fixed**: Expanded the shared WordPress stubs to remove IDE false positives for breadcrumbs and related files.
*   **Fixed**: Added support for both [vonseo_breadcrumbs] and [vonseowp_breadcrumbs] shortcodes.
*   **Fixed**: Sitemap output now respects the saved sitemap enable/posts/pages settings.
*   **Fixed**: Hardened IndexNow legacy hooks and key-file path handling.
*   **Maintenance**: Synchronized plugin, package, docs, dist, and release artifact metadata for v2.2.5.

= 2.2.4 =
*   **Added**: Integrated comprehensive WordPress stubs within the main plugin file to resolve IDE "False Positive" errors globally.
*   **Fixed**: Added type-checking to prevent runtime errors when the 404 log is empty.
*   **Fixed**: Resolved missing translator comments for dynamic placeholders in meta boxes.
*   **Security**: Completed a system-wide audit of escaping and sanitization for all admin settings and frontend meta outputs.
*   **Maintenance**: Reorganized module loading to ensure PHP version and XML/DOM extension requirements are met before class instantiation.

= 2.2.3 =
*   **Added**: Built-in breadcrumbs generator via [vonseo_breadcrumbs] shortcode and vonseo_breadcrumbs() theme helper.
*   **Improved**: Added configurable breadcrumb separator in the admin settings.
*   **Fixed**: Synced homepage title/description, default social image, and Open Graph toggle with frontend output.
*   **Fixed**: Output Google and Bing verification meta tags from the saved Webmaster Tools settings.
*   **Polish**: Wrapped Dashboard tutorial strings in `_e()` for consistency.
*   **Dev Experience**: Added `_wp_stubs.php` for better IDE/LSP and AI support (excluded from production builds).

= 2.2.1 =
*   **Standardization**: Full English I18n support. Wrapped all user-facing strings in PHP and JavaScript with WordPress translation functions.
*   **Localization**: Implemented `wp_localize_script` for client-side messaging in Meta Box and Admin UI.
*   **Security**: Hardened JSON-LD schema output and audited AJAX handlers for XSS/CSRF compliance.
*   **Documentation**: Standardized internal logs and roadmap to English.

= 2.2.0 =
*   **Added**: AI & LLM Optimization - Native support for `llms.txt` to help AI models like ChatGPT and Claude parse site content efficiently.
*   **Added**: AI & LLM Admin Tab - New dedicated settings panel with Markdown editor and AEO template reset.
*   **Improved**: Smarter SEO Title/Description Validation - New flexible length indicators with premium gradient progress bars and "Optimal Range" guidance.

= 2.1.9 =
*   **Added**: Security & Performance - Native WP Header Cleanup module to remove unnecessary meta tags like wp_generator, rsd_link, and wlwmanifest.

= 2.1.8 =
*   **Added**: Social Media Preview - Live resizeable Facebook/Twitter card previews.
*   **Added**: Social Meta Tags - Dedicated Open Graph & Twitter Card controls.
*   **Added**: Schema Validator - Direct integration with validator.schema.org.
*   **UI**: Enhanced Meta Box with Glassmorphism tabs.

= 2.1.7 =
*   **Security**: Implement strict, field-specific sanitization for all settings (register_setting_args).
*   **Compliance**: Applied wp_unslash() before sanitization for all inputs.
*   **Core**: Refactored admin settings handling for better type safety.

= 2.1.6 =
*   **Security**: Hardened escaping and sanitization for WordPress.org compliance.
*   **Compliance**: Removed non-standard JSON options from metadata output.
*   **Cleanup**: Removed redundant inline scripts and styles.

= 2.1.5 =
*   **Added**: FAQ Schema (JSON-LD) repeater in Meta Box for Rich Snippets.
*   **Added**: Video Schema support for better video search visibility.
*   **Added**: Advanced Robots.txt Editor with one-click "Recommended Rules" sync.
*   **Security**: Full PHPCS audit and hardening for WordPress standards compliance.
*   **Fixed**: Robots.txt layout alignment and UI styling improvements.

= 2.1.4 =
*   **IMPROVED**: Offline AI logic now creates distinct Titles and Descriptions using smart HTML parsing.
*   **ADDED**: Metadata filtering to remove author credits and photo sources from AI suggestions.
*   **ADDED**: Automatic Focus Keyword injection in AI-generated content.
*   **IMPROVED**: Dashboard AI suggestions now use randomized templates and include Site Tagline.

= 2.1.2 =
*   **Security**: Enhanced escaping and sanitization across Frontend, Sitemap, and Competitors modules.
*   **Compliance**: Disabled OTA updater for WordPress.org repository approval.
*   **Fix**: Added missing `languages` directory.

= 2.1.1 =
*   **Fixed**: Updater instantiation in the main plugin file.
*   **Fixed**: Improved version comparison and cleaning for GitHub tags.
*   **Added**: OTA Update test release.

= 2.1.0 =
*   **Added**: Competitor Analysis Module - Real-time "SEO Math" comparison against any URL.
*   **Added**: AI Magic - Ultra-compact AI suggestions for Titles, Descriptions, and Keywords.
*   **Added**: Bi-directional Sync - Site Title & Tagline synchronized with WP General Settings.
*   **Added**: Support UI Facelift - Premium Glassmorphism design.
*   **Added**: Help & Tutorial Tab - Integrated quick-start guides.
*   **Fixed**: Security hardening against XSS and SSRF.

= 2.0.0 =
*   **NEW**: Full Premium Suite release.
*   **NEW**: XML Sitemap Generator (`/sitemap.xml`).
*   **NEW**: Redirection Manager with 404 Logging.
*   **NEW**: Local SEO & Schema markup support.
*   **NEW**: Image SEO (Auto ALT/Title tags).
*   **NEW**: Content Analysis in Post Editor.

= 1.13.0 =
*   **FIX**: Adjusted updater download link to correct package failure.

= 1.12.0 =
*   **NEW**: Added Auto-Updater directly from GitHub releases.
*   **FIX**: Minor stability improvements.

= 1.1.0 =
*   **NEW**: Complete UI Overhaul - introduced premium dashboard design.
*   **FIX**: Resolved PHP Warning "Undefined array key 'site_title'".
*   **IMPROVED**: Better spacing and typography in admin panels.
