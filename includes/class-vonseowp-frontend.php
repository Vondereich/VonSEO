<?php
/**
 * Frontend Meta Output (Head Tags + JSON-LD)
 */
if (!defined('ABSPATH')) exit;




class VonSEOWP_Frontend {
    private static $has_run_meta = false;
    private static $has_run_json = false;

    public function __construct() {
        add_filter('pre_get_document_title', array($this, 'filter_document_title'), 15);
        add_action('wp_head', array($this, 'output_meta_tags'), 1);
        add_action('wp_head', array($this, 'output_json_ld'), 99);
        add_filter('robots_txt', array($this, 'handle_robots_txt'), 99, 2);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_head', array($this, 'force_remove_wp_robots'), 0);
        remove_action('wp_head', 'wp_generator');
    }

    public function force_remove_wp_robots(): void {
        remove_action('wp_head', 'wp_robots', 1);
    }

    public function enqueue_assets(): void {
        // Temporarily disabled to prevent 404 console errors until public assets are ready
        // wp_enqueue_style('vonseo-public-css', VONSEOWP_URL . 'public/css/vonseowp-public.css', array(), VONSEOWP_VERSION);
        // wp_enqueue_script('vonseo-public-js', VONSEOWP_URL . 'public/js/vonseowp-public.js', array(), VONSEOWP_VERSION, true);
    }

    public function filter_document_title(string $title): string {
        global $post;
        $options = get_option('vonseowp_settings', array());
        
        // Homepage Override
        if (is_front_page() || is_home()) {
            if (!empty($options['home_title'])) {
                return $options['home_title'];
            }
        }

        // Single Post/Page Override
        if (is_singular() && $post) {
            $custom_title = get_post_meta($post->ID, '_vonseowp_title', true);
            if (!empty($custom_title)) {
                return $custom_title;
            }
        }

        return $title;
    }

    public function output_meta_tags() {
        if (isset($GLOBALS['vonseowp_meta_tags_done'])) {
            return;
        }
        $GLOBALS['vonseowp_meta_tags_done'] = true;

        global $post;
        $options = get_option('vonseowp_settings', array());
        
        // Defaults
        // Title handled by filter_document_title
        $desc = $options['home_desc'] ?? get_bloginfo('description');
        $keywords = $options['keywords'] ?? '';
        $image = $options['default_image'] ?? '';
        $url = is_singular() ? get_permalink() : (isset($_SERVER['REQUEST_URI']) ? home_url(esc_url_raw(wp_unslash($_SERVER['REQUEST_URI']))) : home_url());
        $type = 'website';
        $noindex = false;
        $social_enabled = !isset($options['enable_og']) || (int) $options['enable_og'] === 1;

        // Per-post overrides
        if (is_singular() && $post) {
            // $custom_title handled by filter
            $custom_desc = get_post_meta($post->ID, '_vonseowp_description', true);
            $custom_keywords = get_post_meta($post->ID, '_vonseowp_keywords', true);
            $custom_image = get_post_meta($post->ID, '_vonseowp_image', true);
            $noindex = get_post_meta($post->ID, '_vonseowp_noindex', true) === '1';

            if ($custom_desc) {
                $desc = $custom_desc;
            } elseif (has_excerpt($post->ID)) {
                $desc = get_the_excerpt($post->ID);
            } else {
                $desc = wp_trim_words(strip_shortcodes($post->post_content), 30, '...');
            }
            if ($custom_keywords) $keywords = $custom_keywords;
            if ($custom_image) {
                $image = $custom_image;
            } elseif (has_post_thumbnail($post->ID)) {
                $image = get_the_post_thumbnail_url($post->ID, 'large');
            }

            $type = 'article';
            $url = get_permalink($post->ID);
        }

        // Social Overrides
        $social_title = '';
        $social_desc = '';
        if (is_singular() && $post) {
            $social_title = get_post_meta($post->ID, '_vonseowp_social_title', true);
            $social_desc = get_post_meta($post->ID, '_vonseowp_social_desc', true);
        }

        // Sanitize
        // Sanitize
        $title = wp_get_document_title(); // Get the filtered title for OG tags
        $desc = esc_attr(wp_strip_all_tags($desc));
        
        $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
        
        $parsed_path = wp_parse_url($url, PHP_URL_PATH);
        $canonical_path = $parsed_path ? ltrim($parsed_path, '/') : '';
        $canonical = !empty($options['canonical_host']) ? trailingslashit($options['canonical_host']) . $canonical_path : $url;

        echo "\n<!-- VonSEOWP v" . esc_html(VONSEOWP_VERSION) . " - Premium SEO -->\n";

        // Basic Meta
        echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
        if ($keywords) echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n";
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
        echo '<meta name="generator" content="VonSEOWP ' . esc_attr(VONSEOWP_VERSION) . '" />' . "\n";
        
        if (!empty($options['google_verify'])) echo '<meta name="google-site-verification" content="' . esc_attr($options['google_verify']) . '" />' . "\n";
        if (!empty($options['bing_verify'])) echo '<meta name="msvalidate.01" content="' . esc_attr($options['bing_verify']) . '" />' . "\n";
        
        // Robots
        if ($noindex) {
            echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
        } else {
            echo '<meta name="robots" content="index, follow, max-image-preview:large" />' . "\n";
        }

        if ($social_enabled) {
            // Open Graph
            echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . "\n";
            echo '<meta property="og:type" content="' . esc_attr($type) . '" />' . "\n";
            echo '<meta property="og:title" content="' . esc_attr($social_title ?: $title) . '" />' . "\n";
            echo '<meta property="og:description" content="' . esc_attr($social_desc ?: $desc) . '" />' . "\n";
            echo '<meta property="og:url" content="' . esc_url($canonical) . '" />' . "\n";
            echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
            if ($image) echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
            
            // WhatsApp & Telegram specific (They use OG but sometimes need specific dimensions/hints)
            if ($image) {
                echo '<meta property="og:image:width" content="1200" />' . "\n";
                echo '<meta property="og:image:height" content="630" />' . "\n";
            }

            if (is_singular() && $post) {
                echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c', $post)) . '" />' . "\n";
                echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c', $post)) . '" />' . "\n";
            }

            // Twitter Cards
            echo '<meta name="twitter:card" content="' . ($image ? 'summary_large_image' : 'summary') . '" />' . "\n";
            echo '<meta name="twitter:title" content="' . esc_attr($social_title ?: $title) . '" />' . "\n";
            echo '<meta name="twitter:description" content="' . esc_attr($social_desc ?: $desc) . '" />' . "\n";
            if ($image) echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
            if (!empty($options['twitter_username'])) {
                $tw = ltrim($options['twitter_username'], '@');
                echo '<meta name="twitter:site" content="@' . esc_attr($tw) . '" />' . "\n";
                echo '<meta name="twitter:creator" content="@' . esc_attr($tw) . '" />' . "\n";
            }
        }
        // LinkedIn (Uses OG, but specific tags help)
        echo '<meta name="author" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";

        echo "<!-- /VonSEOWP -->\n\n";
    }

