# WordPress Plugin Development SOP

## 1. Code Quality & Security Standards

### Input Sanitization (Data Coming In)
**Rule**: Never trust user input. Sanitize early.
*   **Simple Text**: `sanitize_text_field(wp_unslash($_POST['foo']))`
*   **Rich Text**: `wp_kses_post(wp_unslash($_POST['foo']))`
*   **URLs**: `esc_url_raw(wp_unslash($_POST['url']))`
*   **Arrays**: Map over array with sanitization callback.
*   **Crucial**: Always use `wp_unslash()` before sanitizing if the data comes from `$_POST` or `$_GET` to remove magic quotes.

### Output Escaping (Data Going Out)
**Rule**: Escape late (as close to `echo` as possible).
*   **HTML Attributes**: `<div class="<?php echo esc_attr($classname); ?>">`
*   **HTML Body**: `<div><?php echo esc_html($content); ?></div>`
*   **URLs**: `<a href="<?php echo esc_url($url); ?>">`
*   **JavaScript**: `<script>var data = <?php echo wp_json_encode($array); ?>;</script>`
*   **Translations**: `<?php esc_html_e('Hello', 'domain'); ?>`

### Database Security
*   **SQL Injection**: ALWAYS use `$wpdb->prepare()`.
    *   Right: `$wpdb->get_results($wpdb->prepare("SELECT * FROM table WHERE id = %d", $id))`
    *   Wrong: `$wpdb->get_results("SELECT * FROM table WHERE id = $id")`

### Access Control
*   **File Access**: Add `if (!defined('ABSPATH')) exit;` at the top of EVERY PHP file.
*   **Capabilities**: Check `current_user_can('manage_options')` before saving settings.
*   **Nonces**: Always verify nonces on form submission/AJAX.
    *   Form: `wp_nonce_field('action', 'nonce_name')`
    *   Check: `check_admin_referer('action', 'nonce_name')` or `wp_verify_nonce()`

## 2. WordPress.org Repository Compliance

### Prohibited Code
*   **No Auto-Updaters**: Custom update checkers (like GitHub updaters) are **banned** in the repo version.
    *   *SOP*: Wrap updater code in comments or a conditional flag that is false for repo builds.
*   **Restricted Terms**: Plugin names/slugs cannot contain "wp" (e.g., "VonSEOWP" -> "VonSEO").
*   **Direct Calls**: No `dl()`, `system()`, `exec()`, `passthru()`.

### Header Requirements
*   **Mains Plugin File**:
    *   `Stable tag`: Must match the release version.
    *   `License`: GPLv2 or later (GPLv3 recommended).
*   **Readme.txt**:
    *   Must have "Tested up to".
    *   Tags limited to 5.

## 3. Release Checklist (Versioning)

When releasing a new version (e.g., `1.0.0` -> `1.0.1`), update these **4 locations**:

1.  **Main Plugin File** (`plugin-name.php`):
    *   Header: `Version: 1.0.1`
    *   Constant: `define('PLUGIN_VERSION', '1.0.1');`
2.  **Readme.txt**:
    *   Header: `Stable tag: 1.0.1`
    *   Changelog: Add `= 1.0.1 =` section.
3.  **Package.json**:
    *   `"version": "1.0.1"`
4.  **Changelog.md** (Project Changelog):
    *   Add `## [1.0.1] - YYYY-MM-DD`.

## 4. Build Process

1.  **Clean**: Remove old `dist/` or `.zip` files.
2.  **Build**: Run `npm run release` (or your build script).
3.  **Verify**:
    *   Unzip the result.
    *   Check that no dev files (`node_modules`, `.git`, `.github`) are included.
    *   Check that `languages` folder exists (even if empty).
4.  **Test**: Install the ZIP on a fresh WordPress (LocalWP/XAMPP) to ensure it activates without errors.
