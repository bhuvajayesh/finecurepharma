<?php get_header(); ?>
<div class="container py-5">
    <div class="row">
        <aside class="col-md-3"><?php get_sidebar('products'); ?></aside>
        <div class="col-md-9">
            <h2>All Products</h2>
            <div class="row g-4">
                <?php if (have_posts()):
                    while (have_posts()):
                        the_post(); ?>
                        <?php get_template_part('template-parts/product-card'); ?>
                    <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>