<?php
/**
 * Template Name: Generic Index
 */
get_header(); ?>
<section class="inner-banner inner-banner-product cpx-40px">
    <div class="inner-banner-content">
        <nav class="inner-banner-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo site_url(); ?>">Home</a>
            <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                    alt=""></span>
            <span>Our Products</span>
            <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                    alt=""></span>
            <span><?php the_title(); ?></span>
        </nav>
        <h1 class="inner-banner-title section-title"><?php the_title(); ?></h1>
    </div>
</section>

<div class="product-content-area cpx-40px">
    <aside class="custom-siderbar"><?php get_sidebar('products'); ?></aside>
    <div class="product-content">
        <div class="product-list-title">
            <h2>Generic Index</h2>
        </div>
        <?php
        $term_slug = 'generic-index';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 9,  // show 9 products per page
            'paged' => $paged,
            'post_status' => 'publish',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'products_cat',
                    'field' => 'slug',
                    'terms' => $term_slug,
                ),
            ),
        );
        $loop = new WP_Query($args);
        ?>
        <div class="row g-4">
            <?php
            if ($loop->have_posts()):
                while ($loop->have_posts()):
                    $loop->the_post();
                    get_template_part('template-parts/product-card');
                endwhile;
            else:
                echo '<p class="text-center m-0 col-12">No products found.</p>';
            endif;
            ?>
        </div>

        <!-- Pagination -->
        <div>
            <?php
            // SVG icons (WP default)
            $svg_prev = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 5L3 12M3 12L10 19M3 12L21 12" stroke="#1B1464" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            $svg_next = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#1B1464" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

            $cur_page = max(1, intval($paged));
            $total_pages = isset($loop->max_num_pages) ? intval($loop->max_num_pages) : 1;

            // 1) Build paginate_links HTML (list)
            $numbers_html = paginate_links(array(
                'total' => $total_pages,
                'current' => $cur_page,
                'type' => 'list',
                'mid_size' => 1,
                'end_size' => 1,
                'prev_text' => '', // we handle arrows ourselves
                'next_text' => '',
                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                'format' => user_trailingslashit('page/%#%/', 'paged'),
            ));

            // 2) Extract <ul> opening, inner content, closing
            if (preg_match('/^(<ul[^>]*>)(.*)(<\/ul>)$/is', $numbers_html, $parts)) {
                $ul_open = $parts[1];
                $ul_inner = $parts[2];
                $ul_close = $parts[3];

                // 3) Extract <li> elements
                preg_match_all('/(<li\b[^>]*>.*?<\/li>)/is', $ul_inner, $li_matches);

                $lis = $li_matches[1]; // array of <li>...</li>
                // Proceed only if there are items
                if (is_array($lis) && count($lis)) {

                    // Remove last <li> when on first page
                    if ($cur_page === 1) {
                        array_pop($lis);
                    }

                    // Remove first <li> when on last page
                    if ($cur_page === $total_pages) {
                        array_shift($lis);
                    }

                    // Rebuild inner HTML
                    $ul_inner_clean = implode("\n", $lis);
                    $numbers_html = $ul_open . $ul_inner_clean . $ul_close;
                }
                // if no li found or nothing to change, $numbers_html remains as-is
            }

            // 4) Output full pagination with custom prev/next always visible (disabled if needed)
            $prev_disabled = ($cur_page <= 1);
            $next_disabled = ($cur_page >= $total_pages);
            $prev_url = $prev_disabled ? '#' : esc_url(get_pagenum_link($cur_page - 1));
            $next_url = $next_disabled ? '#' : esc_url(get_pagenum_link($cur_page + 1));
            ?>

            <nav class="pagination-wrap" aria-label="Product pagination">
                <!-- Prev button -->
                <?php if (!$prev_disabled): ?>
                    <a class="pagination-btn prev" href="<?php echo $prev_url; ?>" rel="prev" aria-label="Previous page">
                        <?php echo $svg_prev; ?>
                    </a>
                <?php else: ?>
                    <span class="pagination-btn prev disabled" aria-hidden="true"><?php echo $svg_prev; ?></span>
                <?php endif; ?>

                <!-- Page numbers (cleaned) -->
                <div class="pagination-numbers">
                    <?php echo $numbers_html; ?>
                </div>

                <!-- Next button -->
                <?php if (!$next_disabled): ?>
                    <a class="pagination-btn next" href="<?php echo $next_url; ?>" rel="next" aria-label="Next page">
                        <?php echo $svg_next; ?>
                    </a>
                <?php else: ?>
                    <span class="pagination-btn next disabled" aria-hidden="true"><?php echo $svg_next; ?></span>
                <?php endif; ?>
            </nav>
        </div>

        <?php wp_reset_postdata(); ?>
    </div>
</div>
<?php get_footer(); ?>