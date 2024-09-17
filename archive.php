<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

get_header();

$sidebar = hale_show_sidebar();

?>
	<div id="primary" class="govuk-grid-column-two-thirds">
    <?php
    the_archive_title( '<h1 class="govuk-heading-l">', '</h1>' );
    the_archive_description( '<div class="archive-description">', '</div>' );
    ?>

		<div class="
		<?php
		if ( $sidebar ) :
			echo hale_sidebar_location( 'sidebar-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		endif;
		?>
		archive">

			<?php

			// Loop through all the archived posts and display
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					
					// Single post part and components
					get_template_part( 'template-parts/content', 'archive-part' );
				}
			} else { ?>
				<p><?php _e('No articles found', 'hale'); ?></p>
				<?php
			}

			?>

		</div>

		<?php
		if ( $sidebar ) :
			get_sidebar( 'blog' );
		endif;
		?>
	</div><!-- #primary -->

<?php

get_footer();
