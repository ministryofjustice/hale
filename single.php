<?php
/**
 * The template for displaying all single post types (inc flexible post types)
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

				$core_cpts = [
					'post',
					'page',
					'attachment',
					'job',
					'news',
					'document',
					'decision'
				];

				$post_type = get_post_type();

				//if not in array post is a ACF generated CPT
				if(!in_array($post_type, $core_cpts)){
					get_template_part( 'template-parts/flexible-cpts/single');
				}
				else {
					get_template_part( 'template-parts/content', $post_type );
				}

			endwhile; // End of the loop.
			?>

		</div>

	</div><!-- #primary -->

<?php
get_footer();