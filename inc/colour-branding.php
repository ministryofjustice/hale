<?php

/************** 
 * This file creates a CSS file with the variables that are set in the Customizer
 * This also has the colour bar style and the invert logo focus style
**************/

// JSON import code
require get_template_directory() . '/inc/colour-branding-import.php';

// This code creates the CSS files that are used to turn the colour options into a stylesheet
function hale_generate_custom_colours() {
	$upload_file_path = wp_get_upload_dir()["basedir"]; //for PHP-created CSS file
	$upload_file_path_exists = is_dir($upload_file_path);
	$dark_background_css_file = get_template_directory().'/dist/css/dark-background.min.css';
	$dark_background_css_file_exists = file_exists($dark_background_css_file);
	$colour_array = hale_get_colours();
	$custom_colours_set = ! get_theme_mod("gds_style_tickbox");
	$logo_focus_invert = get_theme_mod("logo_focus_invert_tickbox");

	if ($custom_colours_set) {
		$jason = hale_get_colours_from_jason();
	} else {
		$jason = false;
	}

	if ($upload_file_path_exists) {

		//Create colour array with values from get_theme_mod for use in following for loops
		$colour_value = array();
		if ($custom_colours_set) {
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$colour_options = hale_get_colour_options($colour_array[$i]);
				$colour_value[$i] = array(
										"id"=>$colour_id,
										"value"=>get_theme_mod($colour_id,$colour_default),
										"options"=>$colour_options
									);
			}
		}

		if ($jason) { // JSON file
			$css = ":root {";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$jason_colour = $jason[$colour_id];
				$css .= "--$colour_id:$jason_colour;";
			}
			$css .= "}";
		} elseif ($custom_colours_set) { //custom scheme

			$custom_colours_found = 0;
			$unset_colours = [];

			$css = ":root {";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$theme_mod = $colour_value[$i]["value"];
				if (!empty($theme_mod) ) {
					$custom_colours_found++;
					$css .= "--$colour_id:$theme_mod;";
				} else {
					$css .= "--$colour_id:$colour_default;";
					$unset_colours[] = $colour_id;
				}
			}
			$css .= "}";

			/********
			 * This next bit emails warnings about unset colours
			 */
			require_once get_template_directory() . '/inc/colour-email-warning.php';
			emailWarning($unset_colours,$custom_colours_found,$i,"colour-branding.php");

			// Text on a custom dark background
			$background_css = "";
			for($i=0;$i<count($colour_array);$i++) {
				// Here we are checking for colours which are the "generic colours" which can be set as text or background for anything
				// This is part of deciding whether to apply dark background styles to such blocks
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_options = hale_get_colour_options($colour_array[$i]);
				$colour_to_use = get_colour_to_use($jason, $colour_id, $custom_colours_set, $colour_value[$i], $colour_default);
				if ($dark_background_css_file_exists && $colour_options == "palette-colour") {
					$background_css .= apply_background_styles($colour_id, $colour_to_use, $dark_background_css_file);
				}
			}
			$css .= $background_css;

		} else { //GDS Scheme
			$colour_bar_colour = get_theme_mod('colour_bar','#1D70B8');
			$css = ":root {";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$colour_options = hale_get_colour_options($colour_array[$i]);
				if ($colour_options == "brand-colour") $colour_default = $colour_bar_colour;
				$css .= "--$colour_id:$colour_default;";
			}
			$css .= "}";
			if (!empty($colour_bar_colour) && strcasecmp($colour_bar_colour, "#FFF") != 0 && strcasecmp($colour_bar_colour, "#FFFFFF") != 0) {
				$colour_bar_style  = "@media only screen {";
				$colour_bar_style .= 	".hale-table-of-contents__item--current {";
				$colour_bar_style .= 		"border-left-color: $colour_bar_colour;";
				$colour_bar_style .= 	"}";
				$colour_bar_style .= 	".govuk-header__container {";
				$colour_bar_style .= 		"border-bottom-color: $colour_bar_colour!important;";
				$colour_bar_style .= 	"}";
				$colour_bar_style .= "}";
				$colour_bar_style .= ".govuk-header {";
				$colour_bar_style .= 	"border-bottom-width: unset!important;";
				$colour_bar_style .= 	"margin-bottom: 7px;";
				$colour_bar_style .= "}";
				$css .= $colour_bar_style;
			} else {
				$colour_bar_style  = ".govuk-header__container {";
				$colour_bar_style .= 	"border-bottom: none!important;";
				$colour_bar_style .= "}";
				$css .= $colour_bar_style;
			}
			// Text on a custom dark background
			$background_css = apply_GDS_background_styles($dark_background_css_file);
			$css .= $background_css;
		}
		if (!$custom_colours_set || $logo_focus_invert) {
			$logo_focus_invert_style  = ".govuk-header a:focus img {";
			$logo_focus_invert_style .= 	"filter: invert(1) hue-rotate(180deg);";
			$logo_focus_invert_style .= "}";
			$css .= $logo_focus_invert_style;
		}

		$css_file = fopen($upload_file_path."/temp-colours.css", "w");
		fwrite($css_file, $css);
		fclose($css_file);
	}

	if (get_theme_mod("customizer_setting_json")) {
		// Delete the file, now it has been used
		// unlink() and wp_delete_file() unsuitable here as they do not remove the file from the list of files
		// This still only removes the file from the list of files on page refresh
		wp_delete_attachment(
			attachment_url_to_postid(
				get_theme_mod("customizer_setting_json")),
				true
			);
		//sets the json file to nothing so individual colours can be set
		remove_theme_mod("customizer_setting_json");
	}

}

