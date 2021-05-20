<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021

 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}

if ( ! hale_show_sidebar() ) {
	return;
}
?>
<div class="govuk-grid-column-one-third">
	<aside id="secondary" class="widget-area govuk-width-container">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</aside><!-- #secondary -->
</div>
