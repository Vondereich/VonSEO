# VonSEO v2.3.0 Developer Guide

Welcome to the internal architecture guide for VonSEO. This document is intended for developers who wish to extend or maintain the plugin.

## 1. Architecture Overview

VonSEO follows a modular, object-oriented architecture. Each feature is isolated into its own class located in the `includes/` directory.

- **`VonSEOWP`**: The main orchestrator class. It handles initialization and registration of all modules.
- **`VonSEOWP_Admin`**: Manages the tabbed dashboard, settings registration, and sanitization.
- **`VonSEOWP_Frontend`**: Controls all `<head>` output, including meta tags, canonicals, and JSON-LD Schema.
- **`VonSEOWP_TOC`**: (New in v2.3.0) Handles automatic Table of Contents generation and anchor injection.

## 2. Key Modules & Hooks

### Table of Contents (TOC)
- **Class**: `VonSEOWP_TOC`
- **Filter**: `the_content` (Priority 100)
- **Shortcode**: `[vonseo_toc]`
- **CSS**: Located in `public/css/vonseowp-public.css`.

### Schema Generator
- **Class**: `VonSEOWP_Frontend::output_json_ld()`
- **Supported Types**: Article, WebPage, FAQ, Video, Review/Product.
- **Data Source**: Fetched from post meta using `get_post_meta`.

### IndexNow Integration
- **Class**: `VonSEOWP_IndexNow`
- **Hook**: `wp_after_insert_post`
- **Key Location**: Key is auto-generated and stored in `vonseowp_indexnow_key`.

## 3. Security Patterns

All modules must follow these security standards:
1. **CSRF Protection**: Always use nonces for any POST or AJAX action.
2. **Sanitization**: All input from `$_POST` must be unslashed (`wp_unslash`) and sanitized (`sanitize_text_field`, `esc_url_raw`, etc.).
3. **Escaping**: All output must be escaped (`esc_html`, `esc_attr`, `esc_url`).
4. **Capabilities**: Use `current_user_can('manage_options')` for settings and `current_user_can('edit_post', $post_id)` for post-specific updates.

## 4. Extending VonSEO

To add a new module:
1. Create `includes/class-vonseowp-newfeature.php`.
2. Define your class and logic.
3. Require the file and instantiate the class in `vonseo.php` inside the `VonSEOWP::init()` method.

## 5. Development Utilities

- **`_wp_stubs.php`**: Use this file to define WordPress function signatures for IDE indexing to prevent "Undefined function" false positives.
- **Block Editor Support**: Meta updates are compatible with both Classic and Block editors.

---
*Created with the "Boil the Ocean" mindset for VonSEO v2.3.0.*
