<?php

	function get_colours() {
		//defaults
		$white = '#FFF';
		$black = '#0B0C0C';
		$yellow = '#FD0';
		$blue = '#1D70B8';
		$darkBlue = '#003078';
		$purple = '#4C2C92';
		$green = '#00703C';
		$buttonHoverGreen = '#005A30';
		$lightGrey = '#F3F2F1';
		$midGrey = '#B1B4B6';
		$darkGrey = '#505A5F';
		$currentPageBlue = '#1D8FEB'; //this has to be okay contrast against black, so is separated out from other blues
		$headerMenuLineGrey = '#2E3133';

		$colour_array = array(
			//header
			['header-bg',$black,'Header background','',''],
			['header-link',$white,'Header link','',''],
			['header-link-current',$currentPageBlue,'Header current page','',''],
			['header-link-hover-border',$white,'Header link hover underline','',''],
			['header-link-focus',$black,'Header link focus','',''],
			['header-link-focus-highlight',$yellow,'Header link focus highlight','',''],
			['header-link-focus-underline',$black,'Header link focus underline','',''],
			['header-link-hover-focus',$black,'Header link hover when focussed','',''],
			['header-link-mobile-border',$headerMenuLineGrey,'Mobile menu divider line','',''],
			['header-search-input-bg',$white,'Search box background','',''],
			['header-search-input-border',$white,'Search box border','',''],
			['header-search-input-focus-bg',$white,'Search box focus background','',''],
			['header-search-input-focus-border',$yellow,'Search box focus border','',''],
			['header-search-input-active-bg',$white,'Search box active background','',''],
			['header-search-input-active-border',$yellow,'Search box active border','',''],
			['header-search-btn-bg',$lightGrey,'Search button background','',''],
			['header-search-btn-icon',$black,'Search button icon','',''],
			['header-search-btn-hover-bg',$midGrey,'Search button hover background','',''],
			['header-search-btn-hover-icon',$black,'Search button hover icon','',''],
			['header-search-btn-focus-bg',$yellow,'Search button focus background','',''],
			['header-search-btn-focus-icon',$black,'Search button focus icon','',''],
			['header-submenu-arrow',$black,'Submenu arrow','',''],
			['header-submenu-arrow-focus',$black,'Submenu arrow focus','',''],
			['header-submenu-bg',$black,'Submenu background','Desktop only, narrow displays extend the main colour',''],
			['header-submenu-link-mobile',$black,'Submenu link (mobile)','',''],
			['header-submenu-link',$black,'Submenu link (desktop)','',''],
			['header-submenu-link-hover-underline',$black,'Submenu link hover underline','',''],
			['header-submenu-link-hover-underline',$black,'Submenu link hover underline','',''],

			//mobile controls
			['mobile-controls',$white,'Mobile controls','The menu and the search icon','svg'],
			['mobile-controls-focus',$black,'Mobile controls (focussed)','The menu and the search icon','svg'],

			//Misc
			['title-shading',$white,'Title shading','',''],
			['cat-nav-arrows',$black,'Category navication arrows','','svg'],

			//footer
			['footer-border',$midGrey,'Footer border','',''],
			['footer-background',$lightGrey,'Footer background','',''],
			['footer-link-focus-background',$yellow,'Footer link focus','',''],

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
			['button-focus',$yellow,'Button focus','',''],
			['button-focus-text',$black,'Button focus text','',''],
			['button-focus-outline',$yellow,'Button focus outline','',''],
			['button-active',$buttonHoverGreen,'Button active','',''],

			//mojblocks - these are usually things not found in GOV.UK sites
			['mojblocks-divider',$yellow,'Little divider bar','',''],

			['mojblocks-accordion-section-title',$blue,'Accordion titles and links','',''],
			['mojblocks-accordion-section-title-hover',$darkBlue,'Accordion titles and links hover','',''],
			['mojblocks-accordion-section-title-focus',$black,'Accordion titles and links focus','',''],
			['mojblocks-accordion-section-title-focus-bg',$yellow,'Accordion titles and links focus background','',''],
			['mojblocks-accordion-section-title-focus-shadow',$black,'Accordion titles and links focus underline','',''],
			['mojblocks-accordion-controls',$blue,'Accordion controls','',''],
			['mojblocks-accordion-controls-hover',$darkBlue,'Accordion controls hover','',''],

			['mojblocks-hero-bg',$white,'Hero background','This is usually obscured by the Hero image',''],

			['mojblocks-cta-bg',$white,'Call to action background','',''],
			['mojblocks-cta-title',$black,'Call to action title','',''],
			['mojblocks-cta-text',$black,'Call to action text','',''],

			['mojblocks-highlights-list-bg',$white,'Highlights list background','',''],
			['mojblocks-highlights-list-title',$black,'Highlights list title','',''],
			['mojblocks-highlights-list-text',$black,'Highlights list text','',''],

			['mojblocks-reveal-title',$blue,'Reveal title','',''],
			['mojblocks-reveal-title-hover',$darkBlue,'Reveal title hover','',''],
			['mojblocks-reveal-title-focus',$black,'Reveal title focus','',''],
			['mojblocks-reveal-title-focus-bg',$yellow,'Reveal title focus background','',''],
			['mojblocks-reveal-title-focus-shadow',$black,'Reveal title focus underline','',''],

			['mojblocks-staggered-box-bg',$darkGrey,'Staggered box background','',''],
			['mojblocks-staggered-box-title',$white,'Staggered box title','',''],
			['mojblocks-staggered-box-text',$white,'Staggered box text','',''],
			['mojblocks-staggered-box-btn-border',$lightGrey,'Staggered box button border','',''],
			['mojblocks-staggered-box-btn-bg',"transparent",'Staggered box button background','Leave blank for transparent',''],
			['mojblocks-staggered-box-btn-text',$white,'Staggered box button text','',''],
			['mojblocks-staggered-box-btn-hover-border',$black,'Staggered box button hover border','',''],
			['mojblocks-staggered-box-btn-hover-bg',$midGrey,'Staggered box button hover background','',''],
			['mojblocks-staggered-box-btn-hover-text',$black,'Staggered box button hover text','',''],
			['mojblocks-staggered-box-btn-focus-border',$black,'Staggered box button focus text','',''],
			['mojblocks-staggered-box-btn-focus-bg',$yellow,'Staggered box button focus text','',''],
			['mojblocks-staggered-box-btn-focus-text',$black,'Staggered box button focus text','',''],

			//Cookie banner
			['cookie-button-bg',$green,'Cookie banner button background','',''],
			['cookie-button-text',$white,'Cookie banner button text','',''],
			['cookie-secondary-button-bg',$lightGrey,'Cookie banner secondary button background','',''],
			['cookie-secondary-button-text',$black,'Cookie banner secondary button text','',''],
			['cookie-button-hover-bg',$buttonHoverGreen,'Cookie banner button hover background','',''],
			['cookie-button-hover-text',$white,'Cookie banner button hover text','',''],
			['cookie-button-focus-bg',$yellow,'Cookie banner button focus background','',''],
			['cookie-button-focus-border',$black,'Cookie banner button focus border','',''],
			['cookie-button-focus-text',$black,'Cookie banner button focus text','',''],
			['cookie-toggle-bg',$green,'Cookie toggle background','',''],
			['cookie-toggle-focus-bg',$buttonHoverGreen,'Cookie toggle focus background','',''],
			['cookie-toggle-text',$white,'Cookie toggle text','',''],
			['cookie-settings-hover-bg',$black,'Cookie settings hover background','',''],
			['cookie-settings-hover-text',$white,'Cookie settings hover text','',''],
			['cookie-settings-focus-bg',$yellow,'Cookie settings focus background','',''],
			['cookie-settings-focus-text',$black,'Cookie settings focus text','',''],

			//Tags
			['tag-bg',$lightGrey,'Tag background','',''],
			['tag-text',$black,'Tag text','',''],
			['tag-hover-bg',$midGrey,'Tag hover background','',''],
			['tag-hover-text',$black,'Tag hover text','',''],
			['tag-focus-bg',$yellow,'Tag focus background','',''],
			['tag-focus-outline',$black,'Tag focus outline','',''],
			['tag-focus-text',$black,'Tag focus text','','']
		);

		return $colour_array;
	}
?>
