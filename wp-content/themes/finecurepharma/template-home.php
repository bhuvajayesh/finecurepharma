<?php
// Template Name: Home
get_header();
?>

<section class="">
    <div class="home-banner">
        <?php
        $image = get_field('banner_picture_full', 8);
        if (!empty($image)): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="banner-pic" />
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px">
    <ul class="infrastructure-count">
        <?php
        $wp_service = array(
            'post_type' => 'infrastructure-count',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC',
            'posts_per_page' => 4,
        );
        $servicequery = new Wp_Query($wp_service);

        while ($servicequery->have_posts()) {
            $servicequery->the_post();
            $imagepath = wp_get_attachment_image_src(
                get_post_thumbnail_id(),
                'large'
            );

            $postId = get_the_ID();
            $author_id = get_post_field('post_name', $postId);
            ?>
            <li>
                <div class="icon">
                    <img src="<?php echo $imagepath[0] ?>" alt="Icon" class="img-fluid">
                </div>
                <div class="count-info">
                    <div class="count-number">
                        <div class="counting" data-count="<?php echo wp_trim_words(get_the_excerpt()); ?>">0</div>
                        <label>+</label>
                    </div>
                    <h4><?php the_title(); ?></h4>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>

<section class="my-lg-3 cpx-40px py-5 our-company-section custom-gap64">
    <div class="our-company-info">
        <div class="section-small-name">About Us</div>
        <h3 class="section-title"><?php the_field('our_company_title', 8); ?></h3>
        <div class="cmb-32px">
            <p class="sub-text"><?php the_field('our_company_disc1', 8); ?></p>
            <p class="sub-text mb-0"><?php the_field('our_company_disc2', 8); ?></p>
        </div>
        <?php
        $link = get_field('about_learn_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
    <div class="our-company-image">
        <?php
        $image = get_field('our_company_picture', 8);
        if (!empty($image)): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="img-fluid" />
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px cpy-64px what-we-do-section bg-light-glue">
    <div class="what-we-do-pic">
        <?php
        $image = get_field('what_we_do_pic', 8);
        if (!empty($image)): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="img-fluid" />
        <?php endif; ?>
    </div>
    <div class="what-we-do-info">
        <div class="section-small-name">What We Do</div>
        <h3 class="section-title font-ArnoPro"><?php the_field('what_we_do_title', 8); ?></h3>
        <div class="cmb-32px">
            <p class="sub-text mb-0"><?php the_field('what_we_do_description', 8); ?></p>
        </div>
        <?php
        $link = get_field('what_we_do_learn_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px cpy-64px">
    <div class="text-center">
        <div class="section-small-name">What We Do</div>
        <h3 class="section-title mb-4"><?php the_field('therapeutic_areas_title', 8); ?></h3>
        <p class="sub-text mb-0"><?php the_field('therapeutic_areas_disc', 8); ?></p>
    </div>
    <div class="swiper common-slide home-therapeutic-slider cmy-32px">
        <div class="swiper-wrapper">
            <?php
            $wp_service = array(
                'post_type' => 'h-therapeutic-slider',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => 4,
            );
            $servicequery = new Wp_Query($wp_service);

            while ($servicequery->have_posts()) {
                $servicequery->the_post();
                $imagepath = wp_get_attachment_image_src(
                    get_post_thumbnail_id(),
                    'large'
                );

                $postId = get_the_ID();
                $author_id = get_post_field('post_name', $postId);
                ?>
                <div class="swiper-slide">
                    <div class="swiper-pic">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-small.svg" alt="logo"
                            class="slider-logo-tag">
                        <img src="<?php echo $imagepath[0] ?>" alt="Product Image" class="slider-pic-img">
                    </div>
                    <div class="swiper-info">
                        <div class="swiper-title"><?php the_title(); ?></div>
                        <p><?php echo wp_trim_words(get_the_excerpt()); ?></p>
                        <a href="<?php the_permalink(); ?>" class="learn-more-link">Learn More
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#1B1464" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="text-center">
        <?php
        $link = get_field('therapeutic_explore_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px our-facilities-section">
    <div class="row">
        <div class="col-md-6">
            <div class="section-small-name">Infrastructure</div>
            <h3 class="section-title mb-0">
                <?php the_field('our_facilities_title', 8); ?>
            </h3>
            <p class="sub-text cmy-32px">
                <?php the_field('our_facilities_disc', 8); ?>
            </p>
            <?php
            $link = get_field('our_facilities_learn_more', 8);
            if ($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cpx-40px cpy-64px">
    <div class="text-center">
        <div class="section-small-name">Our Products & Brands</div>
        <h3 class="section-title mb-4">
            <?php the_field('brands_title', 8); ?>
        </h3>
        <p class="sub-text mb-0">
            <?php the_field('brands_disc', 8); ?>
        </p>
    </div>
    <div class="swiper common-slide home-healthcare-brands-slider cmy-32px">
        <div class="swiper-wrapper">
            <?php
            $wp_service = array(
                'post_type' => 'h-healthcare-brands',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => 4,
            );
            $servicequery = new Wp_Query($wp_service);

            while ($servicequery->have_posts()) {
                $servicequery->the_post();
                $imagepath = wp_get_attachment_image_src(
                    get_post_thumbnail_id(),
                    'large'
                );

                $postId = get_the_ID();
                $author_id = get_post_field('post_name', $postId);
                ?>
                <div class="swiper-slide">
                    <div class="swiper-pic">
                        <img src="<?php echo $imagepath[0] ?>" alt="Product Image" class="slider-pic-img">
                    </div>
                    <div class="swiper-info">
                        <h4 class="product-name-small"><?php the_field('product_name_small'); ?></h4>
                        <div class="swiper-title"><?php the_title(); ?></div>
                        <p><?php echo wp_trim_words(get_the_excerpt()); ?></p>
                        <a href="<?php the_permalink(); ?>" class="learn-more-link">Learn More
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#1B1464" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="text-center">
        <?php
        $link = get_field('brands_explore_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px cpy-64px bg-light-glue">
    <div class="text-center">
        <div class="section-small-name">Accreditations</div>
        <h3 class="section-title mb-4">
            <?php the_field('quality_assurance_title', 8); ?>
        </h3>
        <p class="sub-text mb-0">
            <?php the_field('quality_assurance_disc', 8); ?>
        </p>
    </div>
    <div class="certifications-list cmy-32px">
        <?php
        $certifications = [
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo1.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo2.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo3.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo4.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo5.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo6.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo7.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo8.svg'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/quality-assurance-logo9.svg'
            ],
        ];
        ?>
        <?php foreach ($certifications as $cert): ?>
            <div class="cert-item">
                <img src="<?php echo esc_url($cert['image']); ?>" alt="Certificate Logo" class="img-fluid">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center">
        <?php
        $link = get_field('quality_assurance_explore_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>">
                <?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px cpy-64px">
    <div class="text-center">
        <div class="section-small-name">Accolades</div>
        <h3 class="section-title mb-4">
            <?php the_field('our_achievements_title', 8); ?>
        </h3>
        <p class="sub-text mb-0">
            <?php the_field('our_achievements_disc', 8); ?>
        </p>
    </div>
    <div class="achievements-list cmy-32px">
        <?php
        $achievements = [
            [
                'image' => get_template_directory_uri() . '/assets/images/achievements-cert1.png',
                'certName' => 'Best Healthcare Brands 2023 by Economic Times',
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/achievements-cert2.png',
                'certName' => 'Dream Companies to Work For - 19th Rank World HRD Congress - 2022',
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/achievements-cert3.png',
                'certName' => 'Best of Asia - Most Admired Brand by White Page International - 2022',
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/achievements-cert4.png',
                'certName' => 'Dream companies to work for - 24th Rank, Times Ascent World HRD Congress 2021',
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/achievements-cert5.png',
                'certName' => 'Gujarat Best Employer Brand 2020',
            ],
        ];
        ?>
        <?php foreach ($achievements as $cert): ?>
            <div class="achievements-item">
                <img src="<?php echo esc_url($cert['image']); ?>" alt="Certificate Logo" class="img-fluid">
                <p><?php echo esc_html($cert['certName']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center">
        <?php
        $link = get_field('our_achievements_explore_more', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>">
                <?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="cpx-40px collaborate-section">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="section-small-name">Collaborate with Finecure</div>
            <h3 class="section-title mb-0">
                <?php the_field('collaborate_title', 8); ?>
            </h3>
            <p class="sub-text cmy-32px">
                <?php the_field('collaborate_disc', 8); ?>
            </p>
            <?php
            $link = get_field('collaborate_join_hands_link', 8);
            if ($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cpx-40px home-career-section">
    <div class="row">
        <div class="col-md-6">
            <div class="section-small-name">Career</div>
            <h3 class="section-title mb-0">
                <?php the_field('work_with_us_title', 8); ?>
            </h3>
            <p class="sub-text cmy-32px">
                <?php the_field('work_with_us_disc', 8); ?>
            </p>
            <?php
            $link = get_field('work_join_us', 8);
            if ($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cpx-40px cpy-64px home-blog-section">
    <div class="text-center">
        <div class="section-small-name">Our Blogs</div>
        <h3 class="section-title mb-4">
            <?php the_field('blog_title', 8); ?>
        </h3>
        <p class="sub-text mb-0">
            <?php the_field('blog_disc', 8); ?>
        </p>
    </div>
    <div class="cmy-32px">Blog List</div>
    <div class="text-center">
        <?php
        $link = get_field('blog_see_all', 8);
        if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <a class="default-btn-white" href="<?php echo site_url(); ?><?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr($link_target); ?>">
                <?php echo esc_html($link_title); ?>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>