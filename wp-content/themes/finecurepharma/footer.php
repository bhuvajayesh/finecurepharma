</div>
<footer class="cpx-40px footer">
    <div class="footer-top">
        <div class="footer-top-left">
            <div class="logo">
                <a href="<?php echo site_url(); ?>" class="d-inline-block">
                    <?php $logoimg = get_header_image(); ?>
                    <img src="<?php echo $logoimg; ?>" alt="">
                </a>
            </div>
            <p class="my-4"><?php the_field('footer_left_info', 8); ?></p>
            <ul class="social-links">
                <li>
                    <a href="https://www.facebook.com/" target="_blank">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/" target="_blank">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </li>
                <li>
                    <a href="https://x.com/" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="footer-links">
            <h3 class="footer-title">Our Company</h3>
            <?php
            $footerOurCompanyLink = [
                ['footerCompanyLink' => 'About Us', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'CSR', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'What We Do', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Work With Us', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Infrastructure', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'International', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'F & D', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Domestics', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Quality', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Partner With Us', 'footerCompanyURL' => '#'],
                ['footerCompanyLink' => 'Products', 'footerCompanyURL' => '#'],
            ];
            ?>
            <ul class="footer-links-list">
                <?php foreach ($footerOurCompanyLink as $cert): ?>
                    <li>
                        <a href="<?php echo esc_url($cert['footerCompanyURL']); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-footer.svg"
                                alt="Arrow" />
                            <?php echo esc_html($cert['footerCompanyLink']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="footer-links footer-featured-links">
            <h3 class="footer-title">Featured Product Categories</h3>
            <?php
            $footerFeaturedLink = [
                ['footerCategoriesLink' => 'Antibiotics and Anti Infectives', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Anti Asthmatics and Anti Allergic', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Gastrointestinal Medicines', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Pain Management', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Cardiovascular And Anti-Diabetics', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Anti Asthmatics and Anti Allergic', 'footerCategoriesURL' => '#'],
                ['footerCategoriesLink' => 'Gastrointestinal Medicines', 'footerCategoriesURL' => '#'],
            ];
            ?>
            <ul class="footer-links-list">
                <?php foreach ($footerFeaturedLink as $cert): ?>
                    <li>
                        <a href="<?php echo esc_url($cert['footerCategoriesURL']); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-footer.svg"
                                alt="Arrow" />
                            <?php echo esc_html($cert['footerCategoriesLink']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="footer-links">
            <h3 class="footer-title">Get In Touch</h3>
            <div class="footer-touch-btns">
                <a class="default-btn-white" href="#">
                    Contact Us
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <a class="default-btn-white" href="#">
                    Meet Us an Events
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5.5L21 12.5M21 12.5L14 19.5M21 12.5L3 12.5" stroke="#1B1464" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <ul>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Sitemap</a></li>
        </ul>
        <p>© 2025 Finecure Pharmaceuticals Ltd. All rights reserved.</p>
    </div>
</footer>

<div class="scroll-top-arrow">
    <i class="fa-solid fa-angle-up"></i>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
<!-- <script src="<?php echo get_template_directory_uri(); ?>/assets/js/slick.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>
</body>

</html>