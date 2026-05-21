=== VonSEO ===
Contributors: vondereich, kurama87
Tags: seo, toc, schema, sitemap, indexnow
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 2.3.2
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Surgical SEO. Zero Bloat. Born from the high-performance VonCMS ecosystem.

== Description ==

VonSEO isn't just another SEO plugin; it’s a **high-performance publishing engine**. Originally forged within the enterprise-grade **VonCMS** ecosystem, it has been meticulously adapted for WordPress publishers who refuse to compromise on speed, security, and database hygiene.

Stop turning your WordPress dashboard into a heavy SaaS marketing platform. It's time for **Performance-First SEO**.

### Why Choose VonSEO?

Most SEO plugins become increasingly heavy over time, trading performance for oversized dashboards, telemetry, and marketing layers. VonSEO rejects the bloat.

*   **Zero-Waste Architecture**: No custom database tables. We use native WordPress `post_meta` and `wp_options` for maximum speed and compatibility.
*   **Enterprise Heritage**: Built with the same performance DNA as VonCMS.
*   **Privacy as a Feature**: No tracking. No telemetry. No "phoning home." Your data stays on your server.
*   **No Paywalls**: What you see is what you get. No hidden “Pro” tabs or forced upgrades.

### The Professional Toolkit

#### 1. Modern SEO Workspace
A clean, focused editorial workflow designed for speed and usability.
*   **Compact Sidebar Interface**: Optimize content without leaving the editor.
*   **Real-Time Google Preview**: See exactly how your site looks in the wild.
*   **Smart Metadata Assistance**: Faster editorial workflows without the server load.
*   **Competitor SEO Math**: Live metric comparison against any URL.

#### 2. Advanced Technical Engine
*   **Dynamic Sitemap Indexing**: Automated scaling with `sitemap_index.xml` and 1,000-post pagination.
*   **Instant Indexing (IndexNow)**: Instantly notify Bing and Yandex when content is updated.
*   **Surgical JSON-LD Schema**: Pure, optimized structured data (Article, FAQ, Video, Review, Breadcrumbs).
*   **SEO Table of Contents (TOC)**: Lightweight, anchor-based TOC with zero external dependencies.

#### 3. Safety & System Health
*   **System Health Monitor**: Real-time technical diagnostics for your PHP environment and permalinks.
*   **Redirect & Robots Manager**: Lightweight control over site navigation and crawling instructions.
*   **Production-Ready Security**: Strict Nonce verification, Capability checks, and Sanitization at every layer.

== Installation ==

1. Upload the `vonseo` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Access the VonSEO dashboard and save your settings.

== Frequently Asked Questions ==

= Does this plugin slow down my site? =
No. VonSEO is engineered with a lightweight-first architecture using native WordPress storage and minimal frontend overhead.

= Is this compatible with PHP 8.2? =
Yes. VonSEO requires PHP 7.4+ and is fully optimized for PHP 8.2/8.3.

== Changelog ==

= 2.3.2 =
*   Fixed: Backported PHP 8 mixed and union type hints to ensure PHP 7.4 compatibility.
*   Fixed: Corrected rewrite rules flush timing to prevent 404 errors on activation/update.
*   Fixed: Robots meta tag now respects site visibility preferences, search results, and 404 pages.
*   Fixed: Added rating_count storage and input field support for dynamic schema ratings.
*   Improved: Relocated security guards to the absolute top of template partials.

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

= 2.0.0 =
*   NEW: Full Professional Suite release with Sitemaps and Redirection.
