<?php
/**
 * RSS Feed Protection and Enhancements
 */
if (!defined('ABSPATH')) exit;

class VonSEOWP_RSS {

    public function __construct() {
        add_filter('the_content_feed', array($this, 'add_rss_footer'));
        add_filter('the_excerpt_rss', array($this, 'add_rss_footer'));
    }

    /**
     * Add backlink to the end of RSS feed items
     */
    public function add_rss_footer(string $content): string {
        if (!VonSEOWP::get_option('enable_rss_footer')) {
            return $content;
        }

        if (is_feed()) {
            $post_link = get_permalink();
            $blog_name = get_bloginfo('name');
            $blog_link = home_url();

            $footer = '<hr><p>';
            $footer .= sprintf(
                /* translators: 1: Post link, 2: Blog link, 3: Blog name */
                __('The post <a href="%1$s">%1$s</a> appeared first on <a href="%2$s">%3$s</a>.', 'vonseo'),
                esc_url($post_link),
                esc_url($blog_link),
                esc_html($blog_name)
            );
            $footer .= '</p>';

            $content .= $footer;
        }

        return $content;
    }
}
