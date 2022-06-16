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

    wp_enqueue_style('hale-gutenburg-style', hale_mix_asset('/css/style-gutenburg.min.css'));

    $browser_is_IE = (isset($_SERVER['HTTP_USER_AGENT']) && ( (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false ) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) ) );

    if (!$browser_is_IE) wp_enqueue_style('hale-custom-branding', hale_mix_asset('/css/custom-branding.min.css'));

    $t=time();
    $css_file_name = "/custom-colours.css?t=$t";
    $css_file_name_IE = "/custom-colours-ie.css?t=$t";

    if (is_ssl()) {
        //wp_get_upload_dir()["baseurl"] only returns http.
        $baseURL = str_replace('http://','https://',wp_get_upload_dir()["baseurl"]);
        if (!$browser_is_IE) wp_enqueue_style('hale-custom-colours', $baseURL . $css_file_name);
        wp_enqueue_style('hale-custom-colours-ie', $baseURL . $css_file_name_IE);
    } else {
        if (!$browser_is_IE) wp_enqueue_style('hale-custom-colours', wp_get_upload_dir()["baseurl"] . $css_file_name);
        wp_enqueue_style('hale-custom-colours-ie', wp_get_upload_dir()["baseurl"] . $css_file_name_IE);
    }
}

add_action( 'enqueue_block_editor_assets', 'hale_gutenberg_editor_styles', 100 );


