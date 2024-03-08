<?php
/**
 * The Top Navigation Menu for our theme
 *
 * This is the template that displays the top navigation region.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

$show_header_menu = get_theme_mod('show_header_menu', 'yes');
if ($show_header_menu == 'yes') {
    $show_more_button = get_theme_mod('show_header_menu_more_button', 'yes');
    if ($show_more_button == 'yes') {
        $more_text = __("More","hale");
    } else {
        $more_text = "None";
    }

    $menu_locations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php).

    $topmenu_args = array(
        'menu' => 'main-menu',
        'menu_class' => 'govuk-header__navigation-list',
        'menu_id' => 'menu-menu-top-menu',
        'container' => false,
        'container_class' => '',
        'container_id' => '',
        'fallback_cb' => '',
        'before' => '',
        'after' => '',
        'link_before' => '<span>',
        'link_after' => '</span>',
        'echo' => true,
        'depth' => 2,
        'walker' => '',
        'theme_location' => 'main-menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'item_spacing' => 'preserve',
    );
    ?>
    <nav class="hale-header__topnav govuk-header__navigation" id="header-navigation" role="navigation" aria-label="Primary navigation" data-more-text="<?php echo $more_text ?>">
        <button type="button" class="govuk-header__menu-button govuk-js-header-toggle" aria-controls="menu-menu-top-menu" aria-label="Show or hide navigation menu" hidden>Menu</button>
        <?php
        wp_nav_menu($topmenu_args);
        ?>
    </nav>
<?php }
