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
			if ( have_posts() ) :
				?>

				<div class="govuk-grid-row">

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;
					?>

				</div>

				<?php

				hale_archive_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
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
