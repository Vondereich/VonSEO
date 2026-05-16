<?php
/**
 * Image SEO Automator
 */
if (!defined('ABSPATH')) exit;

class VonSEOWP_Image_SEO {

    public function __construct() {
        add_filter('wp_get_attachment_image_attributes', array($this, 'auto_image_attributes'), 10, 3);
        // add_filter('the_content', array($this, 'auto_content_images')); // Optional: Content filtering is heavy
    }

    public function auto_image_attributes(array $attr, object $attachment, string|array $size): array {
        $options = get_option('vonseowp_settings', array());

        // ALT Tag
        if (!empty($options['auto_image_alt']) && empty($attr['alt'])) {
            $title = get_the_title($attachment->ID);
            $attr['alt'] = $this->clean_filename($title);
        }

        // Title Tag
        if (!empty($options['auto_image_title']) && empty($attr['title'])) {
            $title = get_the_title($attachment->ID);
            $attr['title'] = $this->clean_filename($title);
        }

        return $attr;
    }

    private function clean_filename(string $filename): string {
        // Strip any tags, remove hyphens and underscores, capitalize
        $clean = preg_replace('/[-_]/', ' ', wp_strip_all_tags($filename));
        return ucwords($clean);
    }
}
