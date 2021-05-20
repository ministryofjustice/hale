<?php
/**
 * Enqueue Gutenberg block editor style
 *
 * @package Nightingale-2-0
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.1 21st August 2019
 */

/**
 * Line up the admin editor css
 */
function hale_gutenberg_editor_styles() {

    wp_enqueue_style('hale-gutenburg-style', hale_mix_asset('/css/style-gutenburg.min.css'));
}

add_action( 'enqueue_block_editor_assets', 'hale_gutenberg_editor_styles', 100 );


