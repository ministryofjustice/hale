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
	<?php
		$full_width_heading = hale_get_acf_field_status('full_width_heading');
		$show_toc_on_single_view = hale_get_acf_field_status('show_toc_on_single_view');
		$number_headings = hale_get_acf_field_status('number_headings');
		$print_control = hale_get_acf_field_status('print_button');

		if ($full_width_heading && !is_singular('hearing')) {
			get_template_part( 'template-parts/flexible-cpts/full-width-heading' );
		}

		// Gets the Table of Contents for the page
		if (function_exists('hale_table_of_contents') && $show_toc_on_single_view) {
			$toc = hale_table_of_contents($number_headings, $print_control);
			echo "<div id='toc' class='govuk-grid-column-one-third'>$toc</div>";
		} elseif (function_exists('hale_print_page_button') && $print_control) {
			$print_button = hale_print_page_button($print_control);
			echo "<div id='solo-print' class='govuk-grid-column-one-third'>$print_button</div>";
		}
		get_template_part('partials/print-copyright-page');
		?>
	<div id="primary" class="govuk-grid-column-two-thirds">
		<div class="single">
			<?php
			while ( have_posts() ) :
				the_post();

				$allow_doc_upload_status = hale_get_acf_field_status('allow_document_upload');
				
				if ($allow_doc_upload_status === true) {
					get_template_part( 'template-parts/content', 'documents', ['full-width-heading' => $full_width_heading] );
				} 
				elseif ( is_singular('hearing') ) {
					get_template_part( 'template-parts/hearing-list/hearing-single'); //full-width-heading not used as per line 21
				}
				else {
					get_template_part( 'template-parts/flexible-cpts/single', false, ['full-width-heading' => $full_width_heading] );
				}

			endwhile;
			?>

		</div>

	</div><!-- #primary -->

<?php
get_footer();