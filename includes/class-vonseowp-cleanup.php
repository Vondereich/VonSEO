<?php
/**
 * Header Cleanup Module
 *
 * Removes unnecessary meta tags, links, and bloat from wp_head().
 *
 * @package    VonSEOWP
 * @subpackage VonSEOWP/includes
 */

if (!defined('ABSPATH')) exit;

class VonSEOWP_Cleanup {

    public function __construct() {
        add_action('init', array($this, 'clean_header_tags'));
    }

    /**
     * Remove unnecessary tags from the <head>
     */
    public function clean_header_tags() {
        // Remove WordPress version generator meta tag
        remove_action('wp_head', 'wp_generator');

        // Remove Really Simple Discovery (RSD) link
        remove_action('wp_head', 'rsd_link');

        // Remove Windows Live Writer link
        remove_action('wp_head', 'wlwmanifest_link');

        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);

        // Remove WP REST API link in header
        remove_action('wp_head', 'rest_output_link_wp_head', 10);

        // Remove oEmbed discovery links
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    }
}
