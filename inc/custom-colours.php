<?php
/**
 * Set the theme colors
 *
 * @package   Nightingale-2-0
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version   1.1 21st August 2019
 */

/**
 * Setup the colours for our theme.
 */
function hale_get_theme_colours() {
	return array(
		''       => esc_html__( 'Inherit site wide colour settings', 'hale' ),
		'005eb8' => esc_html__( 'Blue', 'hale' ),
        '336c83' => esc_html__( 'Teal', 'hale' ),
		'00a19a' => esc_html__( 'Light Teal', 'hale' ),
		'0c223f' => esc_html__( 'Dark Blue', 'hale' )
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
				'name'  => esc_html__( 'Blue', 'hale' ),
				'slug'  => 'blue',
				'color' => '#005eb8',
			),
            array(
                'name'  => esc_html__( 'Teal', 'hale' ),
                'slug'  => 'teal',
                'color' => '#336c83',
            ),
            array(
                'name'  => esc_html__( 'Light Teal', 'hale' ),
                'slug'  => 'light_teal',
                'color' => '#00a19a',
            ),
			array(
				'name'  => esc_html__( 'Dark Blue', 'hale' ),
				'slug'  => 'dark_blue',
				'color' => '#0c223f',
			)
		)
	);
}

/**
 * Get the colors formatted for use with Iris, Automattic's color picker.
 */
function nightingale_output_the_colors() {

	// get the colors.
	$color_palette = current( (array) get_theme_support( 'editor-color-palette' ) );

	// bail if there aren't any colors found.
	if ( ! $color_palette ) {
		return;
	}

	// output begins.
	ob_start();

	// output the names in a string.
	echo '[';
	foreach ( $color_palette as $color ) {
		echo "'" . esc_attr( $color['color'] ) . "', ";
	}
	echo ']';

	return ob_get_clean();

}

/**
 * Get the colors formatted for use with TinyMCE.
 */
function nightingale_output_tinymce_colors() {

	// get the colors.
	$color_palette = current( (array) get_theme_support( 'editor-color-palette' ) );

	// bail if there aren't any colors found.
	if ( ! $color_palette ) {
		return;
	}

	// output begins.
	ob_start();

	// output the names in a string.
	echo '
';
	foreach ( $color_palette as $color ) {
		$str = ltrim( $color['color'], '#' );
		echo "'" . esc_attr( $str ) . "', '" . esc_attr( $color['slug'] ) . "',
		";
	}
	echo '
';

	return ob_get_clean();

}

/**
 * Put the array of colours into the TinyMCE editor.
 *
 * @param array $init the array of colours coming in.
 *
 * @return array $init the formatted array returned back.
 */
function nightingale_mce4_options( $init ) {

	$custom_colours = nightingale_output_tinymce_colors();

	// build colour grid default+custom colors.
	$init['textcolor_map'] = '[' . $custom_colours . ']';

	// change the number of rows in the grid if the number of colors changes.
	// 8 swatches per row.
	$init['textcolor_rows'] = 3;

	return $init;
}

add_filter( 'tiny_mce_before_init', 'nightingale_mce4_options' );
