<?php

/**
 * Turn off block editor features that Hale doesn't use.
 *
 * @package Hale
 */

/**
 * Turn off the Font Library, and hover and responsive styles, in the editor settings.
 *
 * @param array $settings Block editor settings.
 *
 * @return array
 */
function hale_disable_editor_features($settings)
{
    // Disable font library functionality in the block editor settings.
    $settings['fontLibraryEnabled'] = false;

    // Disable hover and responsive styles (WP 7.1 block states).
    // Hides the Hover/Focus/Active control in the block card (Button and Navigation Link only).
    $settings['blockStatesEditingEnabled'] = false;
    // Hides "Responsive styles" in the View menu, so Tablet and Mobile only preview.
    $settings['responsiveEditingEnabled'] = false;

    return $settings;
}

add_filter('block_editor_settings_all', 'hale_disable_editor_features');

// Don't render hover and responsive styles (WP 7.1 block states) saved in block attributes.
// The editor controls are turned off in hale_disable_editor_features().
remove_filter('render_block', 'wp_render_block_states_support');

/**
 * Remove the Appearance > Fonts menu (the Font Library page).
 * The URL is still accessible to users who can edit theme options.
 */
function hale_remove_font_library_menu()
{
    remove_submenu_page('themes.php', 'font-library.php');
}

add_action('admin_menu', 'hale_remove_font_library_menu');
