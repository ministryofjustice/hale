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
}

add_action( 'enqueue_block_editor_assets', 'hale_gutenberg_editor_styles', 100 );


