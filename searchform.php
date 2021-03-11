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
	$query = 'Search';
}

if ( ! isset( $GLOBALS['nightingale_search_form_counter'] ) ) {
	$GLOBALS['nightingale_search_form_counter'] = 1;
	$searchid                                   = '';
	$toggle_search                              = 'id=toggle-search';
	$wrap_search                                = 'id=wrap-search';
	$search_form                                = 'id=search';
	$search_field                               = 'search-field';
	$close_search                               = 'id=close-search';
} else {
	$GLOBALS['nightingale_search_form_counter'] ++;
	$searchid      = $GLOBALS['nightingale_search_form_counter'];
	$toggle_search = '';
	$wrap_search   = '';
	$close_search  = '';
	$search_form   = 'id=search' . $searchid . '';
	$search_field  = 'search-field' . $searchid;
}
/*
/**/
?>
<button class="hale-header__mobile-controls hale-header__mobile-controls--search" <?php echo esc_attr( $toggle_search ); ?> aria-controls="search" aria-label="Open search" aria-expanded="false">
  <svg class="hale-icon hale-icon__search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
  </svg>
  <span><?php echo esc_html__( 'Search', 'nightingale' ); ?></span>
</button>
<div class="hale-header__search-wrap" <?php echo esc_attr( $wrap_search ); ?>>
	<form class="hale-header__search-form" <?php echo esc_attr( $search_form ); ?> action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
		<label class="govuk-visually-hidden" for="<?php echo esc_attr( $search_field ); ?>"><?php esc_html_e( 'Search this website', 'nightingale' ); ?></label>
		<input class="hale-search__input govuk-input" id="<?php echo esc_attr( $search_field ); ?>" name="s" type="search" placeholder="<?php echo esc_attr__( 'Search', 'nightingale' ); ?>">
		<button class="hale-search__submit govuk-button govuk-button--secondary" type="submit">
			<svg class="hale-icon hale-icon__search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
			</svg>
			<span class="hale-search__button-text"><?php esc_html_e( 'Search', 'nightingale' ); ?></span>
		</button>
	</form>
</div>
