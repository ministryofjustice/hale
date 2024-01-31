<?php

	function hale_get_colours() {
		//defaults - GDS colours
		$white = '#FFFFFF';
		$black = '#0B0C0C';
		$yellow = '#FFDD00';
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
			palette-colour = we perform brightness checks on this colour and bring in whole blocks of CSS as needed
			We can use this to add more options if needed
		*/
		$colour_array = array(
			//header
			['header-bg',$black,'Header background','',''],
			['header-divider-line',$headerMenuLineGrey,'Header divider line','',''],

			//search
			['header-search-input-bg',$white,'Search box background','',''],
			['header-search-input-border',$white,'Search box border','',''],
			['header-search-input-focus-bg',$white,'Search box background when focused','',''],
			['header-search-input-focus-border',$yellow,'Search box border when focused','',''],
			['header-search-input-active-bg',$white,'Search box background when active','',''],
			['header-search-input-active-border',$yellow,'Search box border when active','',''],
			['header-search-btn-bg',$lightGrey,'Search button background','',''],
			['header-search-btn-icon',$black,'Search button icon','',''],
			['header-search-btn-hover-bg',$buttonHoverGrey,'Search button background on hover','',''],
			['header-search-btn-hover-icon',$black,'Search button icon on hover','',''],
			['header-search-btn-focus-bg',$yellow,'Search button background when focused','',''],
			['header-search-btn-focus-icon',$black,'Search button icon when focused','',''],

			//main site menu navigation
			['header-link',$white,'Main navigation link text','',''],
			['header-link-hover',$white,'Main navigation link text on hover','When there is no secondary navigation',''],
			['header-link-hover-border',$white,'Main navigation link underline on hover','When there is no secondary navigation',''],
			['header-link-hover-focus',$black,'Main navigation link text when focused, or on mouse click','',''],
			['header-link-current',$currentPageBlue,'Main navigation link, current page text','When there is no secondary navigation',''],
			['header-link-current-bg',$black,'Main navigation link, current page background','When there is no secondary navigation',''],
			['header-link-current-border',$black,'Main navigation link, current page underline','When there is no secondary navigation',''],
			['header-link-current-hover-border',$currentPageBlue,'Main navigation link, current page underline on hover','When there is no secondary navigation',''],
			['header-link-focus',$black,'Main navigation link text when focused','',''],
			['header-link-focus-highlight',$yellow,'Main navigation link background when focused','',''],
			['header-link-focus-underline',$black,'Main navigation link underline when focused','',''],
			['header-link-with-children-hover',$white,'Main navigation link text on hover','When there is secondary navigation',''],
			['header-link-with-children-hover-bg',$black,'Main navigation link background on hover','When there is secondary navigation',''],
			['header-link-with-children-hover-border',"currentColor",'Main navigation link text on hover','When there is secondary navigation',''],
			['header-link-ancestor',$currentPageBlue,'Main navigation link text when on secondary navigation page','Including current page when there is secondary navigation',''],
			['header-link-ancestor-bg',$black,'Main navigation link background when on secondary navigation page','Including current page when there is secondary navigation',''],
			['header-link-ancestor-hover-border',$currentPageBlue,'Main navigation link hover underline when on secondary navigation page','',''],

			//secondary navigation menu
			['header-submenu-bg',$black,'Secondary navigation background','Desktop only, header colour extends on mobile view',''],
			['header-submenu-top-border',"transparent",'Secondary navigation dividing line','Leave blank for no line',''],
			['header-submenu-link-mobile',$white,'Secondary navigation link text (mobile)','',''],
			['header-submenu-link-mobile-current',$currentPageBlue,'Secondary navigation link, current page text (mobile)','',''],
			['header-submenu-link',$white,'Secondary navigation link text (desktop)','',''],
			['header-submenu-link-hover',$white,'Secondary navigation link text on hover (desktop)','',''],
			['header-submenu-link-current',$currentPageBlue,'Secondary navigation link, current page text','',''],
			['header-submenu-link-current-bg',$black,'Secondary navigation link, current page background','',''],
			['header-submenu-link-current-border',$black,'Secondary navigation link, current page underline','',''],
			['header-submenu-link-current-hover-border',$currentPageBlue,'Secondary navigation link, current page underline on hover','',''],
			['header-submenu-lock-focus',$yellow,'Border for the submenu when the keyboard focusses on the lock button','Desktop only, keyboard tabbing only',''],

			//page
			['title-shading',$white,'Page title background','',''],
			['mojblocks-hero-bg',$white,'Hero background','Will be obscured by the Hero image',''],
			['cat-nav-arrows',$black,'Chapter headings navigation arrows','',''],
			['pagination-border',$midGrey,'Line at bottom of listing page','When there are multiple pages',''],

			//main text
			['text',$black,'Normal text','',''],
			['heading-text',$black,'Heading level text','',''],
			['dark-text',$white,'Normal text on custom-set dark background','',''],
			['dark-heading-text',$white,'Heading level text on custom-set dark background','',''],

			//links on page
			['link',$blue,'Link colour','',''],
			['link-visited',$purple,'Link visited','',''],
			['link-hover',$darkBlue,'Link on hover','',''],
			['link-focus',$black,'Link when focused','',''],
			['link-focus-shadow',$black,'Link underline when focused','',''],
			['link-focus-background',$yellow,'Link background when focused','',''],
			['dark-link',$white,'Link colour on custom-set dark background','',''],
			['dark-link-hover',$white,'Link on hover on custom-set dark background','',''],

			//buttons
			['button',$green,'Button background','',''],
			['button-text',$white,'Button text','',''],
			['button-border',"none",'Button border','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
			['button-hover',$buttonHoverGreen,'Button background on hover','',''],
			['button-hover-text',$white,'Button text on hover','',''],
			['button-hover-border','transparent','Button border on hover','Leave blank for none. Requires there to be a button border set',''],
			['button-focus',$yellow,'Button background when focused','',''],
			['button-focus-text',$black,'Button text when focused','',''],
			['button-focus-outline',$yellow,'Button outline when focused (including search button)','This is thicker than any set button border',''],

			//Quick Exit button
			['quick-exit-button',$red,'Quick Exit Button background','',''],
			['quick-exit-button-text',$white,'Quick Exit Button text','',''],
			['quick-exit-button-border',"none",'Quick Exit Button border','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
			['quick-exit-button-hover',$darkRed,'Quick Exit Button background on hover','',''],
			['quick-exit-button-hover-text',$white,'Quick Exit Button text on hover','',''],
			['quick-exit-button-hover-border','transparent','Quick Exit Button border on hover','Leave blank for none. Requires there to be a button border set',''],
			['quick-exit-button-focus',$yellow,'Quick Exit Button background when focused','',''],
			['quick-exit-button-focus-text',$black,'Quick Exit Button text when focused','',''],
			['quick-exit-button-focus-outline',$yellow,'Quick Exit Button outline when focused (including search button)','This is thicker than any set button border',''],

			//accordion - MoJ Blocks
			['mojblocks-accordion-section-title',$black,'Accordion section titles','',''],
			['mojblocks-accordion-section-shew',$blue,'Accordion show/hide','',''],
			['mojblocks-accordion-section-title-hover',$black,'Accordion section titles on hover','',''],
			['mojblocks-accordion-section-shew-hover',$black,'Accordion show/hide on hover','',''],
			['mojblocks-accordion-section-item-hover-bg',$lightGrey,'Accordion section background on hover','',''],
			['mojblocks-accordion-section-title-focus',$black,'Accordion section titles when focused','',''],
			['mojblocks-accordion-section-shew-focus',$black,'Accordion show/hide when focused','',''],
			['mojblocks-accordion-section-title-focus-bg',$yellow,'Accordion section titles and show/hide background when focused','',''],
			['mojblocks-accordion-section-title-focus-shadow',$black,'Accordion section titles and show/hide underline when focused','',''],

			//call to action - MoJ Blocks
			['mojblocks-cta-bg',$white,'Call to action background','',''],
			['mojblocks-cta-title',$black,'Call to action title','',''],
			['mojblocks-cta-text',$black,'Call to action text','',''],
			
			//card - mojblocks
			['mojblocks-card-bg',$white,'Card background','',''],

			//highlights list - MoJ Blocks
			['mojblocks-highlights-list-bg',$white,'Highlights list background','',''],
			['mojblocks-highlights-list-title',$black,'Highlights list title','',''],
			['mojblocks-highlights-list-text',$black,'Highlights list text','',''],
			['mojblocks-highlights-list-bar',$blue,'Highlights list little bar','','brand-colour'],
			
			//staggered box - MoJ Blocks
			['mojblocks-staggered-box-bg',$darkGrey,'Staggered box background','',''],
			['mojblocks-staggered-box-title',$white,'Staggered box title','',''],
			['mojblocks-staggered-box-text',$white,'Staggered box text','',''],
			['mojblocks-staggered-box-btn-border',$lightGrey,'Staggered box button border','',''],
			['mojblocks-staggered-box-btn-bg',"transparent",'Staggered box button background','Leave blank for transparent',''],
			['mojblocks-staggered-box-btn-text',$white,'Staggered box button text','',''],
			['mojblocks-staggered-box-btn-hover-border',$black,'Staggered box button border on hover','',''],
			['mojblocks-staggered-box-btn-hover-bg',$midGrey,'Staggered box button background on hover','',''],
			['mojblocks-staggered-box-btn-hover-text',$black,'Staggered box button text on hover','',''],
			['mojblocks-staggered-box-btn-focus-border',$black,'Staggered box button border when focussed','',''],
			['mojblocks-staggered-box-btn-focus-bg',$yellow,'Staggered box button background when focussed','',''],
			['mojblocks-staggered-box-btn-focus-text',$black,'Staggered box button text when focussed','',''],
			['mojblocks-staggered-box-bar',$yellow,'Staggered box little bar','',''],

			//extended core blocks
			['extended-block-group-bg',$white,'Group block background','When not using default style',''],

			//block editor colour palette
			['generic-palette-1',$blue,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
			['generic-palette-2',$lightPink,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
			['generic-palette-3',$orange,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
			['generic-palette-4',$green,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],

			//inputs
			['input-bg',$white,'Input box background','',''],
			['input-border',$black,'Input box border','',''],
			['input-focus',$yellow,'Input box focus','',''],
			['error',$red,'Error colour','',''],
			['error-link-hover',$darkRed,'Error link on hover','',''],

			//Job listings
			['job-item-bg',$white,'Job listing background','',''],
			['job-item-border',$midGrey,'Line between job listings','Should match line at end of listing page',''],

			//Tags
			['tag-bg',$lightGrey,'Tag background','',''],
			['tag-text',$black,'Tag text','',''],
			['tag-hover-bg',$midGrey,'Tag background on hover','',''],
			['tag-hover-text',$black,'Tag text on hover','',''],
			['tag-focus-bg',$yellow,'Tag background when focused','',''],
			['tag-focus-outline',$yellow,'Tag outline when focused','',''],
			['tag-focus-text',$black,'Tag text when focused','',''],

			//footer
			['footer-border',$midGrey,'Footer border','',''],
			['footer-background',$lightGrey,'Footer background','',''],
			['footer-link',$black,'Footer link text','',''],
			['footer-link-focus',$black,'Footer link text when focused','',''],
			['footer-link-focus-shadow',$black,'Footer link underline when focused','',''],
			['footer-link-focus-background',$yellow,'Footer link background when focused','',''],

			//Cookie banner
			['cookie-settings-bg',$darkGrey,'Cookie settings (triangle) background','',''],
			['cookie-settings-text',$white,'Cookie settings (triangle) text','',''],
			['cookie-settings-hover-bg',$black,'Cookie settings (triangle) background on hover','',''],
			['cookie-settings-hover-text',$white,'Cookie settings (triangle) text on hover','',''],
			['cookie-settings-focus-bg',$yellow,'Cookie settings (triangle) background when focused','',''],
			['cookie-settings-focus-text',$black,'Cookie settings (triangle) text when focused','',''],
			['cookie-settings-focus-outline','transparent','Cookie settings (triangle) outline when focused','Leave blank for none',''],
			['cookie-button-bg',$green,'Cookie banner button background','',''],
			['cookie-button-text',$white,'Cookie banner button text','',''],
			['cookie-button-hover-bg',$buttonHoverGreen,'Cookie banner button background on hover','',''],
			['cookie-button-hover-text',$white,'Cookie banner button text on hover','',''],
			['cookie-button-focus-bg',$yellow,'Cookie banner button background when focused','',''],
			['cookie-button-focus-border',$black,'Cookie banner button border when focused','',''],
			['cookie-button-focus-text',$black,'Cookie banner button text when focused','',''],
			['cookie-secondary-button-bg',$lightGrey,'Cookie banner secondary button background','',''],
			['cookie-secondary-button-text',$black,'Cookie banner secondary button text','',''],
			['cookie-toggle-bg',$green,'Cookie toggle background','',''],
			['cookie-toggle-focus-bg',$buttonHoverGreen,'Cookie toggle background when focused','',''],
			['cookie-toggle-text',$white,'Cookie toggle text','',''],
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

		$CSSpath = wp_get_upload_dir()["basedir"];

		if (!file_exists($CSSpath)) {
			// This section creates the upload path in situations where it doesn't exist
			if (!mkdir($CSSpath,0755,true)) {
				// If the make directory fails, we trigger a PHP Warning
				trigger_error("Failed to create directory $CSSpath.",E_USER_WARNING);
			} else {
				trigger_error("Directory $CSSpath was missing, but was successfully created.",E_USER_NOTICE);
			}
		}
		$CSSfileURL = $CSSpath."/custom-colours.css";
		$ColourFileURL = get_template_directory()."/inc/colours.php";

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
				if (file_exists($CSSpath)) {
					$css_file = fopen($CSSfileURL, "a");
					// We only do this step if the directory is either found or created
					// Append the new CSS to the end of the file
					fwrite($css_file, ":root {\n");
					fwrite($css_file, $missing_colours);
					fwrite($css_file, "}");
					fclose($css_file);
				}
			} else {
				//if there are no missing colours, nothing needs to be done.
				//but we still touch the file so the surrounding if statement is not triggered and we don't have to do the get_file_contents each time
				touch($CSSfileURL);
			}
		}
	}

	hale_new_colour_check();
