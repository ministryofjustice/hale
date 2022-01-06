<?php
/**
 * Set the theme colors
 *
 * @package   Hale
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version   1.0, March 2021
 */

/**
 * Setup the colours for our theme.
 */
function hale_get_theme_colours() {
	return array(
		''       => esc_html__( 'Inherit site wide colour settings', 'hale' ),
		'0f0228' => esc_html__( 'Venus', 'hale' ),
		'143859' => esc_html__( 'Earth', 'hale' ),
		'336c83' => esc_html__( 'Uranus', 'hale' ),
		'0c223f' => esc_html__( 'Neptune', 'hale' ),
		'34393e' => esc_html__( 'Pluto', 'hale' ),
		'0b0c0c' => esc_html__( 'Eris', 'hale' )
	);
}

// -- Disable Custom Colors
add_action( 'after_setup_theme', 'hale_prefix_register_colors' );
/**
 * Make an array of colours we want to show.
 */
function hale_prefix_register_colors() {

	add_theme_support( 'disable-custom-colors' );
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'Neptune', 'hale' ),
				'slug'  => 'neptune',
			),
			array(
				'name'  => esc_html__( 'Uranus', 'hale' ),
				'slug'  => 'uranus',
			),
			array(
				'name'  => esc_html__( 'Eris', 'hale' ),
				'slug'  => 'eris',
			),
			array(
				'name'  => esc_html__( 'HMG', 'hale' ),
				'slug'  => 'gds',
			)
		)
	);
}
