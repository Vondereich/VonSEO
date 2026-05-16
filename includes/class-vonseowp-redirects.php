<?php
/**
 * Redirection Manager
 */
if (!defined('ABSPATH')) exit;

class VonSEOWP_Redirects {

    private $redirects = array();
    private $log_404 = false;
    private $redirect_attachments = true;

    public function __construct() {
        $options = get_option('vonseowp_settings', array());
        if (!is_array($options)) {
            $options = array();
        }

        // Parse Redirects (newline separated string: /old -> /new)
        if (!empty($options['redirects_list'])) {
            $lines = explode("\n", $options['redirects_list']);
            foreach ($lines as $line) {
                $parts = explode('->', $line);
                if (count($parts) === 2) {
                    $this->redirects[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        $this->log_404 = !empty($options['enable_404_log']);
        $this->redirect_attachments = !isset($options['redirect_attachments']) || (int) $options['redirect_attachments'] === 1;

        add_action('template_redirect', array($this, 'handle_redirects'), 1);
        add_action('template_redirect', array($this, 'redirect_attachment_page'), 5);
        add_action('template_redirect', array($this, 'log_404_error'), 99);
    }

    public function handle_redirects() {
        if (empty($this->redirects)) return;

        $current_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
        $path = wp_parse_url($current_uri, PHP_URL_PATH);

        if (empty($path)) {
            return;
        }

        // Simple Match
        if (isset($this->redirects[$path])) {
            wp_safe_redirect($this->redirects[$path], 301);
            exit;
        }

        // Check for trailing slash variations
        $untrail = untrailingslashit($path);
        if (isset($this->redirects[$untrail])) {
            wp_safe_redirect($this->redirects[$untrail], 301);
            exit;
        }

        $trail = trailingslashit($path);
        if (isset($this->redirects[$trail])) {
            wp_safe_redirect($this->redirects[$trail], 301);
            exit;
        }
    }

    public function redirect_attachment_page() {
        if (!$this->redirect_attachments || !is_attachment()) {
            return;
        }

        $attachment_id = get_queried_object_id();
        if (!$attachment_id) {
            return;
        }

        $attachment = get_post($attachment_id);
        if (!$attachment || !isset($attachment->post_type) || 'attachment' !== $attachment->post_type) {
            return;
        }

        $target_url = '';
        $parent_id = isset($attachment->post_parent) ? (int) $attachment->post_parent : 0;

        if ($parent_id > 0 && 'publish' === get_post_status($parent_id)) {
            $target_url = get_permalink($parent_id);
        } else {
            $target_url = wp_get_attachment_url($attachment_id);
        }

        if (empty($target_url)) {
            return;
        }

        $current_url = isset($_SERVER['REQUEST_URI']) ? home_url(esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']))) : '';
        if (!empty($current_url) && untrailingslashit($current_url) === untrailingslashit($target_url)) {
            return;
        }

        wp_safe_redirect($target_url, 301);
        exit;
    }

    public function log_404_error() {
        if (!is_404() || !$this->log_404) return;

        $log = get_option('vonseowp_404_log', array());
        if (!is_array($log)) {
            $log = array();
        }
        $current_uri = isset($_SERVER['REQUEST_URI']) ? esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : '';
        
        // Truncate URL to prevent option bloat attack
        if (strlen($current_uri) > 200) {
            $current_uri = substr($current_uri, 0, 200) . '...';
        }

        // Add new entry
        if (!isset($log[$current_uri])) {
            $log[$current_uri] = array(
                'count' => 1,
                'last_hit' => current_time('mysql')
            );
        } else {
            $log[$current_uri]['count']++;
            $log[$current_uri]['last_hit'] = current_time('mysql');
        }

        // Limit log size
        if (count($log) > 50) {
            // Sort by time ASC and remove first
            uasort($log, function($a, $b) {
                return strtotime($a['last_hit']) - strtotime($b['last_hit']);
            });
            array_shift($log);
        }

        update_option('vonseowp_404_log', $log);
    }
}