if (PHP_SAPI !== 'cli') {
    die('This script can only be run from the command line.');
}

define('ABSPATH', __DIR__ . '/');
define('WPINC', 'wp-includes');

function plugin_dir_path(string $file): string { return __DIR__ . '/'; }
function plugin_dir_url(string $file): string { return 'http://example.com/wp-content/plugins/vonseo/'; }
function add_action(string $hook, mixed $callback, int $priority = 10, int $accepted_args = 1): void {}
function add_filter(string $hook, mixed $callback, int $priority = 10, int $accepted_args = 1): void {}
function register_activation_hook(string $file, mixed $callback): void {}
function get_option(string $option, mixed $default = false) { return $default; }
function add_option(string $option, mixed $value = '', string $deprecated = '', string $autoload = 'yes'): bool { return true; }
function update_option(string $option, mixed $value, $autoload = null): bool { return true; }
function delete_option(string $option): bool { return true; }
function load_plugin_textdomain(string $domain, $deprecated = false, $plugin_rel_path = false): void {}
function plugin_basename(string $file): string { return 'vonseo/vonseo.php'; }
function flush_rewrite_rules(bool $hard = true): void {}
function esc_html(string $text): string { return $text; }
function esc_attr(string $text): string { return $text; }
function esc_url(string $text): string { return $text; }
function sanitize_text_field(string $str): string { return $str; }
function __(string $text, string $domain): string { return $text; }
function _e(string $text, string $domain): void { echo $text; }
function esc_html__(string $text, string $domain): string { return $text; }
function esc_html_e(string $text, string $domain): void { echo $text; }
function esc_textarea(string $text): string { return $text; }
function esc_url_raw(string $url): string { return $url; }
function wp_unslash(mixed $data) { return $data; }
function sanitize_key(string $key): string { return $key; }
function current_time(string $type): string { return date('Y-m-d H:i:s'); }
function is_admin(): bool { return true; }
function is_front_page(): bool { return false; }
function is_home(): bool { return false; }
function is_singular(): bool { return false; }


// Include the plugin file
require_once 'vonseo.php';

echo "Success: No syntax or fatal errors detected in global scope.\n";

// Try to initialize
try {
    // Note: VonSEOWP::instance() is already called at the end of vonseo.php
    echo "Success: Singleton instantiated.\n";
} catch (Throwable $e) {
    echo "Error during instantiation: " . $e->getMessage() . "\n";
}
