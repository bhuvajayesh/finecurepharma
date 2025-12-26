<?php get_header(); ?>
<div class="container py-5">
    <div class="row">
        <aside class="col-md-3"><?php get_sidebar('products'); ?></aside>
        <div class="col-md-9">
            <h2><?php single_term_title(); ?></h2>
            <div class="row g-4">
                <?php while (have_posts()):
                    the_post(); ?>
                    <?php get_template_part('template-parts/product-card'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>