<?php
/**
 * The footernav for our theme
 * This is the template that displays the default navigation in the footer region
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

$menu_locations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php).
// This returns an array of menu locations ([LOCATION_NAME] = MENU_ID).
if ( has_nav_menu( 'footer-menu' ) ) { // Check to see if there is a footer menu assigned.
	$menu_id   = $menu_locations['footer-menu']; // Get the *footer-menu* menu ID.
	$menu_item = wp_get_nav_menu_items( $menu_id );
	if ( $menu_item ) { // Get the array of wp objects, the nav items for our queried location.
		?>
		<h2 class="govuk-visually-hidden">Support links</h2>

        <div class="hale-primary-footer-menu">
		<ul class="govuk-footer__inline-list">
			<?php
			foreach ( $menu_item as $nav_item ) {
				echo '
          <li class="govuk-footer__inline-list-item">
            <a class="govuk-footer__link" href="' . esc_url( $nav_item->url ) . '">' . esc_html( $nav_item->title ) . '</a>
          </li>';
			}
			// below div is a horrible hacky workaround to stop safari from jumping links all over the show on hover. As and when upstream library gets fixed, this div can come out.
			?>
		</ul>
        </div>
		<?php
	} //end if footer menu exists
} // end check to see if menu is assigned.
