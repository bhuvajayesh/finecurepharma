<?php
// single-product.php
get_header();
while (have_posts()):
    the_post();

    // ACF fields (match the exact field names you created)
    $gallery_images = get_field('product_gallery'); // ACF Gallery → array
    $product_title = get_field('product_title_big');  // subtitle / brand

    // Category for breadcrumb / related fallback
    $cats = get_the_terms(get_the_ID(), 'product_cat');
    $first_cat = ($cats && !is_wp_error($cats)) ? $cats[0] : false;
    ?>


    <section class="inner-banner inner-banner-product cpx-40px">
        <div class="inner-banner-content">
            <nav class="inner-banner-breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo site_url(); ?>">Home</a>
                <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                        alt=""></span>
                <span>Our Products</span>
                <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                        alt=""></span>

                <!-- Product Name Dynamic -->
                <?php
                $index_label = '';
                $index_url = '#';

                // ✅ USE YOUR EXISTING TAXONOMY SLUG
                $terms = get_the_terms(get_the_ID(), 'products_cat');

                if (!empty($terms) && !is_wp_error($terms)) {
                    $index_label = $terms[0]->name;        // Therapeutic, Generic, Brand, Disease
                    $index_url = get_term_link($terms[0]); // Auto archive page link
                }
                ?>

                <?php if (!empty($index_label)): ?>
                    <a href="<?php echo esc_url($index_url); ?>">
                        <?php echo esc_html($index_label); ?>
                    </a>
                <?php endif; ?>

                <!-- Product Name Dynamic -->

                <span class="sep"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-right.svg"
                        alt=""></span>
                <span><?php the_title(); ?></span>
            </nav>
            <h1 class="inner-banner-title section-title"><?php the_title(); ?></h1>
        </div>
    </section>
    <!-- <nav class="text-sm text-gray-600 mb-4">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> &raquo;
        <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products/')); ?>">Our
            Products</a>
        <?php if ($first_cat): ?>
            &raquo; <a href="<?php echo esc_url(get_term_link($first_cat)); ?>"><?php echo esc_html($first_cat->name); ?></a>
        <?php endif; ?>
        &raquo; <span class="text-gray-800"><?php the_title(); ?></span>
    </nav> -->

    <div class="product-content-area cpx-40px">
        <aside class="custom-siderbar"><?php get_sidebar('products'); ?></aside>
        <div class="product-content-info">
            <div class="product-content-top">
                <div class="product-gallery">
                    <?php if (!empty($gallery_images) && is_array($gallery_images)): ?>
                        <!-- ACF Photo Gallery Slider -->
                        <div class="swiper productGallery">
                            <div class="swiper-wrapper">
                                <?php foreach ($gallery_images as $image): ?>
                                    <?php
                                    $img_url = $image['full_image_url'] ?? '';
                                    $img_alt = !empty($image['alt_text']) ? $image['alt_text'] : get_the_title();
                                    ?>

                                    <?php if ($img_url): ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>"
                                                class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    <?php elseif (has_post_thumbnail()): ?>
                        <!-- Featured Image fallback -->
                        <div class="product-featured-image">
                            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                        </div>
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                </div>

                <div class="product-detail-info">
                    <div class="">
                        <h4 class="product-name-small"><?php the_field('product_name_small'); ?></h4>
                        <h5 class="product-detail-name"><?php the_title(); ?></h5>
                    </div>
                    <div class="product-generic my-4 py-4">
                        <span>Generic</span>
                        <h4 class="generic-name"><?php the_field('generic_name'); ?></h4>
                    </div>
                    <div class="requirement-btn">
                        <button class="default-btn-white w-100">
                            Discuss Your Requirement
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="product-social mt-4">
                        <h5>Share</h5>
                        <?php
                        $facebook = get_field('facebook_link');
                        $whatsapp = get_field('whatsapp_link');
                        $linkedin = get_field('linkdin_link');
                        $twitter = get_field('twitter_link');
                        ?>
                        <ul class="social-share">
                            <?php if ($facebook): ?>
                                <li>
                                    <a href="<?php echo esc_url($facebook['url']); ?>"
                                        target="<?php echo esc_attr($facebook['target'] ?: '_blank'); ?>" rel="noopener">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($whatsapp): ?>
                                <li>
                                    <a href="<?php echo esc_url($whatsapp['url']); ?>"
                                        target="<?php echo esc_attr($whatsapp['target'] ?: '_blank'); ?>" rel="noopener">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($linkedin): ?>
                                <li>
                                    <a href="<?php echo esc_url($linkedin['url']); ?>"
                                        target="<?php echo esc_attr($linkedin['target'] ?: '_blank'); ?>" rel="noopener">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($twitter): ?>
                                <li>
                                    <a href="<?php echo esc_url($twitter['url']); ?>"
                                        target="<?php echo esc_attr($twitter['target'] ?: '_blank'); ?>" rel="noopener">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="specification-tab" data-bs-toggle="tab"
                            data-bs-target="#specification" type="button" role="tab" aria-controls="specification"
                            aria-selected="true">Product Specification</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dosage-tab" data-bs-toggle="tab" data-bs-target="#dosage" type="button"
                            role="tab" aria-controls="dosage" aria-selected="false">Available Dosage Forms</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="specification" role="tabpanel"
                        aria-labelledby="specification-tab">
                        <p><?php the_field('specification_paragraph'); ?></p>
                    </div>
                    <div class="tab-pane fade" id="dosage" role="tabpanel" aria-labelledby="dosage-tab">
                        <?php
                        $variants = get_field('dosage_list');

                        if ($variants):
                            $items = array_filter(array_map('trim', explode("\n", $variants)));
                            ?>
                            <ul class="dosage-variants">
                                <?php foreach ($items as $item): ?>
                                    <li><?php echo esc_html($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Realated Products -->
    <div class="related-products-area">
        <div class="related-pro-title">
            <span>Our Products & Brands</span>
            <h3>Related Products</h3>
            <p>Finecure Pharmaceuticals delivers trusted, innovation-led healthcare brands designed to meet global standards
                of <br class="d-none d-xl-block" /> quality and efficacy.</p>
        </div>
        <?php
        // Related products (fallback to same category)
        $rp_args = array(
            'post_type' => 'product',
            'posts_per_page' => 4,
            'post__not_in' => array(get_the_ID()),
        );
        if ($first_cat) {
            $rp_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $first_cat->term_id,
                ),
            );
        }

        $rp = new WP_Query($rp_args);

        if ($rp->have_posts()):
            echo '<div class="row g-4">'; // bootstrap row to match product card columns
    
            while ($rp->have_posts()):
                $rp->the_post();
                $rid = get_the_ID();
                ?>
                <div class="col-md-3">
                    <div class="product-card h-100 bg-white">
                        <div class="product-pic">
                            <?php
                            // prefer ACF product_gallery (ID) if present, otherwise fallback to post thumbnail
                            $related_gallery = get_field('product_gallery', $rid);

                            if (!empty($related_gallery) && is_array($related_gallery)) {
                                $img_url = $related_gallery[0]['thumbnail_image_url'] ?? '';
                                if ($img_url) {
                                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr(get_the_title($rid)) . '">';
                                }
                            } elseif (has_post_thumbnail($rid)) {
                                echo get_the_post_thumbnail($rid, 'medium');
                            } else {
                                echo '<div class="no-image">No image</div>';
                            }
                            ?>
                        </div>

                        <div class="product-card-body">
                            <?php
                            // product_name_small may be an ACF field; use get_field to avoid echoing for other loops
                            $small_name = get_field('product_name_small', $rid);
                            if ($small_name): ?>
                                <h4 class="product-name-small"><?php echo esc_html($small_name); ?></h4>
                            <?php endif; ?>

                            <h5 class="product-card-title"><?php echo esc_html(get_the_title($rid)); ?></h5>

                            <p><?php echo wp_kses_post(wp_trim_words(get_post_field('post_content', $rid), 30, '...')); ?></p>

                            <a href="<?php echo esc_url(get_permalink($rid)); ?>" class="learn-more-link">
                                Learn More
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#1B1464" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;

            echo '</div>'; // .row
    
            wp_reset_postdata();
        endif;
        ?>
    </div>


<?php endwhile;
get_footer(); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.querySelector(".productGallery")) {
            new Swiper(".productGallery", {
                slidesPerView: 1,
                loop: true,
                spaceBetween: 20,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                // },
            });
        }
    });
</script>