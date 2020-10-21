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
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.1 21st August 2019
 */

get_header();

flush();

while ( have_posts() ) :
    the_post();

    $show_title = get_post_meta(get_the_ID(), 'display-page-title', true);
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
                        
                        if(!empty($page_cats)){
                            $page_cat = $page_cats[0];
                            $current_page = get_the_ID();

                            $args = array(
                                'post_type' => 'page',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'page_category',
                                        'terms'    => $page_cat->term_id,
                                    ),
                                ),
                                'orderby' => 'menu_order',
                                'order' => 'ASC',
                            );

                            $pages = get_posts($args);

                            if(!empty($pages) && count($pages) > 1){

                                    $current_cat_page_index = 0;

                                    $is_cat_page = true;
                                    ?>
                                    <h2 class="category-pages-title"><?php echo $page_cat->name; ?></h2>

                                    <ul class="category-pages-nav">
                                        <?php
                                        foreach ( $pages as $key=>$post ) : ?>

                                            <?php if($current_page == $post->ID) {
                                                $current_cat_page_index = $key;
                                                ?>
                                                <li class="current_page"><?php echo $post->post_title; ?></li>
                                            <?php
                                            }
                                            else {
                                                ?>
                                                <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li>
                                                <?php
                                            }

                                        endforeach;
                                        ?>
                                    </ul>
                            <?php

                                if($current_cat_page_index > 0){
                                    $prev_page = $pages[$current_cat_page_index-1];
                                }

                                if($current_cat_page_index + 1 < count($pages)){
                                    $next_page = $pages[$current_cat_page_index+1];
                                }

                            } ?>
                        <?php
                        }

                        if($is_cat_page == false) {
                            ?>
                            <?php if ($show_title != 'no' && is_front_page() == false) { ?>

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
            <div class="nhsuk-grid-column-two-thirds page <?php echo nightingale_sidebar_location( 'sidebar-1' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">

                <?php
                if($is_cat_page) {
                    if ($show_title != 'no' && is_front_page() == false) {
                        the_title('<h1 class="entry-title">', '</h1>');

                    } ?>
                    <?php if (has_excerpt()) { ?>
                        <div class="intro">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php }
                }

                get_template_part( 'template-parts/content', 'page' );

                ?>

                <?php

                if($is_cat_page && (!empty($prev_page) || !empty($next_page))) { ?>
                    <div class="category-page-bottom-nav <?php if(!empty($prev_page)){ echo 'has-prev-page'; } ?> <?php if(!empty($prev_page)){ echo 'has-next-page'; } ?>">
                        <?php
                        if(!empty($prev_page)) {
                            ?>
                            <div class="category-page-bottom-nav-prev">
                                <a href="<?php echo get_permalink($prev_page->ID); ?>" class="prev-page-link">Previous page</a>
                                <div class="prev-page-title">
                                    <?php echo $prev_page->post_title; ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if(!empty($next_page)) { ?>
                            <div class="category-page-bottom-nav-next">
                                <a href="<?php echo get_permalink($next_page->ID); ?>" class="next-page-link">Next page</a>
                                <div class="prev-next-title">
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
                get_sidebar( 'page' );
                ?>
            </div>
        </div>
    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->

<?php
endwhile; // End of the loop.
flush();
get_footer();
?>
