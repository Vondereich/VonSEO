=== VonSEO ===
Contributors: vondereich, kurama87
Tags: seo, toc, schema, sitemap, indexnow
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 2.3.1
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

== Installation ==

1. Upload the `vonseo` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Access the VonSEO dashboard from the WordPress admin menu.

== Frequently Asked Questions ==

= Does this plugin slow down my site? =
No. VonSEO is designed to be lightweight and fast, with zero external dependencies and optimized database queries.

== Changelog ==

= 2.3.1 =
*   New: Sitemap Index system for automated scaling (sitemap_index.xml).
*   New: 12-hour caching for Competitor Analysis scans to improve performance.
*   Fixed: Sitemap pagination query variable conflict with WordPress core.
*   Fixed: Hardcoded ratingCount in Schema graph (now dynamic).
*   Fixed: 404 console errors on frontend due to missing public assets.
*   Improved: Security hardening with proper output escaping (wp_kses_post).
*   Improved: Standardized repository line endings to LF.

= 2.3.0 =
*   New: SEO Table of Contents (TOC) with automatic anchor injection.
*   New: System Health Monitor for real-time SEO diagnostics.
*   New: Admin Quick Edit columns for SEO Title, Description, and Score.
*   Improved: Hardened security posture across all core modules.

= 2.2.7 =
*   Maintenance: Internal release and stability patches.

= 2.1.0 =
*   Added: Competitor Analysis Module - Real-time "SEO Math" comparison.
*   Added: Smart Suggestions - Compact Title and Description suggestions.

= 2.0.0 =
*   NEW: Full Professional Suite release with Sitemaps and Redirection.
