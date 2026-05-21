# Changelog

All notable changes to the VonSEOWP plugin will be documented in this file.

## [2.3.2] - 2026-05-17
### Fixed
- **PHP 7.4 Compatibility**: Backported PHP 8 mixed parameters and union type-hints to standard PHP 7.4-compatible signatures across all modules.
- **Rewrite Flush Timing**: Corrected version-update check and flush_rewrite_rules execution timing by shifting it to a late `init` hook priority (999) to prevent 404 errors on sitemaps and LLM endpoints.
- **Robots Meta Hardening**: Robots tag now respects WordPress' core "Discourage search engines from indexing this site" privacy setting, search results pages (`is_search()`), and 404 pages (`is_404()`).
- **Dynamic Rating Count**: Restored full dynamic rating count functionality for Review/Product schema graphs by adding `rating_count` save pathways in the admin meta box.
- **Security Hardening**: Relocated `ABSPATH` access protection guards to the absolute first line of admin layout templates to enforce strict direct-access restrictions.
- **Release Audit Closure**: Added rating count uninstall cleanup, hardened admin external links with `rel="noopener noreferrer"`, and made the sitemap respect WordPress site visibility privacy.
- **Admin Tab Persistence**: Settings pages now return to the active tab after saving instead of falling back to General.
- **Admin Header Polish**: Replaced the Professional badge with a cleaner product description and aligned the logo/title block.

## [2.3.1] - 2026-05-17
### Added
- **Sitemap Index System**: Automated generation of `sitemap_index.xml` when post count exceeds 1,000 for improved crawling efficiency.
- **Competitor Analysis Cache**: Implemented 12-hour transient caching for URL scans to prevent redundant scraping and improve dashboard performance.
- **Repository Standards**: Added `.gitattributes` to standardize LF line endings across development environments.
- **Local Analyzer Roadmap**: Integrated architecture plans for v2.3.4 (JS) and v2.4 (PHP) into the roadmap.

### Fixed
- **Sitemap Query Conflict**: Renamed pagination parameter to `vonseowp_sitemap_page` to prevent conflicts with WordPress core post queries.
- **Security Hardening**: Applied `wp_kses_post` escaping to the `llms.txt` output layer.
- **Schema Accuracy**: Replaced hardcoded `ratingCount` with dynamic meta-data retrieval.
- **404 Asset Errors**: Resolved browser console errors by disabling non-existent public CSS/JS enqueues.
- **IDE Support**: Expanded `_wp_stubs.php` with missing WordPress core functions and constants.

## [2.3.0] - 2026-05-16
### Added
- **SEO Table of Contents (TOC)**: Automatic TOC generator with anchor injection, shortcode support, and per-post controls.
- **System Health Monitor**: Real-time diagnostic panel for PHP, Permalinks, and required server extensions in the Advanced tab.
- **Frontend Asset Layer**: New lightweight CSS/JS system for professional component styling.
- **Developer Guide**: Comprehensive `docs/DEV_GUIDE.md` for architecture and security standards.
- **Admin Quick Edit**: SEO Title, Description, and Score columns added with inline editing support.
- **RSS Footer Protection**: New setting to prevent content theft via RSS feeds.

### Improved
- **Security Posture**: Completed a full 4-Layer Defense audit (Nonce, Capability, Sanitization, Escaping) across all core modules.
- **IDE Support**: Hardened `_wp_stubs.php` with `WP_Post`/`WP_Query` mocks and implemented an "Unreachable Stub Injection" pattern in admin partials to eliminate false-positive undefined variable/function errors.
- **UI Consistency**: Premium dashboard polish and smooth transitions for TOC.

## [2.2.7] - 2026-05-14

