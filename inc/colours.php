<?php

	function get_colours() {
		//defaults
		$white = '#FFF';
		$black = '#0B0C0C';
		$yellow = '#FD0';
		$green = '#00703C';
		$buttonHoverGreen = '#005A30';
		$lightGrey = '#F3F2F1';
		$midGrey = '#B1B4B6';
		$darkGrey = '#505A5F';
	

		$colour_array = array(
			['heading-colour',$black,'Headers','Header colours (H1 & H2)'], //test item
			['cookie-button-bg',$green,'Cookie Banner Button Colour',''],
			['cookie-button-text',$white,'TestA','TestB'],
			['cookie-secondary-button-bg',$lightGrey,'TestA','TestB'],
			['cookie-secondary-button-text',$black,'TestA','TestB'],
			['cookie-button-hover-bg',$buttonHoverGreen,'TestA','TestB'],
			['cookie-button-hover-text',$white,'TestA','TestB'],
			['cookie-button-focus-bg',$yellow,'TestA','TestB'],
			['cookie-button-focus-border',$black,'TestA','TestB'],
			['cookie-button-focus-text',$black,'TestA','TestB'],
			['cookie-toggle-bg',$green,'TestA','TestB'],
			['cookie-toggle-focus-bg',$buttonHoverGreen,'TestA','TestB'],
			['cookie-toggle-text',$white,'TestA','TestB'],
			['cookie-settings-hover-bg',$black,'TestA','TestB'],
			['cookie-settings-hover-text',$white,'TestA','TestB'],
			['cookie-settings-focus-bg',$yellow,'TestA','TestB'],
			['cookie-settings-focus-text',$black,'TestA','TestB'],
			['mobile-controls',$white,'Mobile controls','The menu and the search icon'],
			['mobile-controls-focus',$black,'Mobile controls (focussed)','The menu and the search icon'],
			['cat-nav-arrows',$black,'TestA','TestB'],
			['header-link-focus-underline',$black,'Header Link Underline (focussed)','TestB'],
			['header-link-focus-highlight',$yellow,'Header Link Focus Highlight','TestB'],
			['header-link-focus',$black,'TestA','TestB'],
			['header-search-input-border',$white,'TestA','TestB'],
			['header-search-input-focus-bg',$white,'TestA','TestB'],
			['header-search-input-focus-border',$yellow,'TestA','TestB'],
			['header-search-input-active-bg',$white,'TestA','TestB'],
			['header-search-input-active-border',$yellow,'TestA','TestB'],
			['link-focus',$black,'TestA','TestB'],
			['link-focus-background',$yellow,'TestA','TestB'],
			['footer-link-focus-background',$yellow,'TestA','TestB'],
			['mojblocks-accordion-section-title-focus-bg',$yellow,'TestA','TestB'],
			['mojblocks-reveal-title-focus-bg',$yellow,'TestA','TestB'],
			['tag-bg',$lightGrey,'TestA','TestB'],
			['tag-text',$black,'TestA','TestB'],
			['tag-hover-bg',$midGrey,'TestA','TestB'],
			['tag-hover-text',$black,'TestA','TestB'],
			['tag-focus-bg',$yellow,'TestA','TestB'],
			['tag-focus-outline',$black,'TestA','TestB'],
			['tag-focus-text',$black,'TestA','TestB'],
		);

		return $colour_array;
	}
?>
