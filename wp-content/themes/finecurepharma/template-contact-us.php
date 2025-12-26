<?php
// Template Name: Contact Us
get_header();
?>
<section class="inner-banner cpx-40px">
    <div class="inner-banner-content">
        <nav class="inner-banner-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo site_url(); ?>">Home</a>
            <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                    alt=""></span>
            <span><?php the_title(); ?></span>
        </nav>
        <h1 class="inner-banner-title section-title"><?php the_title(); ?></h1>
    </div>
</section>

<?php get_footer(); ?>