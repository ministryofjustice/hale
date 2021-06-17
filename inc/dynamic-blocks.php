<?php
/**
 * Style core blocks in the Hale Way
 *
 * @package   Hale
 * @copyright Ministry Of Justice
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version   2.0
 */


add_filter( 'render_block', 'hale_filter_blocks', 10, 2 );


/**
 * Filter the blocks through our own method.
 *
 * @param array $block_content the contents of the block itself.
 * @param array $block         information about block being modified.
 *
 * @return function hale_block_renderer to send back the modified block content.
 */
function hale_filter_blocks( $block_content, $block ) {

	if ( is_admin() ) {
		return;
	}

	if ( 'core/file' !== $block['blockName'] ) {
		return $block_content;
	}

	return hale_block_renderer( $block['blockName'], $block['attrs'] );
}

/**
 * Render the modified block with our own method.
 *
 * @param string $name       the name of the block itself.
 * @param array  $attributes information about block being modified.
 *
 * @return string $object.
 */
function hale_block_renderer( $name, $attributes ) {

	// change template name slash to scores.
	$template_name = str_replace( '/', '-', $name );

	// Set query vars so they are accessible to the template part.
	foreach ( $attributes as $attribute_name => $attribute_value ) {
		set_query_var( $name . '/' . $attribute_name, $attribute_value );
	}

    $file = get_attached_file($attributes["id"]);
    $filesize = file_exists($file) ? ", " . size_format(filesize($file)) : null;
    $filename = basename(get_the_title($attributes["id"]));
    $filetype = wp_check_filetype($attributes["href"]);

    $output = '<i class="fas fa-file-download"></i> ';
    $output .= '<a href="' . $attributes["href"] . '">' . $filename .'</a>';
    $output .= ' (';
    $output .= strtoupper($filetype["ext"]);
	$output .=  $filesize;
    $output .= ')';

	// Load the template part in an output buffer.
	ob_start();
	get_template_part( "template-parts/{$template_name}" );
	$output .= ob_get_clean();

	// Clear the query vars so they don't bleed into subsequent instances of the same block type.
	foreach ( $attributes as $attribute_name => $attribute_value ) {
		set_query_var( $name . '/' . $attribute_name, null );
	}

	return $output;
}
