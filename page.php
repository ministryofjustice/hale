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
                        <?php if($show_title != 'no' && is_front_page() == false){ ?>

                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <?php } ?>
                        <?php if(has_excerpt()){ ?>
                            <div class="intro">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </header><!-- .entry-header -->
        <div class="nhsuk-grid-row">
            <div class="nhsuk-grid-column-two-thirds page <?php echo nightingale_sidebar_location( 'sidebar-1' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
                <?php

                    get_template_part( 'template-parts/content', 'page' );
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

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
