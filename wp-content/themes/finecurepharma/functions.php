<?php
// functions and shortcodes for Finecure theme (cleaned)

// Theme setup: nav menus and support
function my_theme_setup()
{
    register_nav_menus(array(
        'primary_menu' => 'Main Menu',
    ));
    add_theme_support('custom-header');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

// Allow SVG uploads
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Register Maker CPT
register_post_type('maker', array(
    'labels' => array(
        'name' => 'Makers',
        'singular_name' => 'Maker',
    ),
    'public' => true,
    'show_in_menu' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
));

// Product CPT
function create_products_cpt()
{
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'products'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_menu' => true,
    );
    register_post_type('product', $args);
}
add_action('init', 'create_products_cpt');

// Product Category Taxonomy
function create_products_taxonomy()
{
    $labels = array(
        'name' => 'Product Categories',
        'singular_name' => 'Product Category',
    );
    register_taxonomy('products_cat', 'product', array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'products'),
        'public' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_products_taxonomy');

// ---------- Elasticsearch search shortcode (uses configured ES host/index) ----------
add_option('fc_es_host', 'http://127.0.0.1:9200');
add_option('fc_es_index', '');

function fc_get_es_host()
{
    return get_option('fc_es_host', 'http://127.0.0.1:9200');
}
function fc_get_es_index()
{
    return get_option('fc_es_index', '');
}

// Compact search input shortcode (header)
add_shortcode('es_search_input', 'fc_es_search_input_shortcode');
function fc_es_search_input_shortcode($atts = [])
{
    $q = '';
    if (isset($_GET['q']) && trim($_GET['q']) !== '') {
        $q = wp_unslash(trim($_GET['q']));
    } elseif (isset($_GET['s']) && trim($_GET['s']) !== '') {
        $q = wp_unslash(trim($_GET['s']));
    }
    $q = trim($q);
    $action_url = esc_url(add_query_arg(array()));
    $search_icon = get_template_directory_uri() . '/assets/images/search-icon.svg';
    $html = '<div class="fc-es-search-input">';
    $html .= '<form method="get" action="' . $action_url . '">';
    $html .= '<img src="' . esc_url($search_icon) . '" alt="Search Icon" />';
    $html .= '<input class="search-input" aria-label="Search site" type="search" name="q" value="' . esc_attr($q) . '" placeholder="Search by...">';
    $html .= '</form>';
    $html .= '</div>';
    return $html;
}

// Elasticsearch results shortcode
add_shortcode('es_search_home', 'fc_es_search_home_shortcode');
function fc_es_search_home_shortcode($atts = [])
{
    $es_host = rtrim(fc_get_es_host(), '/');
    $es_index = fc_get_es_index();
    $q = '';
    if (isset($_GET['q']) && trim($_GET['q']) !== '') {
        $q = wp_unslash(trim($_GET['q']));
    } elseif (isset($_GET['s']) && trim($_GET['s']) !== '') {
        $q = wp_unslash(trim($_GET['s']));
    }
    $q = trim($q);
    if ($q === '') {
        return '';
    }

    // Build ES query
    $es_query = [
        'size' => 20,
        'query' => [
            'bool' => [
                'must' => [
                    [
                        'bool' => [
                            'should' => [
                                [
                                    'multi_match' => [
                                        'query' => $q,
                                        'fields' => ['post_title^5', 'post_excerpt', 'post_content'],
                                        'type' => 'best_fields',
                                        'fuzziness' => 'AUTO'
                                    ]
                                ],
                                [
                                    'multi_match' => [
                                        'query' => $q,
                                        'fields' => ['post_title'],
                                        'type' => 'phrase_prefix'
                                    ]
                                ]
                            ],
                            'minimum_should_match' => 1
                        ]
                    ]
                ],
                'filter' => [
                    ['terms' => ['post_type' => ['product', 'post', 'page']]],
                    ['term' => ['post_status' => 'publish']]
                ]
            ]
        ],
        'highlight' => [
            'pre_tags' => ['<mark>'],
            'post_tags' => ['</mark>'],
            'fields' => [
                'post_title' => new stdClass(),
                'post_content' => new stdClass()
            ]
        ]
    ];

    $url = $es_host . '/' . rawurlencode($es_index) . '/_search';
    $args = [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => wp_json_encode($es_query),
        'timeout' => 15,
    ];

    $response = wp_remote_post($url, $args);
    if (is_wp_error($response)) {
        return '<div class="fc-es-error">Search error: ' . esc_html($response->get_error_message()) . '</div>';
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    if ($code != 200) {
        return '<div class="fc-es-error">Elasticsearch responded with status ' . intval($code) . '</div>';
    }

    $data = json_decode($body, true);
    if (!$data || !isset($data['hits']['hits'])) {
        return '<div class="fc-es-error">No results or invalid response.</div>';
    }

    $hits = $data['hits']['hits'];
    $total = isset($data['hits']['total']['value']) ? intval($data['hits']['total']['value']) : count($hits);

    $html = '<div class="fc-es-results">';
    $html .= '<p style="margin:.25rem 0;color:#555;"><strong>' . $total . '</strong> results for <em>' . esc_html($q) . '</em></p>';
    $html .= '<ul style="list-style:none;padding-left:0;margin:0;">';

    foreach ($hits as $hit) {
        $src = isset($hit['_source']) ? $hit['_source'] : [];
        $title = $src['post_title'] ?? ($src['title'] ?? 'Untitled');
        $link = '#';
        if (!empty($src['permalink'])) {
            $link = $src['permalink'];
        } elseif (!empty($src['guid'])) {
            $link = $src['guid'];
        } elseif (!empty($src['url'])) {
            $link = $src['url'];
        } elseif (!empty($src['link'])) {
            $link = $src['link'];
        } elseif (!empty($src['post_id']) || !empty($src['ID'])) {
            $post_id = !empty($src['post_id']) ? intval($src['post_id']) : intval($src['ID']);
            if ($post_id > 0) {
                $permalink = get_permalink($post_id);
                if ($permalink) {
                    $link = $permalink;
                }
            }
        }

        $snippet = '';
        if (!empty($hit['highlight']['post_content'][0])) {
            $snippet = wp_kses_post($hit['highlight']['post_content'][0]);
        } elseif (!empty($src['post_excerpt'])) {
            $snippet = wp_strip_all_tags($src['post_excerpt']);
        } elseif (!empty($src['post_content'])) {
            $snippet = wp_trim_words(wp_strip_all_tags($src['post_content']), 30);
        } elseif (!empty($hit['highlight']['post_title'][0])) {
            $snippet = wp_kses_post($hit['highlight']['post_title'][0]);
        }

        $html .= '<li style="padding:1rem;border-bottom:1px solid #eef2f7;">';
        $html .= '<a href="' . esc_url($link) . '" style="font-weight:600;color:#0b7285;text-decoration:none;font-size:1.05rem;">' . esc_html($title) . '</a>';
        if ($snippet) {
            $html .= '<div style="color:#444;margin-top:.35rem;">' . $snippet . '</div>';
        }
        $html .= '</li>';
    }

    $html .= '</ul></div>';
    return $html;
}

?>