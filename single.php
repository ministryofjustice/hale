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

				$allow_doc_upload_status = hale_get_acf_field_status('allow_document_upload');
				
				if ($allow_doc_upload_status === true) {
					get_template_part( 'template-parts/content', 'documents' );
				} else {
					get_template_part( 'template-parts/content', $post_type );
				}

			endwhile;
			?>

		</div>

	</div><!-- #primary -->

<?php
get_footer();