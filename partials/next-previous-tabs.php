<?php

/**
 * Next/Previous tabs based off of category
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * @copyright Ministry Of Justice
 * @version 1.0
 */

// Requires category-nav.php to be loaded first to set $prev_page and $next_page vars

if ($is_cat_page && (!empty($prev_page) || !empty($next_page))) { ?>
    <div class="category-page-pagination

    <?php if (!empty($prev_page)) {
        echo 'has-prev-page';
    }

    if (!empty($next_page)) {
        echo 'has-next-page';
    } ?>">

        <?php
        if (!empty($prev_page)) {
            ?>
            <div class="category-page-pagination-section category-page-pagination-prev">
                <a href="<?php echo get_permalink($prev_page->ID); ?>" class="category-page-pagination-page-link">Previous page</a>
                <div class="category-page-pagination-page-title">
                    <?php echo $prev_page->post_title; ?>
                </div>
            </div>
            <?php
        }

        if (!empty($next_page)) {
            ?>
            <div class="category-page-pagination-section category-page-pagination-next">
                <a href="<?php echo get_permalink($next_page->ID); ?>" class="category-page-pagination-page-link">Next page</a>
                <div class="category-page-pagination-page-title">
                    <?php echo $next_page->post_title; ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

