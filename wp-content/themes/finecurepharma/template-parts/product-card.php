<div class="col-md-4">
    <div class="product-card h-100">
        <div class="product-pic">
            <?php if (has_post_thumbnail())
                the_post_thumbnail('medium', ['class' => '']); ?>
        </div>
        <div class="product-card-body">
            <h4 class="product-name-small"><?php the_field('product_name_small'); ?></h4>
            <h5 class="product-card-title"><?php the_title(); ?></h5>
            <p class=""><?php echo wp_trim_words(get_the_content()); ?></p>
            <a href="<?php the_permalink(); ?>" class="">Learn More
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 5L21 12M21 12L14 19M21 12L3 12" stroke="#302290" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</div>