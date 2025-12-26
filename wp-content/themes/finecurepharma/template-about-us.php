<?php
// Template Name: About Us
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

<section class="cpy-64px about-purpose">
    <div class="text-center">
        <div class="section-small-name">Our Purpose</div>
        <h3 class="section-title font-ArnoPro"><?php the_field('purpose_title', 24); ?></h3>
        <div class="cmb-32px">
            <p class="sub-text">Finecure Pharmaceuticals Limited is leading pharmaceutical formulation company with
                state-of-the-art production facilities and a wide range of products in acute and therapeutic products in
                oral dosage forms and injections.</p>
            <p class="sub-text mb-0">The company is the flagship company of the chandrans group and is driven by
                combining the best of values
                of committed entrepreneurship, strong work ethics, and is driven with intellectual human capital as
                driving force backed with dedicated manufacturing plants certified by WHO-GMP, international GMPs and
                accreditations.</p>
        </div>
    </div>
</section>

<section class="cpx-40px about-us-section custom-gap64">
    <div class="about-us-image">
        <?php
        $image = get_field('about_us_pic', 24);
        if (!empty($image)): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="img-fluid" />
        <?php endif; ?>
    </div>
    <div class="about-us-info">
        <div class="section-small-name">About Us</div>
        <h3 class="section-title"><?php the_field('about_us_title', 24); ?></h3>
        <div class="cmb-32px">
            <p class="sub-text">Finecure Pharmaceuticals Ltd combines the best of values of committed entrepreneurship,
                strong work ethics, and has WHO-GMP and international GMPs certified manufacturing units. Finecure
                Pharmaceuticals Ltd is the leading Pharma company in the country. Since its inception the company has
                always been committed to strict adherence to international standards of quality.</p>
            <p class="sub-text mb-0">Finecure Pharmaceuticals has attained this prestigious position through continuous
                focus on human resource development, close teamwork, innovative marketing skills and modern production
                facilities.</p>
        </div>
    </div>
</section>

<section class="cpx-40px cpy-64px vision-mission">
    <ul>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/vision-icon.svg" alt="" class="bg-icon">
            <div class="icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/vision-icon.svg" alt=""
                    class="icon-main">
            </div>
            <h3>Vision</h3>
            <p class="text-18px text-4a4a4a mb-0">Envisioned to serving the world with quality medicaments with
                affordability, spreading happiness and
                smiles and to become a globally recognized healthcare company.</p>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mission-icon.svg" alt=""
                class="bg-icon">
            <div class="icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mission-icon.svg" alt=""
                    class="icon-main">
            </div>
            <h3>Mission</h3>
            <p class="text-18px text-4a4a4a mb-0">Manufacturing best medicaments and wellness products and to be
                recognized as a brand connected for life with a touch of care.</p>
        </li>
        <li>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/purpose-icon.svg" alt=""
                class="bg-icon">
            <div class="icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/purpose-icon.svg" alt=""
                    class="icon-main">
            </div>
            <h3>Purpose</h3>
            <p class="text-18px text-4a4a4a mb-0">We are driven to transform lives of people for a healthier and
                happier tomorrow, adding exceptional value by providing cost-affordable, quality medicines and
                wellness medicaments to contribute in the wellbeing of the world.</p>
        </li>
    </ul>
</section>

<section class="ceo-message">
    <div class="ceo-personal-info">
        <div class="ceo-profile-pic">
            <?php
            $image = get_field('ceo_pic', 24);
            if (!empty($image)): ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                    class="img-fluid" />
            <?php endif; ?>
        </div>
        <div class="name-designation">
            <h3><?php the_field('ceo_name', 24); ?></h3>
            <p><?php the_field('ceo_designation', 24); ?></p>
        </div>
    </div>
    <div class="ceo-info">
        <div class="section-small-name">CEO Message</div>
        <h3 class="section-title"><?php the_field('ceo_title', 24); ?></h3>
        <div class="cmb-32px">
            <p class="sub-text">As we progress at a relentless pace towards a better tomorrow, it is integral that we
                work to achieve a healthier tomorrow. Finecure forayed into healthcare with a mission to transform the
                lives of the ailing humanity through innovation in healthcare and through the manufacturing of quality
                pharmaceutical products at affordable costs. Our journey from our origin until today is the
                authentication of our continuous striving to achieve our mission of ‘Making Lives Healthier’. The
                principles at Finecure are our spine for growth. Making lives healthier, which is part of our brand
                identity, reflects the inherent value of Finecure. We believe in the integrity of work and manufacturing
                our products in accordance with global parameters – a value that every Finecure Product has sustained
                and upheld. Finecure has been trusted as a quality product manufacturer amongst the medical fraternity
                and our focus on quality coupled with marketing has led Finecure to be listed amongst the Fastest
                Growing Pharma Companies.</p>
            <p class="sub-text mb-0">Looking back on the journey that we have traversed so far, a sense of satisfaction
                emerges for what we have achieved. However, we are not resting on our laurels for there is a lot more to
                achieve. We firmly believe in and continually practice good corporate governance which is evidenced by
                our tenets of transparency,</p>
        </div>
    </div>
</section>

<section class="cpx-40px cpy-64px about-stats">
    <?php
    $wp_service = array(
        'post_type' => 'about-stats',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => 5,
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
        <div class="stats-card">
            <div class="pic">
                <img src="<?php echo $imagepath[0] ?>" alt="Icon" class="img-fluid w-100">
            </div>
            <div class="count-info">
                <h4><?php the_title(); ?></h4>
                <p><?php echo wp_trim_words(get_the_excerpt()); ?></p>
                <a href="<?php the_permalink(); ?>" class="read-more-link">Read More
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    <?php } ?>
</section>

<?php get_footer(); ?>