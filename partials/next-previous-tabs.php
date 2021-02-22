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
    <nav id="pagination-label" class="moj-pagination 

    <?php if (!empty($prev_page)) {
        echo 'has-prev-page';
    }

    if (!empty($next_page)) {
        echo 'has-next-page';
    } ?>">
      <ul class="moj-pagination__list">
        <?php
        if (!empty($prev_page)) {
            ?>
            <li class="moj-pagination__item  moj-pagination__item--prev">
              <a class="moj-pagination__link" href="<?php echo get_permalink($prev_page->ID); ?>">
                <?php echo $prev_page->post_title; ?>
              </a>
            </li>
            <?php
        }

        if (!empty($next_page)) {
            ?>
            <li class="moj-pagination__item  moj-pagination__item--next">
              <a class="moj-pagination__link" href="<?php echo get_permalink($next_page->ID); ?>">
                <?php echo $next_page->post_title; ?>
              </a>
            </li>
            <?php
        }
        ?>
    </div>
    <?php
}

