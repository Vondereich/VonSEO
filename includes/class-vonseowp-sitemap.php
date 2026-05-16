<?php
/**
 * XML Sitemap Generator
 */
if (!defined('ABSPATH')) exit;

class VonSEOWP_Sitemap {

    public function __construct() {
        add_action('init', array($this, 'add_rewrite_rules'));
        add_filter('query_vars', array($this, 'add_query_vars'));
        add_action('template_redirect', array($this, 'render_sitemap'));
        add_action('vonseowp_flush_sitemap', 'flush_rewrite_rules');
    }

    public function add_rewrite_rules(): void {
        add_rewrite_rule('sitemap\.xml$', 'index.php?vonseowp_sitemap=1', 'top');
    }

    public function add_query_vars(array $vars): array {
        $vars[] = 'vonseowp_sitemap';
        $vars[] = 'vonseowp_sitemap_page';
        return $vars;
    }

    public function render_sitemap(): void {
        if (!get_query_var('vonseowp_sitemap')) {
            return;
        }

        $options = get_option('vonseowp_settings', array());
        $enabled = isset($options['enable_sitemap']) ? (bool) $options['enable_sitemap'] : true;

        if (!$enabled) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
            include(get_query_template('404'));
            exit;
        }

        $this->output_xml($options);
        exit;
    }

    private function output_xml(array $options = array()): void {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Home
        echo '<url>';
        echo '<loc>' . esc_url(home_url('/')) . '</loc>';
        echo '<priority>1.0</priority>';
        echo '<changefreq>daily</changefreq>';
        echo '</url>';

        // Posts & Pages
        $post_types = array();
        if (!isset($options['sitemap_posts']) || (int) $options['sitemap_posts'] === 1) {
            $post_types[] = 'post';
        }
        if (!isset($options['sitemap_pages']) || (int) $options['sitemap_pages'] === 1) {
            $post_types[] = 'page';
        }

        if (empty($post_types)) {
            echo '</urlset>';
            return;
        }
        $paged = max(1, (int) get_query_var('vonseowp_sitemap_page', 1));
        $posts_per_page = 1000;
        $offset = ($paged - 1) * $posts_per_page;

        $args = array(
            'post_type' => $post_types,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'orderby' => 'modified',
            'order' => 'DESC',
            'no_found_rows' => true // Performance optimization
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                
                // Check if noindex
                $noindex = get_post_meta(get_the_ID(), '_vonseowp_noindex', true) === '1';
                if ($noindex) continue;

                echo '<url>';
                echo '<loc>' . esc_url(get_permalink()) . '</loc>';
                echo '<lastmod>' . esc_html(get_the_modified_date('c')) . '</lastmod>';
                echo '<priority>' . (is_front_page() ? '1.0' : '0.8') . '</priority>';
                echo '</url>';
            }
            wp_reset_postdata();
        }

        echo '</urlset>';
    }
}
