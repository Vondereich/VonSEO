# VonSEO Lean Roadmap

VonSEO should stay a lightweight WordPress SEO toolkit: local-first, privacy-safe, and useful inside normal publishing workflows. New features must earn their footprint.

## Product Guardrails
- No telemetry, tracking, SaaS lock-in, or required external API.
- No custom database tables unless a feature cannot work safely with `post_meta`, `wp_options`, or transients.
- No heavy background scanners by default; expensive checks must be manual, cached, or limited.
- No AI wording unless the feature is actually AI-powered. Prefer "assistant", "suggestions", or "analysis" for local logic.
- Every admin action must follow WordPress patterns: capability checks, nonces, sanitization, escaping, and prefixed code.

## Completed Baseline

### v2.1.x - Essential Tools
- [x] FAQ Schema (JSON-LD) repeater.
- [x] Advanced robots.txt editor with Pro Rules reset.
- [x] Social media previews for Facebook and Twitter cards.
- [x] Structured data testing links.
- [x] VideoObject schema support.
- [x] Header cleanup for noisy WordPress meta tags.

### v2.2.x - Utility, Redirects, and Hygiene
- [x] Admin Quick Edit SEO columns and inline editing.
- [x] RSS footer protection.
- [x] Attachment URL redirects.
- [x] Breadcrumbs shortcode and theme helper.
- [x] Frontend settings sync for homepage metadata, social defaults, and verification tags.
- [x] Internationalization and JS localization cleanup.
- [x] PHP 7.4 compatibility and security hardening.

### v2.3.0 - v2.3.3 - Intelligence and Release Polish
- [x] Table of Contents generator.
- [x] System Health Monitor.
- [x] Frontend asset layer for public components.
- [x] Duplicate meta output guards.
- [x] Sitemap index and 1,000-post pagination.
- [x] Competitor analysis cache.
- [x] Canonical, description fallback, admin tab persistence, and header polish.

## v2.3.4 - Lean Content Analyzer (Completed)

Goal: improve the existing editor SEO Health panel without adding server load or external dependencies.

- [x] Split analyzer logic into small local JS functions for readability and testability.
- [x] Add keyword density check with a sane warning range, not a rigid ranking promise.
- [x] Add heading structure checks: missing H1/H2, repeated empty headings, and focus keyword presence.
- [x] Add image ALT scan for editor content.
- [x] Add first-paragraph keyword check.
- [x] Add internal/external link presence checks.
- [x] Make score rules explicit so the sidebar score and All Posts score can be aligned later.
- [x] Keep the analyzer lightweight and loaded only on post/page edit screens.

## v2.3.5 - Lean Frontend Meta Output (Completed)

Goal: keep public head markup clean while preserving useful social preview tags.

- [x] Remove public generator/version meta output.
- [x] Remove public wrapper comments around VonSEO meta tags.
- [x] Add WordPress site icon fallback for social image tags.
- [x] Keep site title casing under the owner's WordPress settings instead of mutating it in plugin output.

## v2.3.6 - Score Consistency and Editorial Polish (Completed)

Goal: make existing SEO scoring feel trustworthy across the admin UI.

- [x] Align the All Posts score column with the editor analyzer rules where practical.
- [x] Improve empty-state guidance without adding marketing copy.
- [x] Add clearer warnings for title and description length.
- [x] Keep score calculations local and deterministic.

## v2.4.0 - Local Site Audit Lite (Completed)

Goal: add a manual, privacy-safe audit screen for technical SEO checks that can run on shared hosting.

- [x] Manual scan only; no scheduled crawler by default.
- [x] Check sitemap configuration, robots rules, homepage metadata, site visibility, and permalink health.
- [x] Scan up to 25 recently modified published posts/pages per request with Previous/Next batch navigation for complete coverage.
- [x] Distinguish effective WordPress metadata fallbacks from genuinely missing metadata.
- [x] Report noindex usage, image ALT gaps, and internal/external link observations.
- [x] Cache compact scan results with a 12-hour transient.
- [x] Show actionable findings, not vanity scores.
- [x] Avoid HTTP crawling and external requests.

## Parking Lot

These may be useful, but should not be built until the lean analyzer and local audit are proven.

- [ ] Publisher schema variants such as NewsArticle or ScholarlyArticle.
- [ ] Internal link suggestions based on current post content and existing titles.
- [ ] Smart image ALT suggestions using local filename/title/context only.
- [ ] Import/export settings for migration between sites.

## Avoid for Now

These create bloat, support burden, or privacy concerns that do not fit the current product direction.

- [ ] Google Search Console dashboard integration.
- [ ] SaaS connectivity or VonSEO Cloud sync.
- [ ] Competitor rank tracking.
- [ ] Bulk content rewriting.
- [ ] Required external AI generation.
