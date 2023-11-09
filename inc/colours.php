<?php

	function hale_get_colours() {
		//defaults - GDS colours
		$white = '#FFF';
		$black = '#0B0C0C';
		$yellow = '#FD0';
		$orange = '#F47738';
		$red = '#D4351C';
		$darkRed = '#942514';
		$blue = '#1D70B8';
		$lightBlue = '#5694CA';
		$darkBlue = '#003078';
		$purple = '#4C2C92';
		$brightPurple = '#912B88';
		$lightPink = '#F499BE';
		$green = '#00703C';
		$lightGreen = '#85994b';
		$buttonHoverGreen = '#005A30';
		$buttonHoverGrey = '#DBDAD9';
		$lightGrey = '#F3F2F1';
		$midGrey = '#B1B4B6';
		$darkGrey = '#505A5F';
		$currentPageBlue = '#1D8FEB'; //this has to be okay contrast against black, so is separated out from other blues
		$headerMenuLineGrey = '#2E3133';

		/*
		array format
		0 = colour ID
		1 = default value
		2 = title for entry
		3 = description/hint text
		4 = options
			text = accepts non-colour values
			brand-colour = uses the brand colour as the default in GDS mode
			We can use this to add more options if needed
		*/
		$colour_array = array(
			//header
			['header-bg',$black,'Header background','',''],
			['header-link',$white,'Header link','',''],
			['header-link-hover',$white,'Header link hover','Only links without children',''],
			['header-link-hover-border',$white,'Header link hover underline','Only links without children',''],
			['header-link-hover-focus',$black,'Header link hover when focussed (mouse click)','',''],
			['header-link-current',$currentPageBlue,'Header current page','Text if without children',''],
			['header-link-current-bg',$black,'Header current page background','Background if without children',''],
			['header-link-current-border',$black,'Header current page underline','Underline if without children',''],
			['header-link-current-hover-border',$currentPageBlue,'Header current page hover underline','Hover underline if without children',''],
			['header-link-focus',$black,'Header link focus','',''],
			['header-link-focus-highlight',$yellow,'Header link focus highlight','',''],
			['header-link-focus-underline',$black,'Header link focus underline','',''],
			['header-link-with-children-hover',$white,'Header link with children hover text','',''],
			['header-link-with-children-hover-bg',$black,'Header link with children hover background','',''],
			['header-link-with-children-hover-border',"currentColor",'Header link with children hover underline','Leave blank to match text colour',''],
			['header-link-ancestor',$currentPageBlue,'Ancestor link','Including current page if it has children',''],
			['header-link-ancestor-bg',$black,'Ancestor background','',''],
			['header-link-ancestor-hover-border',$currentPageBlue,'Ancestor hover underline','',''],
			['header-divider-line',$headerMenuLineGrey,'Menu divider lines','',''],
			['header-submenu-bg',$black,'Submenu background','Desktop only, narrow displays extend the main colour',''],
			['header-submenu-top-border',"transparent",'Submenu dividing line','Leave blank for no line',''],
			['header-submenu-link-mobile',$white,'Submenu link (mobile)','',''],
			['header-submenu-link-mobile-current',$currentPageBlue,'Submenu link (mobile) current page','',''],
			['header-submenu-link',$white,'Submenu link (desktop)','',''],
			['header-submenu-link-hover',$white,'Submenu link (desktop) hover','',''],
			['header-submenu-link-current',$currentPageBlue,'Submenu current page','',''],
			['header-submenu-link-current-bg',$black,'Submenu current page background','',''],
			['header-submenu-link-current-border',$black,'Submenu current page underline','',''],
			['header-submenu-link-current-hover-border',$currentPageBlue,'Submenu current page hover underline','',''],
			['header-search-input-bg',$white,'Search box background','',''],
			['header-search-input-border',$white,'Search box border','',''],
			['header-search-input-focus-bg',$white,'Search box focus background','',''],
			['header-search-input-focus-border',$yellow,'Search box focus border','',''],
			['header-search-input-active-bg',$white,'Search box active background','',''],
			['header-search-input-active-border',$yellow,'Search box active border','',''],
			['header-search-btn-bg',$lightGrey,'Search button background','',''],
			['header-search-btn-icon',$black,'Search button icon','',''],
			['header-search-btn-hover-bg',$buttonHoverGrey,'Search button hover background','',''],
			['header-search-btn-hover-icon',$black,'Search button hover icon','',''],
			['header-search-btn-focus-bg',$yellow,'Search button focus background','',''],
			['header-search-btn-focus-icon',$black,'Search button focus icon','',''],

			//Misc
			['title-shading',$white,'Title shading','',''],
			['cat-nav-arrows',$black,'Category navigation arrows','',''],
			['pagination-border',$midGrey,'Pagination separating line','',''],
			['error',$red,'Error colour','',''],
			['error-link-hover',$darkRed,'Error link hover','',''],

			//footer
			['footer-border',$midGrey,'Footer border','',''],
			['footer-background',$lightGrey,'Footer background','',''],
			['footer-link',$black,'Footer link','',''],
			['footer-link-focus',$black,'Footer link focus','',''],
			['footer-link-focus-shadow',$black,'Footer link focus underline','',''],
			['footer-link-focus-background',$yellow,'Footer link focus background','',''],

			//links
			['link',$blue,'Link colour','',''],
			['link-visited',$purple,'Link visited','',''],
			['link-hover',$darkBlue,'Link hover','',''],
			['link-focus',$black,'Link focus','',''],
			['link-focus-shadow',$black,'Link focus underline','',''],
			['link-focus-background',$yellow,'Link focus background','',''],

			//inputs
			['input-bg',$white,'Input background','',''],
			['input-border',$black,'Input border','',''],
			['input-focus',$yellow,'Input focus','',''],

			//buttons
			['button',$green,'Button colour','',''],
			['button-text',$white,'Button text','',''],
			['button-border',"none",'Button border','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
			['button-hover',$buttonHoverGreen,'Button hover','',''],
			['button-hover-text',$white,'Button hover text','',''],
			['button-hover-border','transparent','Button hover border','Leave blank for none. Requires there to be a button border set',''],
			['button-focus',$yellow,'Button focus','',''],
			['button-focus-text',$black,'Button focus text','',''],
			['button-focus-outline',$yellow,'Button focus outline','This will always be thicker than any set button border',''],
			['button-active',$buttonHoverGreen,'Button active','',''],

			//Job listings
			['job-item-bg',$white,'Job listing background','',''],
			['job-item-border',$midGrey,'Job listing separating line','Should ideally match pagination separating line',''],
			
			//mojblocks - these are usually things not found in GOV.UK sites
			['mojblocks-accordion-section-title',$black,'Accordion titles','',''],
			['mojblocks-accordion-section-shew',$blue,'Accordion show links','',''],
			['mojblocks-accordion-section-title-hover',$black,'Accordion titles hover','',''],
			['mojblocks-accordion-section-shew-hover',$black,'Accordion show links hover','',''],
			['mojblocks-accordion-section-item-hover-bg',$lightGrey,'Accordion item hover background','',''],
			['mojblocks-accordion-section-title-focus',$black,'Accordion titles focus','',''],
			['mojblocks-accordion-section-shew-focus',$black,'Accordion show links focus','',''],
			['mojblocks-accordion-section-title-focus-bg',$yellow,'Accordion titles and links focus background','',''],
			['mojblocks-accordion-section-title-focus-shadow',$black,'Accordion titles and links focus underline','',''],

			['mojblocks-hero-bg',$white,'Hero background','This is usually obscured by the Hero image',''],

			['mojblocks-cta-bg',$white,'Call to action background','',''],
			['mojblocks-cta-title',$black,'Call to action title','',''],
			['mojblocks-cta-text',$black,'Call to action text','',''],

			['mojblocks-card-bg',$white,'Card background','',''],

			['mojblocks-highlights-list-bg',$white,'Highlights list background','',''],
			['mojblocks-highlights-list-title',$black,'Highlights list title','',''],
			['mojblocks-highlights-list-text',$black,'Highlights list text','',''],
			['mojblocks-highlights-list-bar',$blue,'Little bar','','brand-colour'],

			['mojblocks-staggered-box-bg',$darkGrey,'Staggered box background','',''],
			['mojblocks-staggered-box-title',$white,'Staggered box title','',''],
			['mojblocks-staggered-box-text',$white,'Staggered box text','',''],
			['mojblocks-staggered-box-btn-border',$lightGrey,'Staggered box button border','',''],
			['mojblocks-staggered-box-btn-bg',"transparent",'Staggered box button background','Leave blank for transparent',''],
			['mojblocks-staggered-box-btn-text',$white,'Staggered box button text','',''],
			['mojblocks-staggered-box-btn-hover-border',$black,'Staggered box button hover border','',''],
			['mojblocks-staggered-box-btn-hover-bg',$midGrey,'Staggered box button hover background','',''],
			['mojblocks-staggered-box-btn-hover-text',$black,'Staggered box button hover text','',''],
			['mojblocks-staggered-box-btn-focus-border',$black,'Staggered box button focus border','',''],
			['mojblocks-staggered-box-btn-focus-bg',$yellow,'Staggered box button focus background','',''],
			['mojblocks-staggered-box-btn-focus-text',$black,'Staggered box button focus text','',''],
			['mojblocks-staggered-box-bar',$yellow,'Little bar','',''],

			//Tags
			['tag-bg',$lightGrey,'Tag background','',''],
			['tag-text',$black,'Tag text','',''],
			['tag-hover-bg',$midGrey,'Tag hover background','',''],
			['tag-hover-text',$black,'Tag hover text','',''],
			['tag-focus-bg',$yellow,'Tag focus background','',''],
			['tag-focus-outline',$yellow,'Tag focus outline','',''],
			['tag-focus-text',$black,'Tag focus text','',''],

			//Cookie banner
			['cookie-settings-bg',$darkGrey,'Cookie settings (triangle) background','',''],
			['cookie-settings-text',$white,'Cookie settings (triangle) text','',''],
			['cookie-settings-hover-bg',$black,'Cookie settings (triangle) hover background','',''],
			['cookie-settings-hover-text',$white,'Cookie settings (triangle) hover text','',''],
			['cookie-settings-focus-bg',$yellow,'Cookie settings (triangle) focus background','',''],
			['cookie-settings-focus-text',$black,'Cookie settings (triangle) focus text','',''],
			['cookie-settings-focus-outline','transparent','Cookie settings (triangle) focus outline, leave blank for none','',''],
			['cookie-button-bg',$green,'Cookie banner button background','',''],
			['cookie-button-text',$white,'Cookie banner button text','',''],
			['cookie-button-hover-bg',$buttonHoverGreen,'Cookie banner button hover background','',''],
			['cookie-button-hover-text',$white,'Cookie banner button hover text','',''],
			['cookie-button-focus-bg',$yellow,'Cookie banner button focus background','',''],
			['cookie-button-focus-border',$black,'Cookie banner button focus border','',''],
			['cookie-button-focus-text',$black,'Cookie banner button focus text','',''],
			['cookie-secondary-button-bg',$lightGrey,'Cookie banner secondary button background','',''],
			['cookie-secondary-button-text',$black,'Cookie banner secondary button text','',''],
			['cookie-toggle-bg',$green,'Cookie toggle background','',''],
			['cookie-toggle-focus-bg',$buttonHoverGreen,'Cookie toggle focus background','',''],
			['cookie-toggle-text',$white,'Cookie toggle text','',''],

			//Generic colours - for WP6.2+ colour palette
			['generic-palette-1',$lightPink,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available',''],
			['generic-palette-2',$red,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available',''],
			['generic-palette-3',$orange,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available',''],
			['generic-palette-4',$green,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available',''],
		);

		return $colour_array;
	}

	function hale_get_colour_id($colour_array_item) {
		return $colour_array_item[0];
	}
	function hale_get_colour_default($colour_array_item) {
		return $colour_array_item[1];
	}
	function hale_get_colour_designation($colour_array_item) {
		return $colour_array_item[2];
	}
	function hale_get_colour_hint($colour_array_item) {
		return $colour_array_item[3];
	}
	function hale_get_colour_options($colour_array_item) {
		return $colour_array_item[4];
	}

	function hale_new_colour_check() {
		// This function checks for any newly created colours that haven't been set in the customizer and applies the default.
		// The amended CSS file will be overwritten when the colours are next amended.
		// This does not protect against new colours being added to the SASS and not added to colours.php.
		// This is for non-IE only as this particular bug doesn't occur in IE.

		$CSSfileURL = wp_get_upload_dir()["basedir"]."/custom-colours.css"; //non-IE CSS file (variable values)
		$ColourFileURL = get_template_directory()."/inc/colours.php"; //colours CSS file

		if (filemtime($CSSfileURL) <= filemtime($ColourFileURL)) {
			//The colours CSS for this site is older than the last colours build - doesn't necessarily mean that the CSS is incomplete
			//But if the colours CSS is newer, that means the colours have been set since the last update and the error cannot occur
			$missing_colours = "";
			$colour_array = hale_get_colours();
			$CSS_string = file_get_contents($CSSfileURL);
			for ($i=0;$i<count($colour_array);$i++) {
				if (strpos($CSS_string, $colour_array[$i][0]) === false) {
					trigger_error("Colour not found: ".$colour_array[$i][0]." auto-creating colour, set to default (".$colour_array[$i][1].")");
					//we add the missing colour variable with default value to missing colour string
					$missing_colours .= "\t--".$colour_array[$i][0].": ".$colour_array[$i][1].";\n";
				}
			}
			if ($missing_colours != "") {
				$css_file = fopen($CSSfileURL, "a");
				//append the new CSS to the end of the file
				fwrite($css_file, ":root {\n");
				fwrite($css_file, $missing_colours);
				fwrite($css_file, "}");
				fclose($css_file);
			} else {
				//if there are no missing colours, nothing needs to be done.
				//but we still touch the file so the surrounding if statement is not triggered and we don't have to do the get_file_contents each time
				touch($CSSfileURL);
			}
		}
	}

	hale_new_colour_check();
