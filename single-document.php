<?php
/**
 * The template for displaying all single documents
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

get_header();
?>

	<div id="primary" class="govuk-grid-column-two-thirds">
		<div class="single">
			<?php
			while ( have_posts() ) :
				the_post();

                get_template_part( 'template-parts/content', 'documents' );

			endwhile; // End of the loop.
			?>

		</div>

	</div><!-- #primary -->

<?php
get_footer();
