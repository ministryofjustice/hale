<?php

/************** 
 * This file creates two CSS files
 * One with the variables that are set in the Customiser, this also has the colour bar style and the invert logo focus style
 * One for IE which copies the entire main CSS file and replaces the variables with the colours
 * SVG support however means that the IE CSS file is needed by every browser at the moment - this might change in the future
 * IE doesn't support the filter attribute, so the logo focus filter is only appended to the non-IE CSS file
**************/

// JSON import code
require get_template_directory() . '/inc/colour-branding-import.php';

// This code creates the CSS files that are used to turn the colour options into a stylesheet
function hale_generate_custom_colours() {
	$upload_file_path = wp_get_upload_dir()["basedir"]; //for PHP-created CSS file
	$upload_file_path_exists = is_dir($upload_file_path);
	$main_css_file = get_template_directory().'/dist/css/custom-branding.min.css';
	$main_css_file_exists = file_exists($main_css_file);
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
			$css = ":root {\n";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$jason_colour = $jason[$colour_id];
				$css .= "\t--$colour_id:$jason_colour;\n";
			}
			$css .= "}\n";
		} elseif ($custom_colours_set) { //custom scheme
			$css = ":root {\n";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$theme_mod = $colour_value[$i]["value"];
				if (!empty($theme_mod) ) {
					$css .= "\t--$colour_id:$theme_mod;\n";
				} else {
					$css .= "\t--$colour_id:$colour_default;\n";
				}
			}
			$css .= "}\n";
		} else { //GDS Scheme
			$colour_bar_colour = get_theme_mod('colour_bar','#1D70B8');
			$css = ":root {\n";
			for($i=0;$i<count($colour_array);$i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$colour_options = hale_get_colour_options($colour_array[$i]);
				if ($colour_options == "brand-colour") $colour_default = $colour_bar_colour;
				$css .= "\t--$colour_id:$colour_default;\n";
			}
			$css .= "}\n";
			if (!empty($colour_bar_colour) && strcasecmp($colour_bar_colour, "#FFF") != 0 && strcasecmp($colour_bar_colour, "#FFFFFF") != 0) {
				$colour_bar_style  = ".govuk-header__container {\n\t";
				$colour_bar_style .= 	"border-bottom: 10px solid $colour_bar_colour!important;\n";
				$colour_bar_style .= "}\n";
				$colour_bar_style .= ".govuk-header {\n\t";
				$colour_bar_style .= 	"border-bottom-width: unset!important;\n\t";
				$colour_bar_style .= 	"margin-bottom: 7px;\n";
				$colour_bar_style .= "}\n";
				$css .= $colour_bar_style;
			}
		}
		if (!$custom_colours_set || $logo_focus_invert) {
			$logo_focus_invert_style  = ".govuk-header a:focus img {\n\t";
			$logo_focus_invert_style .= 	"filter: invert(1) hue-rotate(180deg);\n";
			$logo_focus_invert_style .= "}\n";
			$css .= $logo_focus_invert_style;
		}
		$css_file = fopen($upload_file_path."/temp-colours.css", "w");
		fwrite($css_file, $css);
		fclose($css_file);

		//IE compatible way
		$level_count = substr_count($_SERVER['PHP_SELF'], '/');
		$level = "/";
		for($i = $level_count; $i--; $i<=0) {
			$level .= "../";
		}
		
		clearstatcache();
		
		//Copy the main CSS file so it can be changed into an IE-friendly file
		if ($main_css_file_exists && $upload_file_path_exists) {
			$css = file_get_contents($main_css_file);
		} else {
			trigger_error("!!!!! Main CSS or Upload Path doesn't exist!!!");
		}

		for($i=0;$i<count($colour_array);$i++) {
			$colour_id = hale_get_colour_id($colour_array[$i]);
			$colour_default = hale_get_colour_default($colour_array[$i]);
			$colour_options = hale_get_colour_options($colour_array[$i]);
			if ($jason) { //JSON file uploaded
				$colour_to_use = $jason[$colour_id];
			} elseif ($custom_colours_set) { //custom colours set
				$colour_to_use = $colour_value[$i]["value"];
			} else { //GDS colours
				$colour_bar_colour = get_theme_mod('colour_bar','#1D70B8');
				if ($colour_options == "brand-colour") $colour_default = $colour_bar_colour;
				$colour_to_use = $colour_default;
			}
			if (empty($colour_to_use)) $colour_to_use = $colour_default;

			//first checks for any svg colours that need dealing with, these need the # replaced with %23
			//(These are identified by the suffix -svg in the colour variable)
			$colour_to_use_SVG = str_replace('#',"%23",$colour_to_use);
			$css = str_replace("var(--$colour_id-svg)",$colour_to_use_SVG,$css);
			$css = str_replace("var(--$colour_id)",$colour_to_use,$css);
		}
		if (str_contains($css, "var(--")) {
			trigger_error("!!!!! not all CSS variables replaced!!!"); //disconnect betwixt colours.php and css file
		}
		if (str_contains($css, "-svg")) {
			trigger_error("!!!!! SVG variable replaced with non-SVG value!!!"); //Some SVG variables not replaced correctly
		}

		$css_file = fopen($upload_file_path."/temp-colours-ie.css", "w");
		if (isset($colour_bar_style)) $css .= $colour_bar_style;
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
