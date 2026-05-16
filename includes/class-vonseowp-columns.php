<?php
/**
 * Post List Columns and Quick Edit handling
 */
if (!defined('ABSPATH')) exit;

if (false) {
    require_once dirname(__DIR__) . '/_wp_stubs.php';
}

class VonSEOWP_Columns {

    public function __construct() {
        $screens = array('post', 'page');
        foreach ($screens as $screen) {
            add_filter("manage_{$screen}_posts_columns", array($this, 'add_seo_columns'));
            add_action("manage_{$screen}_posts_custom_column", array($this, 'render_seo_columns'), 10, 2);
        }

        add_action('quick_edit_custom_box', array($this, 'render_quick_edit_fields'), 10, 2);
        add_action('save_post', array($this, 'save_quick_edit_data'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function enqueue_assets(string $hook): void {
        if ('edit.php' !== $hook) return;
        wp_enqueue_script('vonseowp-quick-edit', VONSEOWP_URL . 'admin/js/vonseowp-quick-edit.js', array('jquery', 'inline-edit-post'), VONSEOWP_VERSION, true);
        wp_enqueue_style('vonseowp-admin-css', VONSEOWP_URL . 'admin/css/vonseowp-admin.css', array(), VONSEOWP_VERSION);
    }

    public function add_seo_columns(array $columns): array {
        $new_columns = array();
        foreach ($columns as $key => $value) {
            if ($key === 'date') {
                $new_columns['vonseo_title'] = __('SEO Title', 'vonseo');
                $new_columns['vonseo_desc']  = __('SEO Desc', 'vonseo');
                $new_columns['vonseo_score'] = __('Score', 'vonseo');
            }
            $new_columns[$key] = $value;
        }
        return $new_columns;
    }

    public function render_seo_columns(string $column, int $post_id): void {
        switch ($column) {
            case 'vonseo_title':
                $title = get_post_meta($post_id, '_vonseowp_title', true);
                echo esc_html($title ? $title : '—');
                echo '<div class="vonseo-quick-edit-data" style="display:none;" 
                    data-title="' . esc_attr($title) . '" 
                    data-desc="' . esc_attr(get_post_meta($post_id, '_vonseowp_description', true)) . '"
                    data-keywords="' . esc_attr(get_post_meta($post_id, '_vonseowp_keywords', true)) . '"></div>';
                break;
            case 'vonseo_desc':
                $desc = get_post_meta($post_id, '_vonseowp_description', true);
                echo esc_html($desc ? wp_trim_words($desc, 10) : '—');
                break;
            case 'vonseo_score':
                // Simple score display for now (placeholder if not calculated)
                $score = $this->calculate_basic_score($post_id);
                $class = $score >= 80 ? 'good' : ($score >= 50 ? 'warn' : 'bad');
                echo '<span class="vonseo-score-badge ' . esc_attr($class) . '">' . intval($score) . '</span>';
                break;
        }
    }

    private function calculate_basic_score(int $post_id): int {
        $title = get_post_meta($post_id, '_vonseowp_title', true);
        $desc  = get_post_meta($post_id, '_vonseowp_description', true);
        $kw    = get_post_meta($post_id, '_vonseowp_keywords', true);
        
        $score = 0;
        if (!empty($title)) $score += 30;
        if (!empty($desc)) $score += 30;
        if (!empty($kw)) $score += 40;

        // More complex logic can be added here
        return $score;
    }

    public function render_quick_edit_fields(string $column_name, string $post_type): void {
        if ('vonseo_title' !== $column_name) return;
        
        wp_nonce_field('vonseowp_quick_edit_nonce', 'vonseowp_quick_edit_nonce');
        ?>
        <fieldset class="inline-edit-col-right inline-edit-vonseo">
            <div class="inline-edit-col">
                <h4 class="title"><?php esc_html_e('VonSEO Optimization', 'vonseo'); ?></h4>
                
                <label>
                    <span class="title"><?php esc_html_e('SEO Title', 'vonseo'); ?></span>
                    <span class="input-text-wrap"><input type="text" name="vonseowp_title" class="vonseo-qe-title" value=""></span>
                </label>

                <label>
                    <span class="title"><?php esc_html_e('SEO Desc', 'vonseo'); ?></span>
                    <span class="input-text-wrap"><textarea name="vonseowp_description" class="vonseo-qe-desc" rows="2"></textarea></span>
                </label>

                <label>
                    <span class="title"><?php esc_html_e('Keywords', 'vonseo'); ?></span>
                    <span class="input-text-wrap"><input type="text" name="vonseowp_keywords" class="vonseo-qe-keywords" value=""></span>
                </label>
            </div>
        </fieldset>
        <?php
    }

    public function save_quick_edit_data(int $post_id): void {
        if (!isset($_POST['vonseowp_quick_edit_nonce'])) return;
        if (!wp_verify_nonce(sanitize_key(wp_unslash($_POST['vonseowp_quick_edit_nonce'])), 'vonseowp_quick_edit_nonce')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['vonseowp_title'])) {
            update_post_meta($post_id, '_vonseowp_title', sanitize_text_field(wp_unslash($_POST['vonseowp_title'])));
        }
        if (isset($_POST['vonseowp_description'])) {
            update_post_meta($post_id, '_vonseowp_description', sanitize_textarea_field(wp_unslash($_POST['vonseowp_description'])));
        }
        if (isset($_POST['vonseowp_keywords'])) {
            update_post_meta($post_id, '_vonseowp_keywords', sanitize_text_field(wp_unslash($_POST['vonseowp_keywords'])));
        }
    }
}