## [2.2.6] - 2026-04-09
### Added
- **Attachment URL Redirects**: Attachment pages can now redirect cleanly to their published parent post, with a safe fallback to the media file URL when no parent is available.
### Fixed
- **Advanced Settings**: The existing `Redirect Attachment URLs` option now performs the expected frontend 301 redirect behavior.
- **IDE/LSP Support**: Expanded the shared WordPress stubs to cover the attachment-related core functions used by the redirect module.
### Maintenance
- **Release Sync**: Aligned plugin, package, documentation, dist, and release artifact metadata for the 2.2.6 release.
## [2.2.5] - 2026-04-09
### Fixed
- **IDE/LSP Support**: Expanded the shared WordPress stubs to eliminate false-positive undefined function diagnostics in the breadcrumbs module and related files.
- **Breadcrumbs Compatibility**: Added support for both `[vonseo_breadcrumbs]` and `[vonseowp_breadcrumbs]` shortcodes.
- **Sitemap Controls**: The generated sitemap now respects the saved enable/posts/pages settings before rendering output.
- **IndexNow Stability**: Hardened legacy admin hook callbacks and key-file path handling for the IndexNow module.
### Maintenance
- **Release Metadata**: Synchronized plugin, package, readme, dist, and release artifact versioning for the 2.2.5 build.
## [2.2.4] - 2026-04-03
### Added
- **IDE Stubs**: Integrated comprehensive WordPress stubs within the main plugin file to resolve IDE "False Positive" errors globally.
### Fixed
- **404 Log Robustness**: Added type-checking to prevent runtime errors when the 404 log is empty.
- **I18n Compliance**: Fixed missing translator comments for dynamic placeholders in meta boxes.
- **Security Audit**: Completed a system-wide audit of escaping and sanitization for all admin settings and frontend meta outputs.
### Maintenance
- **Architectural Hardening**: Reorganized module loading to ensure PHP version and XML/DOM extension requirements are met before class instantiation.
- **Standalone Test Environment**: Restored and enhanced `test_activation.php` for syntax and activation verification.

## [2.2.3] - 2026-03-29
### Added
- **Breadcrumbs Generator**: Added a built-in [vonseo_breadcrumbs] shortcode and vonseo_breadcrumbs() theme helper for rendering on-page breadcrumbs.
- **Admin Settings**: Added a configurable breadcrumb separator in the Advanced tab.
### Fixed
- **Frontend Settings Sync**: Homepage title, homepage description, default social image, and Open Graph toggles now use the saved admin settings.
- **Webmaster Tools**: Google and Bing verification codes now output the correct verification meta tags on the frontend.
### Maintenance & Polish
- **I18n**: Wrapped hardcoded English strings in the Dashboard (Tutorial/FAQ) with `_e()` for 100% translation readiness.
- **Documentation**: Harmonized project docs and developer workflows to use the correct `vonseo.php` filename.
- **Dev Experience**: Added `_wp_stubs.php` for better IDE/LSP and AI support (excluded from production builds).

## [2.2.1] - 2026-03-14
### Added
- **I18n**: Full internationalization support across the dashboard and meta box.
- **JS Localization**: Localized client-side strings and AI recommendations.
- **Security**: Hardened JSON-LD output and AJAX handlers.
- **English standardization**: Translated internal roadmap and release logs.

## [2.2.0] - 2026-03-03
### Added
- **AI & LLM**: Native support for `llms.txt` (AEO) to help AI models parse site content.
- **AI & LLM**: New dedicated admin tab for managing AI crawler settings.
- **UI/UX**: Revamped SEO Title and Meta Description length indicators with smarter, flexible validation ranges and premium gradient progress bars.

## [2.1.9] - 2026-03-03
### Added
- **Security & Performance**: Added native WP Header Cleanup module to remove unnecessary meta tags like `wp_generator`, `rsd_link`, and `wlwmanifest`.

## [2.1.8] - 2026-02-19
### Added
- **Social Previews**: Real-time Facebook & Twitter card previews in the Meta Box.
- **Social Meta Tags**: Dedicated fields for Social Title, Description, and Image with smart fallbacks.
- **Schema Validator**: Added direct link to `validator.schema.org` for instant structured data testing.
- **UI**: Glassmorphism styling for social preview tabs and character counters.

