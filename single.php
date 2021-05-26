<?php
/**
 * The template for displaying all single posts
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
		<div class="
		<?php
		if ( hale_show_sidebar() ) :
			echo hale_sidebar_location( 'sidebar-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		endif;
		?>
		single">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );
				hale_get_prev_next();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</div>
		<?php
		if ( hale_show_sidebar() ) :
			get_sidebar( 'blog' );
		endif;
		?>

	</div><!-- #primary -->

<?php
get_footer();
