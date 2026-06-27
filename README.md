# VonSEOWP: The High-Performance SEO Engine

> **Surgical SEO. Zero Bloat. Born from VonCMS.**

VonSEOWP isn't just another SEO plugin; it’s a high-performance publishing engine. Originally forged within the enterprise-grade **VonCMS** ecosystem, it has been meticulously adapted for WordPress publishers who refuse to compromise on speed, security, and database hygiene.

Stop turning your WordPress dashboard into a heavy SaaS marketing platform. It's time for **Performance-First SEO**.

---

## ⚡ Why VonSEOWP?

Most SEO plugins become increasingly heavy over time, trading performance for oversized dashboards, telemetry, and marketing layers. VonSEOWP rejects the bloat.

- **Zero-Waste Architecture**: No custom database tables. We use native `post_meta` and `wp_options` for maximum speed and compatibility.
- **Enterprise Heritage**: Built with the same performance DNA as VonCMS.
- **Privacy as a Feature**: No tracking. No telemetry. No "phoning home." Your data stays on your server.
- **Modern Standards Only**: We don't support legacy junk. Minimum **WordPress 6.0** and **PHP 7.4+** required.

---

## 🛠️ The Professional Toolkit

### 1. The Modern SEO Workspace
A clean, focused editorial workflow that stays out of your way until you need it.
- **Compact Sidebar Interface**: Optimize content without leaving the editor.
- **Real-Time Google Preview**: See exactly how your site looks in the wild.
- **Smart Metadata Assistance**: Faster editorial workflows without the server load.
- **Competitor SEO Math**: Live metric comparison against any URL (with 12-hour transient caching).

### 2. Advanced Technical Engine
- **Dynamic Sitemap Indexing**: Automated scaling with `sitemap_index.xml` and 1,000-post pagination.
- **IndexNow Integration**: Instant "Doorbell" notification for Bing and Yandex.
- **Surgical JSON-LD Schema**: Pure, optimized structured data (Article, FAQ, Video, Review, Breadcrumbs).
- **SEO Table of Contents (TOC)**: Lightweight, anchor-based TOC with zero external dependencies.

### 3. Safety & Health
- **System Health Monitor**: Real-time technical diagnostics for your environment.
- **Redirect & Robots Manager**: Lightweight control over your site's navigation and crawling instructions.
- **4-Layer Defense**: Strict Nonce verification, Capability checks, Sanitization, and Escaping at every layer.

---

## 🏁 Performance Philosophy

VonSEOWP is engineered with a lightweight-first architecture using native WordPress storage and minimal frontend overhead.

- **Lightweight by Default**: Minimal frontend requests.
- **Native Storage**: Maximum compatibility with migrations and backups.
- **Developer-First**: Clean code, hardened IDE stubs, and predictable hooks.

---

## 🚀 Installation & Requirements

1. **Upload** the `vonseo` folder to `/wp-content/plugins/`.
2. **Activate** and save your settings.
3. **Enjoy** a faster, cleaner WordPress.

**Requirements:**
- **WordPress**: 6.0+ (Required)
- **PHP**: 7.4+ (Recommended: 8.2+)

---

## FAQ

**Where is the analyzer?**
Open any Post or Page editor and use the VonSEO Content Intelligence sidebar/metabox. It is not a public frontend script.

**Does the analyzer send draft content outside WordPress?**
No. The v2.3.4 analyzer runs locally in the editor screen and does not require an external API.

**Does VonSEO create custom database tables?**
No. It uses native WordPress options and post meta.

**Is there a hidden Pro layer?**
No. The plugin is built as a lightweight toolkit without forced upgrades or paywalled admin tabs.

**Does it support large sites?**
Yes. The sitemap system supports sitemap indexing and paginated sitemap output.

---

## 🗺️ Roadmap
- [x] Lean local content analyzer (v2.3.4)
- [x] Lean frontend meta output and social image fallback (v2.3.5)
- [x] Score consistency across editor and All Posts (v2.3.6)
- [ ] Manual Local Site Audit Lite (v2.4)
- [ ] Publisher schema variants after the lean audit path is proven

---

## ⚖️ License
Licensed under **GPLv3 or later**. Built by publishers, for publishers.
