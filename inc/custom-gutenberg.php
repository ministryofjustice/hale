<?php
/**
 * Enqueue Gutenberg block editor style
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 **/

/**
 * Line up the admin editor css
 */
function hale_gutenberg_editor_styles() {

    $screen = get_current_screen();
    //Only apply to edit backend pages
    if ($screen->base == "post") {
        wp_enqueue_style('hale-gutenburg-style', hale_mix_asset('/css/style-gutenburg.min.css'));
        wp_enqueue_style('hale-editor-branding', hale_mix_asset('/css/editor-branding.min.css'));

        $t = time();
        $css_file_name = "/custom-colours.css?t=$t";

        if (is_ssl()) {
            //wp_get_upload_dir()["baseurl"] only returns http.
            $baseURL = str_replace('http://', 'https://', wp_get_upload_dir()["baseurl"]);
            wp_enqueue_style('hale-custom-colours', $baseURL . $css_file_name);
        } else {
            wp_enqueue_style('hale-custom-colours', wp_get_upload_dir()["baseurl"] . $css_file_name);
        }
    }
}

add_action( 'enqueue_block_editor_assets', 'hale_gutenberg_editor_styles', 100 );


