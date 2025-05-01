<?php
/**
 * The template for displaying search form
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

if ( ! empty( get_search_query() ) ) {
	$query = get_search_query();
} else {
	$query = '';
}

if ( ! isset( $GLOBALS['hale_search_form_counter'] ) ) {
	$GLOBALS['hale_search_form_counter'] = 1;
	$searchid                                   = '';
	$wrap_search                                = 'id=wrap-search';
	$search_form                                = 'id=search';
	$search_field                               = 'search-field';
	$close_search                               = 'id=close-search';
} else {
	$GLOBALS['hale_search_form_counter'] ++;
	$searchid      = $GLOBALS['hale_search_form_counter'];
	$wrap_search   = '';
	$close_search  = '';
	$search_form   = 'id=search' . $searchid . '';
	$search_field  = 'search-field' . $searchid;
}

/*
 * We have 2 search forms - the one in the header and the one shewn on both the search results and the 404 page.  
 * First thing to do is to know which one to display.
*/

if ($args['header'] == true) {
	// Search form in header
?>

	<button id="search-show-hide" class="hale-header__mobile-controls hale-header__mobile-controls--search" aria-controls="search" aria-label="Open search" aria-expanded="false">
		<svg class="hale-icon hale-icon--cross" xmlns="http://www.w3.org/2000/svg" viewBox="-2 2 29 20" aria-hidden="true" focusable="false">
			<path d='m13.41 12 5.3-5.29a1 1 0 1 0-1.42-1.42L12 10.59l-5.29-5.3a1 1 0 0 0-1.42 1.42l5.3 5.29-5.3 5.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l5.29-5.3 5.29 5.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z'></path>
		</svg>
		<svg class="hale-icon hale-icon--glass" xmlns="http://www.w3.org/2000/svg" viewBox="-2 2 26 18" aria-hidden="true" focusable="false">
			<path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
		</svg>
		<span><?php echo esc_html__( 'Search', 'hale' ); ?></span>
	</button>
	<div class="hale-header__search-wrap" <?php echo esc_attr( $wrap_search ); ?>>
		<form class="hale-header__search-form hale-search-invisible-contrast-correction" <?php echo esc_attr( $search_form ); ?> action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
			<label class="govuk-visually-hidden hale-search__hidden-search-label" for="<?php echo esc_attr( $search_field ); ?>"><?php esc_html_e( 'Search this website', 'hale' ); ?></label>
			<input class="hale-search__input govuk-input" id="<?php echo esc_attr( $search_field ); ?>" name="s" type="search" placeholder="<?php echo esc_attr__( 'Search website', 'hale' ); ?>" value="<?php esc_html_e($query);?>">
			<button class="hale-search__submit govuk-button govuk-button--secondary" type="submit">
				<svg class="hale-icon hale-icon__search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
				</svg>
				<span class="govuk-visually-hidden"><?php esc_html_e( 'Search website', 'hale' ); ?></span>
			</button>
		</form>
	</div>

<?php
} else {
	//Non-header search form doesn't need mobile show/hide button
?>
	<div class="hale-search" <?php echo esc_attr( $wrap_search ); ?>>
		<form class="hale-search__search-form hale-search-invisible-contrast-correction" <?php echo esc_attr( $search_form ); ?> action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
			<label class="govuk-visually-hidden hale-search__hidden-search-label" for="<?php echo esc_attr( $search_field ); ?>"><?php esc_html_e( 'Search this website', 'hale' ); ?></label>
			<input class="hale-search__input govuk-input" id="<?php echo esc_attr( $search_field ); ?>" name="s" type="search" placeholder="<?php echo esc_attr__( 'Search website', 'hale' ); ?>" value="<?php esc_html_e($query);?>">
			<button class="hale-search__submit govuk-button govuk-button--secondary" type="submit">
				<span class="hale-search__button-text"><?php esc_html_e( 'Search website', 'hale' ); ?></span>
			</button>
		</form>
	</div>

<?php
}
