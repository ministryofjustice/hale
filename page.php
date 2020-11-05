<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 1.0
 */

get_header();

flush();

// Check if editor has turned off the sidebar
$display_sidebar = get_post_meta($post->ID, 'hale_metabox_page_sidebar', true);

// If it's a new page, set sidebar to "on" by default
if (empty($display_sidebar)) {
    $display_sidebar = 'yes';
}

while (have_posts()) :
    the_post();
    ?>

<div id="primary">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header page-header" style="">
            <div class="nhsuk-width-container">
                <div class="nhsuk-grid-row">
                    <div class="nhsuk-grid-column-two-thirds">

                        <?php

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
                                <?php

                                if ($current_cat_page_index > 0) {
                                    $prev_page = $pages[$current_cat_page_index - 1];
                                }

                                if ($current_cat_page_index + 1 < count($pages)) {
                                    $next_page = $pages[$current_cat_page_index + 1];
                                }

                                wp_reset_postdata();
                            } ?>
                            <?php
                        }

                        if ($is_cat_page == false) {
                            ?>
                            <?php if (is_front_page() == false) { ?>
                                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <?php } ?>
                            <?php if (has_excerpt()) { ?>
                                <div class="intro">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </header><!-- .entry-header -->

        <div class="nhsuk-grid-row">

            <div class="nhsuk-grid-column-two-thirds page <?php

            // If sidebar is not on, apply CSS class to span full width column
            $full_column_class = ($display_sidebar != 'yes' ) ? 'nhsuk-grid-column-full' : '';

            echo nightingale_sidebar_location('sidebar-1'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo ' ' . $full_column_class; ?>"><!-- main column -->

                <?php
                if ($is_cat_page) {

                    if (is_front_page() == false) {
                        the_title('<h1 class="entry-title hale-heading-l">', '</h1>');
                    }

                    if (has_excerpt()) { ?>
                        <div class="intro">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php }
                }

                get_template_part('template-parts/content', 'page');

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
                ?>
            </div>
            <div class="nhsuk-grid__item nhsuk-grid-column-one-third">

            <?php

            // Display theme sidebar based on editor page metabox setting
            if ($display_sidebar === 'yes') {
                get_sidebar('page');
            }
            ?>

            </div>
        </div>
    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->

    <?php
endwhile; // End of the loop.
flush();

get_footer();
