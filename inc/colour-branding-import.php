<?php

function get_colours_from_json() {
	$jason_file = get_theme_mod("customizer_setting_json");
	if ($jason_file) {
		$jason_string = file_get_contents($jason_file);
		$jason = json_decode($jason_string, true);
		$colour_array = get_colours() or die("no colour array");

		for($i=0;$i<count($colour_array);$i++) {
			$colour_id = get_colour_id($colour_array[$i]);
			$jason_colour = $jason[$colour_id];
			if (get_theme_mod($colour_id) != $jason_colour) //if JSON colour is different from current colour
				set_theme_mod($colour_id,$jason_colour); //sets the colours to those in the JSON
		}
		//wp_delete_attachment("customizer_setting_json");
		//set_theme_mod("customizer_setting_json","");
		return $jason;
	} else {
		return false;
	}
}

?>
