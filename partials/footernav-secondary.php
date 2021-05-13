<?php
/**
 * The secondary footernav
 * This is the template that displays the secondary navigation in the footer region
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

 // Get our registered menu (see functions.php)
$menu_locations = get_nav_menu_locations();

if ( has_nav_menu( 'secondary-footer-menu' ) ) {

	$menu_id   = $menu_locations['secondary-footer-menu'];
	$menu_item = wp_get_nav_menu_items( $menu_id );

    // Get the array of wp objects, the nav items for our queried location.
	if ( $menu_item ) {
		?>
		<h2 class="govuk-visually-hidden">Secondary support links</h2>
        <div class="hale-secondary-footer-menu">
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
