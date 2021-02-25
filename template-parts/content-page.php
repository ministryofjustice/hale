<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Hale
 * @theme Hale with GDS styles
 * @Crown Copyright
 * @Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021

 */
?>

	<?php do_action( 'nightingale_before_single_content' ); ?>

	<div class="jotw-entry-content">
		<?php
		if ( function_exists( 'nightingale_clean_bad_content' ) ) {
			nightingale_clean_bad_content( true );
		}
		?>

		<?php do_action( 'page_after_content' ); ?>
	</div>
	<div class="govuk-clearfix"></div>

	<?php do_action( 'nightingale_after_single_content' ); ?>
