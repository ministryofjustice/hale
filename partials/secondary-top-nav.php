<?php
/**
 * The Secondary Top Navigation Menu for our theme
 *
 */

if (has_nav_menu('secondary-top-menu')) {
    $menu_args = array(
        'menu_id' => 'secondary-top-menu',
        'container' => false,
        'depth' => 1,
        'theme_location' => 'secondary-top-menu'
    );
    ?>
    <nav class="secondary-top-nav" id="secondary-top-navigation" role="navigation" aria-label="Seconday Top navigation">
        <div class="govuk-width-container">
            <?php
            wp_nav_menu($menu_args);
            ?>
        </div>
    </nav>
<?php } ?>
