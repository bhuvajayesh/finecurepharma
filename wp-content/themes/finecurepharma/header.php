<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?>
        <?php if (is_front_page()) {
            echo "| ";
            bloginfo('description');
        } ?>
    </title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" />
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        rel="stylesheet">
    <!-- <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/slick.css" rel="stylesheet">
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/slick-theme.css"
        rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css"
        rel="stylesheet">
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/custom-style.css"
        rel="stylesheet">
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/footer.css"
        rel="stylesheet">
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/custom-media.css"
        rel="stylesheet">
</head>

<body>
    <header class="header cpx-40px">
        <div class="logo">
            <a href="<?php echo site_url(); ?>" class="d-inline-block">
                <?php $logoimg = get_header_image(); ?>
                <img src="<?php echo $logoimg; ?>" alt="">
            </a>
        </div>
        <div class="header-right-area">
            <div class="custom-nav">
                <button class="toggleButton d-none">
                    <span class="one"></span>
                    <span class="two"></span>
                    <span class="three"></span>
                </button>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary_menu',
                    'container' => 'nav',
                    'menu_class' => 'finecurepharma-menu' // Add your own class for styling
                ));
                ?>
            </div>
        </div>
        <div class="header-right-search">
            <?php echo do_shortcode('[es_search_input]'); ?>
        </div>
    </header>


    <div class="page-overlay">
        <?php /* Full search results area appears after the header */ ?>
        <div class="global-search">
            <div class="cpx-40px">
                <?php echo do_shortcode('[es_search_home]'); ?>
            </div>
        </div>