function get_colour_to_use($jason, $colour_id, $custom_colours_set, $colour_value, $colour_default) {
	if ($jason) { //JSON file uploaded
		$colour_to_use = $jason[$colour_id];
	} elseif ($custom_colours_set) { //custom colours set
		$colour_to_use = $colour_value["value"];
	} else { //GDS colours
		$colour_bar_colour = get_theme_mod('colour_bar','#1D70B8');
		if ($colour_options == "brand-colour") $colour_default = $colour_bar_colour;
		$colour_to_use = $colour_default;
	}
	if (empty($colour_to_use)) $colour_to_use = $colour_default;

	return $colour_to_use;
}

function apply_GDS_background_styles($dark_background_css_file) {
	// We know the preset backgrounds for GDS, so this is hard-coded

	$complex_background_code = file_get_contents($dark_background_css_file);

	$css = "";

	// GDS backgrounds are:
	//// Blue (#1d70b8)
	$css .= str_replace("has-replace_replace-background-color","has-generic-palette-1-background-color",$complex_background_code);
	//// Pink (#f499be)
	//// Not needed - it is light enough
	//// Orange (#f47738)
	//// Not needed - it is light enough
	//// Green (#00703c)
	$css .= str_replace("has-replace_replace-background-color","has-generic-palette-4-background-color",$complex_background_code);

	return $css;
}

function apply_background_styles($colour_id, $colour_to_use, $dark_background_css_file) {
	// Only called for non-GDS sites
	// Code from https://stackoverflow.com/questions/1331591/given-a-background-color-black-or-white-text

	$complex_background_code = file_get_contents($dark_background_css_file);

	$dark = false; // Assume light
	$colour_to_use = strtoupper($colour_to_use); // for regex check

	// Convert 3 character codes to 6 character codes
	if (preg_match('/^#?([A-F0-9]{3})$/', $colour_to_use)) {
		$array = str_split($colour_to_use);
		$colour_to_use = $array[0].$array[1].$array[1].$array[2].$array[2].$array[3].$array[3];
	}
	if (preg_match('/^#?([A-F0-9]{6})$/', $colour_to_use)) {
		// RGB for the colour we are checking
		$R1 = hexdec(substr($colour_to_use, 1, 2));
		$G1 = hexdec(substr($colour_to_use, 3, 2));
		$B1 = hexdec(substr($colour_to_use, 5, 2));

		// RGB for black
		$blackColour = "#000000"; // Don't use GDS black - this is just to check the colour against
		$R2BlackColour = hexdec(substr($blackColour, 1, 2));
		$G2BlackColour = hexdec(substr($blackColour, 3, 2));
		$B2BlackColour = hexdec(substr($blackColour, 5, 2));

		// Calc contrast ratio
		$L1 = 0.2126 * pow($R1 / 255, 2.2) + 0.7152 * pow($G1 / 255, 2.2) + 0.0722 * pow($B1 / 255, 2.2);
		$L2 = 0.2126 * pow($R2BlackColour / 255, 2.2) + 0.7152 * pow($G2BlackColour / 255, 2.2) + 0.0722 * pow($B2BlackColour / 255, 2.2);

		$contrastRatio = 0;
		if ($L1 > $L2) {
			$contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
		} else {
			$contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
		}

		// If contrast is less than 5, background is light
		if ($contrastRatio < 5) {
			$dark = true;
		}
	}

	if ($dark) {
		// The background is dark, so we return the CSS which applies the CSS for dark backgrounds.
		return str_replace("has-replace_replace-background-color","has-$colour_id-background-color",$complex_background_code);
	}

	return "";
}
