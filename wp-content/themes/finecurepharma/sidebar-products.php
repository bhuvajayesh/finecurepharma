<ul class="category-list" id="productCategoryMenu">
    <?php
        $exclude_slugs = [
        'therapeutic-index',
        'generic-index',
        'brand-index',
        'by-disease-class'
    ];

    $parents = get_terms([
        'taxonomy' => 'products_cat',
        'hide_empty' => false,
        'parent' => 0,
        'orderby' => 'term_id',
        'order' => 'ASC'
    ]);

    $parent_index = 0; // track first parent
    foreach ($parents as $parent) {
        if (in_array($parent->slug, $exclude_slugs, true)) {
        $parent_index++;
        continue;
    }

    $children = get_terms([
        'taxonomy'   => 'products_cat',
        'hide_empty' => false,
        'parent'     => $parent->term_id,
        'orderby'    => 'term_id',
        'order'      => 'ASC'
    ]);

        $has_children = !empty($children);
        $collapse_id = 'cat-' . $parent->term_id;

        // Default open first parent
        $is_open = ($parent_index === 0) ? 'show' : '';
        $aria_expanded = ($parent_index === 0) ? 'true' : 'false';
        ?>

        <li class="category-list-li">
            <div class="d-flex justify-content-between align-items-center">
                <a class="parent-category" <?php if ($has_children) { ?> data-bs-toggle="collapse"
                        href="#<?php echo $collapse_id; ?>" role="button" aria-expanded="<?php echo $aria_expanded; ?>"
                    <?php } else { ?> href="<?php echo esc_url(get_term_link($parent)); ?>" <?php } ?>>
                    <?php echo esc_html($parent->name); ?>

                    <?php if ($has_children) { ?>
                        <span class="toggle-icon" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapse_id; ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plus-icon.svg" alt="" class="plus">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/minus-icon.svg" alt="" class="minus">
                        </span>
                    <?php } ?>
                </a>
            </div>

            <?php if ($has_children) { ?>
                <ul class="child-category list-unstyled collapse <?php echo $is_open; ?>" id="<?php echo $collapse_id; ?>" data-bs-parent="#productCategoryMenu">
                    <?php
                    $child_index = 0;
                    foreach ($children as $child) {
                        // skip excluded child by slug
                        if (in_array($child->slug, $exclude_slugs, true)) {
                            $child_index++;
                            continue;
                        }

                        $child_active = ($parent_index === 0 && $child_index === 0) ? 'category-link-active' : '';
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($child)); ?>" class="category-link <?php echo $child_active; ?>">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.25 2.91671L9.33333 7.00004L5.25 11.0834" stroke="#4A4A4A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <?php echo esc_html($child->name); ?>
                            </a>
                        </li>
                        <?php
                        $child_index++;
                    } ?>
                </ul>
            <?php } ?>
        </li>

        <?php
        $parent_index++;
    } ?>
</ul>