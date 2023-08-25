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
    $menu_locations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php).

    $main_menu_count = 0;
    foreach(wp_get_nav_menu_items($menu_locations['main-menu']) as $item) {
        if ($item->menu_item_parent == 0) {
            $main_menu_count++;
        }
    }
    if ($main_menu_count >= 6) {
        $main_menu_count_data = "many";
    } else {
        $main_menu_count_data = "few";
    }

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
        'link_before' => '<div><span>',
        'link_after' => '</span></div>',
        'echo' => true,
        'depth' => 2,
        'walker' => '',
        'theme_location' => 'main-menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-menu-count="'.$main_menu_count.'">%3$s</ul>',
        'item_spacing' => 'preserve',
    );

    ?>
    
    <nav class="hale-header__topnav govuk-header__navigation" id="header-navigation" role="navigation" aria-label="Primary navigation">
        <button type="button" class="govuk-header__menu-button govuk-js-header-toggle" aria-controls="menu-menu-top-menu" aria-label="Show or hide navigation menu">Menu</button>
        <?php
        wp_nav_menu($topmenu_args);
        ?>
    </nav>
<?php }
