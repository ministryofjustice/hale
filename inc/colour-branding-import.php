<?php

function hale_get_colours_from_jason() {
	$custom_colours_json = get_theme_mod("customizer_setting_json");
	if ($custom_colours_json) {
		$custom_colours_json_string = file_get_contents($custom_colours_json);
		$jason = json_decode($custom_colours_json_string, true);
		$colour_array = hale_get_colours();

		for($i=0;$i<count($colour_array);$i++) {
			$colour_id = hale_get_colour_id($colour_array[$i]);
			$jason_colour = $jason[$colour_id];
			if (get_theme_mod($colour_id) != $jason_colour) //if JSON colour is different from current colour
				set_theme_mod($colour_id,$jason_colour); //sets the colours to those in the JSON
		}
		return $jason;
	} else {
		return false;
	}
}
