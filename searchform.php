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
?>
<button id="search-show-hide" class="hale-header__mobile-controls hale-header__mobile-controls--search" aria-controls="search" aria-label="Open search" aria-expanded="false">
  <svg class="hale-icon hale-icon__search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
  </svg>
  <span><?php echo esc_html__( 'Search', 'hale' ); ?></span>
</button>
<div class="hale-header__search-wrap" <?php echo esc_attr( $wrap_search ); ?>>
	<form class="hale-header__search-form hale-search-invisible-contrast-correction" <?php echo esc_attr( $search_form ); ?> action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
		<label class="govuk-visually-hidden hale-search__hidden-search-label" for="<?php echo esc_attr( $search_field ); ?>"><?php esc_html_e( 'Search this website', 'hale' ); ?></label>
		<input class="hale-search__input govuk-input" id="<?php echo esc_attr( $search_field ); ?>" name="s" type="search" placeholder="<?php echo esc_attr__( 'Search', 'hale' ); ?>">
		<button class="hale-search__submit govuk-button govuk-button--secondary" type="submit">
			<svg class="hale-icon hale-icon__search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M19.71 18.29l-4.11-4.1a7 7 0 1 0-1.41 1.41l4.1 4.11a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 10a5 5 0 1 1 5 5 5 5 0 0 1-5-5z"></path>
			</svg>
			<span class="hale-search__button-text govuk-visually-hidden"><?php esc_html_e( 'Search', 'hale' ); ?></span>
		</button>
	</form>
</div>
