<?php
/**
 * The Top Navigation Menu for our theme
 *
 * This is the template that displays the top navigation region.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.0 13th January 2020
 */

$show_header_menu = get_theme_mod('show_header_menu', 'yes');
if ($show_header_menu == 'yes') {
    $menu_locations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php).

    $topmenu_args = array(
        'menu' => 'main-menu',
        'menu_class' => 'nhsuk-header__navigation-list',
        'menu_id' => 'menu-menu-top-menu',
        'container' => false,
        'container_class' => '',
        'container_id' => '',
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'echo' => true,
        'depth' => 1,
        'walker' => '',
        'theme_location' => 'main-menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'item_spacing' => 'preserve',
    );
    ?>
    <nav class="nhsuk-header__navigation" id="header-navigation" role="navigation" aria-label="Primary navigation"
         aria-labelledby="label-navigation">
        <div class="nhsuk-width-container">
            <?php
            wp_nav_menu($topmenu_args);
            ?>
        </div>
    </nav>
<?php }