    public function output_json_ld() {
        if (isset($GLOBALS['vonseowp_json_ld_done'])) {
            return;
        }
        $GLOBALS['vonseowp_json_ld_done'] = true;

        global $post;
        $options = get_option('vonseowp_settings', array());
        $schema_type = $options['schema_org_type'] ?? 'Organization';
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@graph' => array()
        );

        // 1. Organization / Person
        $entity = array(
            '@type' => $schema_type,
            '@id' => home_url('/#' . strtolower($schema_type)),
            'name' => $options['home_title'] ?? get_bloginfo('name'),
            'url' => home_url(),
        );

        // Local SEO Data
        if (!empty($options['business_name'])) {
            $entity['name'] = $options['business_name'];
        }
        
        if (!empty($options['address'])) {
            $entity['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $options['address'],
                'addressLocality' => $options['city'] ?? '',
                'addressRegion' => $options['state'] ?? '',
                'postalCode' => $options['zip'] ?? '',
                'addressCountry' => $options['country'] ?? ''
            );
        }

        if (!empty($options['phone'])) {
            $entity['telephone'] = $options['phone'];
            $entity['contactPoint'] = array(
                '@type' => 'ContactPoint',
                'telephone' => $options['phone'],
                'contactType' => 'customer service'
            );
        }

        if (has_site_icon()) {
            $entity['logo'] = array(
                '@type' => 'ImageObject',
                'url' => get_site_icon_url(512)
            );
        }
        $schema['@graph'][] = $entity;

