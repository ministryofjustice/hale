<?php

	function hale_get_colours($sections = false) {
		//defaults - GDS colours
		$white = '#FFFFFF';
		$black = '#0B0C0C';
		$yellow = '#FFDD00';
		$orange = '#F47738';
		$red = '#D4351C';
		$darkRed = '#942514';
		$blue = '#1D70B8';
		$fadedBlue = '#D5E8F3'; // Not in the GDS palette, but this is the government style from https://docs.publishing.service.gov.uk/manual/global-banner.html
		$lightBlue = '#5694CA';
		$darkBlue = '#003078';
		$purple = '#4C2C92';
		$brightPurple = '#912B88';
		$lightPink = '#F499BE';
		$green = '#00703C';
		$lightGreen = '#85994b';
		$buttonHoverGreen = '#005A30';
		$buttonHoverGrey = '#DBDAD9';
		$buttonHoverWhite = '#E8F1F8';
		$lightGrey = '#F3F2F1';
		$midGrey = '#B1B4B6';
		$darkGrey = '#505A5F';
		$royalCrestGrey = '#6B7275';
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
			[
				"section_name" => "Main text",
				"id" => "main_text",
				"description" => "",
				"colours" => array(
					['text',$black,'Normal text','',''],
					['heading-text',$black,'Heading level text','',''],
					['dark-text',$white,'Normal text on custom-set dark background','',''],
					['dark-heading-text',$white,'Heading level text on custom-set dark background','',''],
				)
			],
			[
				"section_name" => "Header",
				"id" => "header",
				"description" => "",
				"colours" => array(
					['header-bg',$black,'Header background','',''],
					['header-divider-line',$headerMenuLineGrey,'Header divider line','',''],
			
				)
			],
			[
				"section_name" => "Header search",
				"id" => "header_search",
				"description" => "",
				"colours" => array(
					['header-search-input-bg',$white,'Background','',''],
					['header-search-input-text',$black,'Text','',''],
					['header-search-input-placeholder',$darkGrey,'Placeholder text','',''],
					['header-search-input-border',$white,'Border','',''],
					['header-search-input-focus-bg',$white,'Background when focussed','',''],
					['header-search-input-focus-text',$black,'Text when focussed','',''],
					['header-search-input-focus-placeholder',$darkGrey,'Placeholder text when focussed','',''],
					['header-search-input-focus-border',$yellow,'Border when focussed','',''],
					['header-search-input-focus-border-trim',$black,'Inner border when focussed','',''],
					['header-search-input-active-bg',$white,'Background when active','',''],
					['header-search-input-active-text',$black,'Text when active','',''],
					['header-search-input-active-placeholder',$darkGrey,'Placeholder text when active','',''],
					['header-search-input-active-border',$yellow,'Border when active','',''],
					['header-search-btn-bg',$lightGrey,'Button background','',''],
					['header-search-btn-border','var(--header-search-btn-bg)','Button border','Blank will match background',''], // using a var to reduce impact on existing colour schemes
					['header-search-btn-border-input-active',$yellow,'Button border when input is active','',''],
					['header-search-btn-icon',$black,'Button icon','',''],
					['header-search-btn-hover-bg',$buttonHoverGrey,'Background on hover','',''],
					['header-search-btn-hover-border','var(--header-search-btn-hover-bg)','Button border on hover','Blank will match background',''], // using a var to reduce impact on existing colour schemes
					['header-search-btn-hover-icon',$black,'Button icon on hover','',''],
					['header-search-btn-focus-bg',$yellow,'Button background when focussed','',''],
					['header-search-btn-focus-border','var(--header-search-btn-focus-bg)','Button border on focus','Blank will match background',''], // using a var to reduce impact on existing colour schemes
					['header-search-btn-focus-icon',$black,'Button icon when focussed','',''],
					['header-search-btn-divider',$white,'Divider between button and input field','',''],
					['header-search-btn-divider-hover',$lightGrey,'Divider on hover','',''],
					['header-search-btn-divider-focus',$yellow,'Divider on focus','',''],
					['header-search-btn-divider-input-active',$white,'Divider when input is active','',''],
				)
			],
			[
				"section_name" => "Main navigation",
				"id" => "main_navigation",
				"description" => "",
				"colours" => array(
					['header-link',$white,'Link text','',''],
					['header-link-hover',$white,'Link text on hover','When there is no secondary navigation',''],
					['header-link-hover-border',$white,'Link underline on hover','When there is no secondary navigation',''],
					['header-link-hover-focus',$black,'Link text when focussed, or on mouse click','',''],
					['header-link-current',$currentPageBlue,'Link, current page text','When there is no secondary navigation',''],
					['header-link-current-bg',$black,'Link, current page background','When there is no secondary navigation',''],
					['header-link-current-border',$black,'Link, current page underline','When there is no secondary navigation',''],
					['header-link-current-hover-border',$currentPageBlue,'Link, current page underline on hover','When there is no secondary navigation',''],
					['header-link-focus',$black,'Link text when focussed','',''],
					['header-link-focus-highlight',$yellow,'Link background when focussed','',''],
					['header-link-focus-underline',$black,'Link underline when focussed','',''],
					['header-link-with-children-hover',$white,'Link text on hover','When there is secondary navigation',''],
					['header-link-with-children-hover-bg',$black,'Link background on hover','When there is secondary navigation',''],
					['header-link-with-children-hover-border',"currentColor",'Link text on hover','When there is secondary navigation',''],
					['header-link-ancestor',$currentPageBlue,'Link text when on secondary navigation page','Including current page when there is secondary navigation',''],
					['header-link-ancestor-bg',$black,'Link background when on secondary navigation page','Including current page when there is secondary navigation',''],
					['header-link-ancestor-hover-border',$currentPageBlue,'Link hover underline when on secondary navigation page','',''],
				)
			],
			[
				"section_name" => "Secondary navigation",
				"id" => "secondary_navigation",
				"description" => "",
				"colours" => array(
					['header-submenu-bg',$black,'Background','Desktop only, header colour extends on mobile view',''],
					['header-submenu-top-border',"transparent",'Dividing line','Leave blank for no line',''],
					['header-submenu-link-mobile',$white,'Link text (mobile)','',''],
					['header-submenu-link-mobile-current',$currentPageBlue,'Link, current page text (mobile)','',''],
					['header-submenu-link',$white,'Link text (desktop)','',''],
					['header-submenu-link-hover',$white,'Link text on hover (desktop)','',''],
					['header-submenu-link-current',$currentPageBlue,'Link, current page text','',''],
					['header-submenu-link-current-bg',$black,'Link, current page background','',''],
					['header-submenu-link-current-border',$black,'Link, current page underline','',''],
					['header-submenu-link-current-hover-border',$currentPageBlue,'Link, current page underline on hover','',''],
					['header-submenu-lock-focus',$yellow,'Border for the submenu when the keyboard focusses on the lock button','Desktop only, keyboard tabbing only',''],
				)
			],
			[
				"section_name" => "Backgrounds and chapters",
				"id" => "pages",
				"description" => "",
				"colours" => array(
					['title-shading',$white,'Page title background','',''],
					['mojblocks-hero-bg',$white,'Hero background','Will be obscured by the Hero image',''],
					['cat-nav-arrows',$black,'Chapter headings navigation arrows','',''],
					['pagination-border',$midGrey,'Line at bottom of listing page','When there are multiple pages',''],
					['extended-block-group-bg',$white,'Group block background','When not using default style',''],
				)
			],
			[
				"section_name" => "Links",
				"id" => "links",
				"description" => "",
				"colours" => array(
					['link',$blue,'Link colour','',''],
					['link-visited',$purple,'Link visited','',''],
					['link-hover',$darkBlue,'Link on hover','',''],
					['link-focus',$black,'Link when focussed','',''],
					['link-focus-shadow',$black,'Link underline when focussed','',''],
					['link-focus-background',$yellow,'Link background when focussed','',''],
					['dark-link',$white,'Link colour on custom-set dark background','',''],
					['dark-link-hover',$white,'Link on hover on custom-set dark background','',''],
				)
			],
			[
				"section_name" => "Buttons",
				"id" => "buttons",
				"description" => "",
				"colours" => array(
					['button',$green,'Button background','',''],
					['button-text',$white,'Button text','',''],
					['button-border',"none",'Button border','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
					['button-hover',$buttonHoverGreen,'Button background on hover','',''],
					['button-hover-text',$white,'Button text on hover','',''],
					['button-hover-border','transparent','Button border on hover','Leave blank for none. Requires there to be a button border set',''],
					['button-focus',$yellow,'Button background when focussed','',''],
					['button-focus-text',$black,'Button text when focussed','',''],
					['button-focus-outline',$yellow,'Button outline when focussed (including search button)','This is thicker than the button border',''],
					['dark-button',$white,'Button background on custom-set dark background','',''],
					['dark-button-text',$blue,'Button text on custom-set dark background','',''],
					['dark-button-border',"none",'Button border on custom-set dark background','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
					['dark-button-hover',$buttonHoverWhite,'Button background on hover on custom-set dark background','',''],
					['dark-button-hover-text',$blue,'Button text on hover on custom-set dark background','',''],
					['dark-button-hover-border','transparent','Button border on hover on custom-set dark background','Leave blank for none. Requires there to be a button border set',''],
					['dark-button-focus-outline',$yellow,'Button outline when focussed on custom-set dark background','This is thicker than the button border',''],
				)
			],
			[
				"section_name" => "Quick exit",
				"id" => "quick-exit",
				"description" => "",
				"colours" => array(
					['quick-exit-button',$red,'Quick exit button background','',''],
					['quick-exit-button-text',$white,'Quick exit button text','',''],
					['quick-exit-button-border',"none",'Quick exit button border','Enter a complete CSS value for border, e.g. "solid 2px #0b0c0c", "none"','text'], // not a colour
					['quick-exit-button-hover',$darkRed,'Quick exit button background on hover','',''],
					['quick-exit-button-hover-text',$white,'Quick exit button text on hover','',''],
					['quick-exit-button-hover-border','transparent','Quick exit button border on hover','Leave blank for none. Requires there to be a border set',''],
					['quick-exit-button-focus',$yellow,'Quick exit button background when focussed','',''],
					['quick-exit-button-focus-text',$black,'Quick exit button text when focussed','',''],
					['quick-exit-button-focus-outline',$yellow,'Quick exit button outline when focussed','This is thicker than the button border',''],
				)
			],
			[
				"section_name" => "MoJ block - Accordion",
				"id" => "moj_block_accordion",
				"description" => "",
				"colours" => array(
					['mojblocks-accordion-section-title',$black,'Section titles','',''],
					['mojblocks-accordion-section-shew',$blue,'Show/hide','Includes show all/hide all',''],
					['mojblocks-accordion-section-title-hover',$black,'Section titles on hover','',''],
					['mojblocks-accordion-section-shew-hover',$black,'Show/hide on hover','',''],
					['mojblocks-accordion-section-item-hover-bg',$lightGrey,'Section background on hover','',''],
					['mojblocks-accordion-section-title-focus',$black,'Section titles when focussed','',''],
					['mojblocks-accordion-section-shew-focus',$black,'Show/hide when focussed','',''],
					['mojblocks-accordion-section-title-focus-bg',$yellow,'Section titles and show/hide background when focussed','',''],
					['mojblocks-accordion-section-title-focus-shadow',$black,'Section titles and show/hide underline when focussed','',''],
				)
			],
			[
				"section_name" => "MoJ block - Call to action",
				"id" => "moj_block_cta",
				"description" => "",
				"colours" => array(
					['mojblocks-cta-bg',$white,'Call to action background','',''],
					['mojblocks-cta-title',$black,'Call to action title','',''],
					['mojblocks-cta-text',$black,'Call to action text','',''],
				)
			],
			[
				"section_name" => "MoJ block - Card",
				"id" => "moj_block_card",
				"description" => "",
				"colours" => array(
					['mojblocks-card-bg',$white,'Card background','',''],
					['mojblocks-card-text',$black,'Card text','',''],
					['mojblocks-card-link',$blue,'Card link','',''],
					['mojblocks-card-link-visited',$purple,'Visited card link','',''],
					['mojblocks-card-link-hover',$darkBlue,'Card link on hover','',''],
				)
			],
			[
				"section_name" => "MoJ block - Highlights list",
				"id" => "moj_block_highlight_list",
				"description" => "",
				"colours" => array(
					['mojblocks-highlights-list-bg',$white,'Highlights list background','',''],
					['mojblocks-highlights-list-title',$black,'Highlights list title','',''],
					['mojblocks-highlights-list-text',$black,'Highlights list text','',''],
					['mojblocks-highlights-list-bar',$blue,'Highlights list little bar','','brand-colour'],
				)
			],
			[
				"section_name" => "MoJ block - Featured item",
				"id" => "moj_block_featured_item",
				"description" => "",
				"colours" => array(
					['mojblocks-featured_item-little-bar',$blue,'Featured item little bar','','brand-colour'],
				)
			],
			[
				"section_name" => "MoJ block - Staggered box",
				"id" => "moj_block_staggered_box",
				"description" => "",
				"colours" => array(
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
				)
			],
			[
				"section_name" => "Custom colour palette",
				"id" => "colour_palette",
				"description" => "",
				"colours" => array(
					['generic-palette-1',$blue,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
					['generic-palette-2',$lightPink,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
					['generic-palette-3',$orange,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
					['generic-palette-4',$green,'Colour for block editor palette','Avoid greyscale colours as a selection of these are always available','palette-colour'],
				)
			],
			[
				"section_name" => "Inputs",
				"id" => "inputs",
				"description" => "",
				"colours" => array(
					['input-bg',$white,'Input box background','',''],
					['input-border',$black,'Input box border','',''],
					['input-focus',$yellow,'Input box focus','',''],
					['error',$red,'Error colour','',''],
					['error-link-hover',$darkRed,'Error link on hover','',''],
				)
			],
			[
				"section_name" => "Tags",
				"id" => "tags",
				"description" => "",
				"colours" => array(
					['tag-bg',$lightGrey,'Tag background','',''],
					['tag-text',$black,'Tag text','',''],
					['tag-hover-bg',$midGrey,'Tag background on hover','',''],
					['tag-hover-text',$black,'Tag text on hover','',''],
					['tag-focus-bg',$yellow,'Tag background when focussed','',''],
					['tag-focus-outline',$yellow,'Tag outline when focussed','',''],
					['tag-focus-text',$black,'Tag text when focussed','',''],
				)
			],
			[
				"section_name" => "Footer",
				"id" => "footer",
				"description" => "",
				"colours" => array(
					['footer-border',$midGrey,'Footer border','',''],
					['footer-background',$lightGrey,'Footer background','',''],
					['footer-text',$black,'Footer text','',''],
					['footer-link',$black,'Footer link text','',''],
					['footer-link-focus',$black,'Footer link text when focussed','',''],
					['footer-link-focus-shadow',$black,'Footer link underline when focussed','',''],
					['footer-link-focus-background',$yellow,'Footer link background when focussed','',''],
					['footer-crest',$royalCrestGrey,'Colour of the Royal Crest','Only change if there are contrast issues',''],
					['footer-crest-focus',$royalCrestGrey,'Colour of the Royal Crest when focussed','Only change if there are contrast issues when focussed',''],
					['footer-secondary-menu-border',$darkGrey,'Footer secondary menu divider lines','Not in all footers, only used in secondary menu areas',''],
				)
			],
			[
				"section_name" => "Info banner",
				"id" => "info_banner",
				"description" => "",
				"colours" => array(
					['info-banner-bg',$fadedBlue,'Background','',''],
					['info-banner-text',$black,'Text','',''],
					['info-banner-link',$darkBlue,'Link text','',''],
					['info-banner-link-visited',$purple,'Visited link text','',''],
					['info-banner-link-hover',$darkBlue,'Link text on hover','',''],
					['info-banner-link-focus',$black,'Link text when focussed','',''],
					['info-banner-link-focus-background',$yellow,'Link background when focussed','',''],
					['info-banner-link-focus-underline',$black,'Link underline when focussed','',''],
				)
			],
			[
				"section_name" => "Page-specific banner",
				"id" => "page_banner",
				"description" => "",
				"colours" => array(
					['page-banner-bg',$fadedBlue,'Background','',''],
					['page-banner-text',$black,'Text','',''],
					['page-banner-link',$darkBlue,'Link text','',''],
					['page-banner-link-visited',$purple,'Visited link text','',''],
					['page-banner-link-hover',$darkBlue,'Link text on hover','',''],
					['page-banner-link-focus',$black,'Link text when focussed','',''],
					['page-banner-link-focus-background',$yellow,'Link background when focussed','',''],
					['page-banner-link-focus-underline',$black,'Link underline when focussed','',''],
				)
			],
			[
				"section_name" => "Cookie banner",
				"id" => "cookie-banner",
				"description" => "",
				"colours" => array(
					['cookie-settings-bg',$darkGrey,'Cookie settings (triangle) background','',''],
					['cookie-settings-text',$white,'Cookie settings (triangle) text','',''],
					['cookie-settings-hover-bg',$black,'Cookie settings (triangle) background on hover','',''],
					['cookie-settings-hover-text',$white,'Cookie settings (triangle) text on hover','',''],
					['cookie-settings-focus-bg',$yellow,'Cookie settings (triangle) background when focussed','',''],
					['cookie-settings-focus-text',$black,'Cookie settings (triangle) text when focussed','',''],
					['cookie-settings-focus-outline','transparent','Cookie settings (triangle) outline when focussed','Leave blank for none',''],
					['cookie-button-bg',$green,'Cookie banner button background','',''],
					['cookie-button-text',$white,'Cookie banner button text','',''],
					['cookie-button-hover-bg',$buttonHoverGreen,'Cookie banner button background on hover','',''],
					['cookie-button-hover-text',$white,'Cookie banner button text on hover','',''],
					['cookie-button-focus-bg',$yellow,'Cookie banner button background when focussed','',''],
					['cookie-button-focus-border',$black,'Cookie banner button border when focussed','',''],
					['cookie-button-focus-text',$black,'Cookie banner button text when focussed','',''],
					['cookie-secondary-button-bg',$lightGrey,'Cookie banner secondary button background','',''],
					['cookie-secondary-button-text',$black,'Cookie banner secondary button text','',''],
					['cookie-toggle-bg',$green,'Cookie toggle background','',''],
					['cookie-toggle-focus-bg',$buttonHoverGreen,'Cookie toggle background when focussed','',''],
					['cookie-toggle-text',$white,'Cookie toggle text','',''],
				)
			],
		);

		if ($sections) return $colour_array;

		$compiled_colour_array = array();

		for ($i = 0; $i < count($colour_array); $i++) {
			$compiled_colour_array = array_merge($compiled_colour_array,$colour_array[$i]["colours"]);
		}

		return $compiled_colour_array;
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
			$found_colour_count = 0;
			$missing_colour_array = [];
			$colour_array = hale_get_colours();
			$CSS_string = file_get_contents($CSSfileURL);
			for ($i=0;$i<count($colour_array);$i++) {
				if (strpos($CSS_string, $colour_array[$i][0]) === false) {
					trigger_error("Colour not found: ".$colour_array[$i][0]." auto-creating colour, set to default (".$colour_array[$i][1].")");
					//we add the missing colour variable with default value to missing colour string
					$missing_colours .= "\t--".$colour_array[$i][0].": ".$colour_array[$i][1].";\n";

					//add the missing colour to the array
					$missing_colour_array[] = $colour_array[$i][0];
				} else {
					$found_colour_count++;
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

				/********
				 * This next bit emails warnings about unset colours
				 */
				require_once get_template_directory() . '/inc/colour-email-warning.php';
				emailWarning($missing_colour_array,$found_colour_count,$i,"colours.php");
			} else {
				//if there are no missing colours, nothing needs to be done.
				//but we still touch the file so the surrounding if statement is not triggered and we don't have to do the get_file_contents each time
				touch($CSSfileURL);
			}
		}
	}

	hale_new_colour_check();
