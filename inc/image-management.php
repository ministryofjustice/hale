<?php

/**
 * Optimising and altering images across the theme
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

// Add new image size to theme, 1366x683 pixels, aspect ratio 2:1, crop = true
add_image_size( 'hero', 1366, 683, true );

add_filter( 'image_size_names_choose', 'hale_add_custom_image_size_name' );
/**
 * Add new image sizes to list of default image sizes so they can be
 * accessed in JS, blocks and wp_prepare_attachment_for_js().
 *
 * @param  array $size_names An array containing default image sizes and their names.
 * @return array $size_names Merged array containing new image sizes and their names.
 */
function hale_add_custom_image_size_name( $size_names ) {

    // Add new image size name to array.
    $new_size_names = [
        'hero' => esc_html__( 'Hero banner', 'hale' ),
    ];

    // Combine the two arrays.
    $size_names = array_merge( $new_size_names, $size_names );

    return $size_names;
}
