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

/**
 * Patch to prevent black PDF backgrounds.
 *
 * https://core.trac.wordpress.org/ticket/45982
 */
require_once ABSPATH . 'wp-includes/class-wp-image-editor.php';
require_once ABSPATH . 'wp-includes/class-wp-image-editor-imagick.php';

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
final class ExtendedWpImageEditorImagick extends WP_Image_Editor_Imagick
{
    /**
     * Add properties to the image produced by Ghostscript to prevent black PDF backgrounds.
     *
     * @return true|WP_error
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    protected function pdf_load_source()
    {
        $loaded = parent::pdf_load_source();

        try {
            $this->image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
            $this->image->setBackgroundColor('#ffffff');
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }

        return $loaded;
    }
}

/**
 * Filters the list of image editing library classes to prevent black PDF backgrounds.
 *
 * @param array $editors
 * @return array
 *
 * 70 priority to run after eww image plugin
 */

add_filter('wp_image_editors', function (array $editors): array {
    array_unshift($editors, ExtendedWpImageEditorImagick::class);

    return $editors;
}, 70);
