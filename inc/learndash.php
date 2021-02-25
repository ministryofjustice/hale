<?php
/**
 * Customised Learndash output markup
 *
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version   2.0 February 2021

 */

add_filter(
	'learndash_content',
	function ( $content, $post ) {
		// create empty find and replace arrays.
		$find    = array();
		$replace = array();
		// search for whitespace and trim it down for later searches.
		$find[]    = '/\s\s+/';
		$replace[] = ' ';
		// sort out styling page titles.
		$find[]    = '#<header><h1>([^"]+)</h1></header>#';
		$replace[] = '<header class="entry-header"><h1 class="entry-title">$1</h1></header>';
		// sort out radio styling.
		$find[]    = '#<label> <input class="wpProQuiz_questionInput" type="radio" name="([^"]+)" value="([^"]+)">([^<]+)<\/label>#';
		$replace[] = '<div class="govuk-radios__item"><input class="govuk-radios__input" type="radio" name="$1" value="$2"><label class="govuk-label govuk-radios__label">$3</label></div>';
		// sort out checkbox styling.
		$find[]    = '#<label> <input class="wpProQuiz_questionInput" type="checkbox" name="([^"]+)" value="([^"]+)">([^<]+)<\/label>#';
		$replace[] = '<div class="govuk-checkboxes__item"><input class="govuk-checkboxes__input" type="radio" name="$1" value="$2"><label class="govuk-label govuk-checkboxes__label">$3</label></div>';
		$content   = preg_replace( $find, $replace, $content );

		return $content;
	},
	10,
	2
);
