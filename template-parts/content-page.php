<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021

 */
?>

	<?php do_action( 'hale_before_single_content' ); ?>

	<div class="hale-entry-content">
		<?php
		if ( function_exists( 'hale_clean_bad_content' ) ) {
            hale_clean_bad_content( true );
		}
		?>

		<?php do_action( 'page_after_content' ); ?>
	</div>
	<div class="govuk-clearfix"></div>

	<?php do_action( 'hale_after_single_content' ); ?>
