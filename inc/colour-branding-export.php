<?php 

/**
 * Export Colour Branding Class
 *
 * @param WP_Customize_Control Customizer object.
*/

add_action( 'customize_register', 'hale_export_color_customize_register' );

function hale_export_color_customize_register( $wp_customize ) {

	class Hale_Export_Color_Brand_Control extends WP_Customize_Control {

		/**
		* Render the control's content.
		*/
		public function render_content() {
		?>
			<hr />
			<div class="customize-control customize-control-text">
			<label class="customize-control-title">Export site colour settings</label>
			<span class="description customize-control-description">Export current colour settings as an JSON file.</span>
			<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>?action=export_color_branding_json" method="POST">
			<button type="submit" class="button">Download</button>
			<?php wp_nonce_field( 'export_color_branding_json', 'hale_export_colour_branding_nonce' ); ?>
			</form>
			</div>
		<?php
		}
	}
}

add_action( 'admin_post_export_color_branding_json', 'hale_init_file_export' );

/**
 * Get current Hale colour branding and format for JSON
 */
function hale_get_current_colour_branding() {

	$colour_array = hale_get_colours();

	// Declare blank array to be used in the for loop
	$colour_key_value_pairs = array();

	// Build the JSON structure from colours array
	for( $i=0; $i < count($colour_array); $i++) {
		$colour_id = hale_get_colour_id($colour_array[$i]);
		$colour_default = hale_get_colour_default($colour_array[$i]);
		$theme_mod = get_theme_mod($colour_id, $colour_default);
		$colour_key_value_pairs[] .= $colour_id . '"' .':'. '"' . $theme_mod;
	}

	// Encode into JSON format
	$colour_array_json = stripslashes(json_encode(
		$colour_key_value_pairs,
		JSON_PRETTY_PRINT | 
		JSON_INVALID_UTF8_SUBSTITUTE 
	));

	// Further formatting to match structure expected by import - creating JSON object rather than list
	$search = array("[", "]");
	$replace = array("{", "}");
	$colour_array_json = str_replace($search, $replace, $colour_array_json);

	return $colour_array_json;
}

/**
 * Initiate and set download of colour branding file
 */
function hale_init_file_export() {

	status_header(200);

	// Verify request is ligit
	if ( ! wp_verify_nonce(
		$_REQUEST['hale_export_colour_branding_nonce'],
		'export_color_branding_json'
		)
	) {
		return;
	}

	$charset = get_option( 'blog_charset' );
	$theme = get_stylesheet();
	$time_stamp = current_time( 'YmdHis', $gmt = 0 );
	$site_id = get_current_blog_id();

	// Set the download headers
	// Example file output "hale-5-colour-brand-export-20220517230228.json"
	header( 'Content-disposition: attachment; filename=' . $theme . '-' . $site_id . '-' . 'colour-brand-export' . '-' . $time_stamp . '.json' );
	header( 'Content-Type: application/octet-stream; charset=' . $charset );

	// Export data to file
	echo hale_get_current_colour_branding();

	// Start download
	die();
}
