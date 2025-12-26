<?php
/**
 * Template Name: Brand Index
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
            <h2>Brand Index</h2>
        </div>
    </div>
</div>
<?php get_footer(); ?>