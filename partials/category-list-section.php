<?php

/**
 * Category list section
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

$page_cats = get_the_terms(get_the_ID(), 'page_category');

$is_cat_page = false;
$prev_page = '';
$next_page = '';

if (!empty($page_cats)) {
    $page_cat = $page_cats[0];
    $current_page = get_the_ID();

    $args = [
        'post_type' => 'page',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'page_category',
                'terms'    => $page_cat->term_id,
            ],
        ],
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ];

    $pages = get_posts($args);

    if (!empty($pages) && count($pages) > 1) {
            $current_cat_page_index = 0;

            $is_cat_page = true;
        ?>
        <header class="entry-header page-header" style="">
        <div class="nhsuk-width-container">
            <div class="nhsuk-grid-row">
                <div class="nhsuk-grid-column-two-thirds">
                        <h2 class="category-pages-title hale-heading-xl"><?php echo $page_cat->name; ?></h2>
                        <ul class="category-pages-nav">
                            <?php
                            foreach ($pages as $key => $post) : ?>
                                <?php if ($current_page == $post->ID) {
                                    $current_cat_page_index = $key;
                                    ?>
                            <li class="current_page">
                                    <?php echo $post->post_title; ?>
                            </li>
                                    <?php
                                } else {
                                    ?>
                            <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </ul>
                    </div>
            </div>
        </div>
        </header><!-- .entry-header -->

        <?php
        if ($current_cat_page_index > 0) {
            $prev_page = $pages[$current_cat_page_index - 1];
        }

        if ($current_cat_page_index + 1 < count($pages)) {
            $next_page = $pages[$current_cat_page_index + 1];
        }
    }
}
wp_reset_postdata();
