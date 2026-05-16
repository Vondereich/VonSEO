<?php
/**
 * IndexNow Integration for Bing & Yandex
 */
if (!defined('ABSPATH')) exit;

class VonSEOWP_IndexNow {

    private string $api_key = '';
    private string $key_location = '';
    private $endpoints = array(
        'bing' => 'https://www.bing.com/indexnow',
        'yandex' => 'https://yandex.com/indexnow'
    );

    public function __construct() {
        $this->api_key = get_option('vonseowp_indexnow_key');
        $this->key_location = get_option('vonseowp_indexnow_file');

        // Generate Key if missing
        if (empty($this->api_key)) {
            $this->generate_key();
        }

        // Hooks
        add_action('save_post', array($this, 'auto_submit_url'), 10, 3);
        add_action('init', array($this, 'serve_key_file'));
        
        // Admin Options
        add_filter('vonseowp_settings_tabs', array($this, 'add_settings_tab'));
        add_action('vonseowp_settings_content', array($this, 'render_settings_content'));
    }

    /**
     * Keep legacy settings hooks valid without altering the current admin layout.
     */
    public function add_settings_tab(array $tabs): array {
        return is_array($tabs) ? $tabs : array();
    }

    /**
     * Current settings UI is rendered directly in the admin partial.
     */
    public function render_settings_content(): void {}

    /**
     * Generate a unique API Key and filename
     */
    private function generate_key(): void {
        $key = wp_generate_password(32, false);
        $filename = $key . '.txt';
        
        update_option('vonseowp_indexnow_key', $key);
        update_option('vonseowp_indexnow_file', $filename);
        
        $this->api_key = $key;
        $this->key_location = $filename;
    }

    /**
     * Serve the key file verification request
     * e.g. example.com/83hf83hf...txt
     */
    public function serve_key_file(): void {
        $request_path = wp_parse_url(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'] ?? '')), PHP_URL_PATH);
        $expected_path = wp_parse_url(home_url('/' . ltrim((string) $this->key_location, '/')), PHP_URL_PATH);
        
        if ($request_path && $request_path === $expected_path) {
            header('Content-Type: text/plain');
            echo esc_html($this->api_key);
            exit;
        }
    }

    /**
     * Auto-submit URL on Publish/Update
     */
    public function auto_submit_url(int $post_id, object $post, bool $update): void {
        $options = get_option('vonseowp_settings', array());
        $enabled = isset($options['enable_indexnow']) ? (bool) $options['enable_indexnow'] : true;
        if (!$enabled) return;

        // Check if pubished
        if ($post->post_status !== 'publish') return;

        // Skip revisions and autosaves
        if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;

        $url = get_permalink($post_id);
        $this->submit_url($url);
    }

    /**
     * Send Ping to IndexNow API
     */
    public function submit_url(string $url): void {
        if (empty($url)) {
            return;
        }
        $host = wp_parse_url(home_url(), PHP_URL_HOST);
        $key = $this->api_key;
        $key_location = home_url('/' . ltrim((string) $this->key_location, '/'));

        $body = array(
            'host' => $host,
            'key' => $key,
            'keyLocation' => $key_location,
            'urlList' => array($url)
        );

        $args = array(
            'body' => json_encode($body),
            'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
            'timeout' => 5,
            'blocking' => false // Async request
        );

        foreach ($this->endpoints as $engine => $endpoint) {
            wp_remote_post($endpoint, $args);
        }
    }
}