## [2.1.7] - 2026-02-13
### Security
- **Hardening**: Implemented strict, field-specific sanitization for `register_setting` to meet WordPress.org Plugin Review guidelines.
- **Compliance**: Applied `wp_unslash()` to all input fields before sanitization.
- **Refactor**: Replaced generic sanitization loop with explicit field handling in `class-vonseowp-admin.php`.

## [2.1.5] - 2026-01-31
### Added
- **FAQ Schema**: New repeater in Post Meta Box for generating FAQ JSON-LD Rich Snippets.
- **Video Schema**: New VideoObject schema support for better video indexing.
- **Robots.txt Editor**: Advanced admin tab to control crawler access with "Pro Rules" reset functionality.
### Security
- **Hardening**: Completed 100% PHPCS & WordPress Security compliance audit.
- **Compliance**: Improved data sanitization (unslashing/recursive loops) and variable prefixing.
### Fixed
- **UI**: Corrected Robots.txt layout alignment and enhanced code editor styling.

## [2.1.4] - 2026-01-31
### Improved
- **Offline AI**: Implemented Smart Content Parser to generate distinct Title and Descriptions based on HTML structure (H1/H2 vs Paragraphs).
- **Offline AI**: Added metadata filtering to exclude author credits, photo sources, and separator lines from descriptions.
- **Offline AI**: Added automatic Focus Keyword injection into generated Titles and Descriptions if missing.
- **Offline AI**: Enhanced Dashboard suggestions with randomized templates and Site Tagline integration.
- **Offline AI**: Expanded keyword extraction stopword list for better relevance.

## [2.1.3] - 2026-01-31
### Added
- **IndexNow**: Native support for IndexNow (Bing/Yandex) instant indexing without configuration.
- **Fast Crawl**: Auto-ping search engines on post publish/update.

## [2.1.2] - 2026-01-30
### Security
- **Hardening**: Enhanced escaping and sanitization across Frontend, Sitemap, and Competitors modules.
- **Compliance**: Disabled OTA updater for WordPress.org repository approval.
- **Fix**: Added missing `languages` directory.

## [2.1.1] - 2026-01-30
### Fixed
- **OTA System**: Fixed updater instantiation in the main plugin file.
- **OTA System**: Improved version comparison and cleaning for GitHub tags.
### Added
- OTA Update test release.

## [2.1.0] - 2026-01-30
### Added
- **Competitor Analysis Module**: Real-time "SEO Math" comparison against any URL.
- **AI Magic**: Ultra-compact AI suggestions for Titles, Descriptions, and Keywords.
- **Bi-directional Sync**: Site Title & Tagline synchronized with WP General Settings.
- **Support UI Facelift**: Premium Glassmorphism design with Amber/Gold button.
- **Help & Tutorial Tab**: Integrated quick-start guides and setup checklist.
- **Build System**: Automated versioning and ZIP packaging via Python.

### Fixed
- **Security**: Hardened against XSS (Deep deep audit).
- **Security**: Patched SSRF vulnerability in competitor scanner.
- **Security**: Added proper nonce and capability checks to all AJAX actions.
- **UI**: Fixed `line-clamp` CSS compatibility and button centering.

## [2.0.0] - 2026-01-20
- **NEW**: Full Premium Suite release.
- **NEW**: XML Sitemap Generator (`/sitemap.xml`).
- **NEW**: Redirection Manager with 404 Logging.
- **NEW**: Local SEO & Schema markup support.
- **NEW**: Image SEO (Auto ALT/Title tags).
- **NEW**: Content Analysis in Post Editor.

## [1.13.0]
- **FIX**: Adjusted updater download link to correct package failure.

## [1.12.0]
- **NEW**: Added Auto-Updater directly from GitHub releases.
- **FIX**: Minor stability improvements.

## [1.1.0]
- **NEW**: Complete UI Overhaul - introduced premium dashboard design.
- **FIX**: Resolved PHP Warning "Undefined array key 'site_title'".
- **IMPROVED**: Better spacing and typography in admin panels.

## [1.0.0]
- Initial release.
- Ported core logic from VonCMS v1.9.6.