        // 2. WebSite with SearchAction
        $schema['@graph'][] = array(
            '@type' => 'WebSite',
            '@id' => home_url('/#website'),
            'url' => home_url(),
            'name' => get_bloginfo('name'),
            'publisher' => array('@id' => home_url('/#' . strtolower($schema_type))),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => array(
                    '@type' => 'EntryPoint',
                    'urlTemplate' => home_url('/?s={search_term_string}')
                ),
                'query-input' => 'required name=search_term_string'
            )
        );

        // 3. BlogPosting (for singular posts/pages)
        if (is_singular() && $post) {
            $custom_desc = get_post_meta($post->ID, '_vonseowp_description', true);
            $desc = $custom_desc ?: wp_trim_words($post->post_content, 25, '...');
            $image_url = '';
            
            $custom_image = get_post_meta($post->ID, '_vonseowp_image', true);
            if ($custom_image) {
                $image_url = $custom_image;
            } elseif (has_post_thumbnail($post->ID)) {
                $image_url = get_the_post_thumbnail_url($post->ID, 'large');
            }

            // Custom Schema Type
            $custom_type = get_post_meta($post->ID, '_vonseowp_schema_type', true);
            $type = !empty($custom_type) ? $custom_type : (is_page() ? 'WebPage' : 'BlogPosting');
            
            // Custom ID anchor
            $anchor = is_page() ? 'webpage' : 'article';
            if ($type === 'Product') $anchor = 'product';
            if ($type === 'Review') $anchor = 'review';
            if ($type === 'Service') $anchor = 'service';

            $article = array(
                '@type' => $type,
                '@id' => get_permalink() . '#' . $anchor,
                'headline' => wp_strip_all_tags(get_the_title()),
                'description' => esc_attr(wp_strip_all_tags($desc)),
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => array(
                    '@type' => 'Person',
                    'name' => wp_strip_all_tags(get_the_author()),
                    'url' => get_author_posts_url(get_the_author_meta('ID'))
                ),
                'publisher' => array('@id' => home_url('/#' . strtolower($schema_type))),
                'mainEntityOfPage' => array(
                    '@type' => 'WebPage',
                    '@id' => get_permalink()
                )
            );

            // Add Rating for Reviews/Products
            $rating = get_post_meta($post->ID, '_vonseowp_rating', true);
            if (is_numeric($rating) && $rating > 0) {
                $rating_count = get_post_meta($post->ID, '_vonseowp_rating_count', true);
                if (!$rating_count || !is_numeric($rating_count)) {
                    $rating_count = 1; // Fallback
                }
                
                $article['aggregateRating'] = array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => $rating,
                    'bestRating' => '5',
                    'worstRating' => '1',
                    'ratingCount' => (int) $rating_count
                );
            }

            if ($image_url) {
                $article['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $image_url
                );
            }

            $schema['@graph'][] = $article;

            // 3.1 FAQ Schema
            $faqs = get_post_meta($post->ID, '_vonseowp_faq', true);
            if (!empty($faqs) && is_array($faqs)) {
                $faq_schema = array(
                    '@type' => 'FAQPage',
                    'mainEntity' => array()
                );
                foreach ($faqs as $faq) {
                    $faq_schema['mainEntity'][] = array(
                        '@type' => 'Question',
                        'name' => wp_strip_all_tags($faq['q']),
                        'acceptedAnswer' => array(
                            '@type' => 'Answer',
                            'text' => wp_strip_all_tags($faq['a'])
                        )
                    );
                }
                $schema['@graph'][] = $faq_schema;
            }

            // 3.2 Video Schema
            $video = get_post_meta($post->ID, '_vonseowp_video', true);
            if (!empty($video) && is_array($video) && !empty($video['url'])) {
                $video_schema = array(
                    '@type' => 'VideoObject',
                    'name' => $video['name'] ?: get_the_title(),
                    'description' => $video['desc'] ?: wp_trim_words($post->post_content, 30),
                    'thumbnailUrl' => $image_url ?: home_url('/favicon.ico'),
                    'uploadDate' => get_the_date('c'),
                    'contentUrl' => $video['url'],
                    'embedUrl' => $video['url']
                );
                $schema['@graph'][] = $video_schema;
            }
        }

        // 4. Breadcrumbs
        $breadcrumbs = array(
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => __('Home', 'vonseo'),
                    'item' => home_url()
                )
            )
        );

        if (is_singular() && $post) {
            // Add category for posts
            if (is_single()) {
                $categories = get_the_category($post->ID);
                if (!empty($categories)) {
                    $breadcrumbs['itemListElement'][] = array(
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $categories[0]->name,
                        'item' => get_category_link($categories[0]->term_id)
                    );
                    $breadcrumbs['itemListElement'][] = array(
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => get_the_title(),
                        'item' => get_permalink()
                    );
                }
            } else {
                $breadcrumbs['itemListElement'][] = array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => get_the_title(),
                    'item' => get_permalink()
                );
            }
        }

        $schema['@graph'][] = $breadcrumbs;

        echo '<script type="application/ld+json" class="vonseowp-schema">' . "\n";
        echo wp_json_encode($schema);
        echo "\n</script>\n";
    }

    /**
     * Handle Robots.txt output
     */
    public function handle_robots_txt(string $output, bool $public): string {
        $options = get_option('vonseowp_settings', array());
        if (!empty($options['robots_txt'])) {
            return $options['robots_txt'];
        }
        return $output;
    }
}
