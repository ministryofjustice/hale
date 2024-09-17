<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * Theme Hale with GDS styles
 * © Crown Copyright
 * @version 4.12 Sept 2024
 */

get_header();

$sidebar = hale_show_sidebar();

?>
<div id="primary" class="govuk-grid-column-two-thirds">

    <?php
    // Display archive title and description
    the_archive_title( '<h1 class="govuk-heading-l">', '</h1>' );
    the_archive_description( '<div class="archive-description">', '</div>' );
    ?>

    <div class="<?php if ( $sidebar ) : echo hale_sidebar_location( 'sidebar-2' ); endif; ?> archive">

        <?php
        // Loop through all archived posts
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();

                // Load the template part for the archive post
                get_template_part( 'template-parts/content', 'archive-part' );

            endwhile;
        else : ?>
            <p><?php _e( 'No articles found', 'hale' ); ?></p>
        <?php endif; ?>

    </div>

    <?php
    // Display the sidebar if applicable
    if ( $sidebar ) :
        get_sidebar( 'blog' );
    endif;
    ?>

</div><!-- #primary -->

<?php
get_footer();

