<?php
// search.php - override WP search results to use Elasticsearch shortcode
get_header();

// read WP search query param 's' and map to our ES query param 'q'
$q = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
// show title like WP
?>
<main id="main" class="site-main" role="main" style="max-width:900px;margin:0 auto;padding:2rem;">
    <header class="page-header">
        <h1 class="page-title">
            <?php if ($q): ?>
                <?php printf('Search Results for: %s', '<span>' . esc_html($q) . '</span>'); ?>
            <?php else: ?>
                <?php _e('Search', 'your-theme-textdomain'); ?>
            <?php endif; ?>
        </h1>
    </header>

    <div class="search-form-area" style="margin-bottom:1.25rem;">
        <!-- Keep the native search form (optional) or show ES form -->
        <?php echo do_shortcode('[es_search_home]'); ?>
    </div>

    <div class="search-results-area">
        <?php
        // If a query exists, call the ES search shortcode but pass q via GET param so it uses the same logic
        if ($q) {
            // ensure the shortcode sees ?q=...
            // temporary set $_GET['q'] for the shortcode if it expects 'q'
            $_GET['q'] = $q;
            echo do_shortcode('[es_search_home]');
            // unset to avoid side effects
            unset($_GET['q']);
        } else {
            // optional: show recent posts when no query
            echo '<p>No search query provided. Try searching above.</p>';
        }
        ?>
    </div>
</main>

<?php get_footer(); ?>