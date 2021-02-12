<?php
/**
 * Replace css classes in standard navigation with Nightingale classes
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.1 21st August 2019
 **/

/**
 * Paginate archived pages
 */
function nightingale_archive_pagination() {

	$args = array(
		'prev_text' => '<svg aria-hidden="true" class="search__pagination-arrow" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.76085 18.1317C9.34664 18.7175 10.2964 18.7175 10.8822 18.1317C11.468 17.5459 11.468 16.5962 10.8822 16.0104L8.76085 18.1317ZM2.75044 10L1.68978 8.93934C1.104 9.52513 1.104 10.4749 1.68978 11.0607L2.75044 10ZM10.8822 3.98959C11.468 3.40381 11.468 2.45406 10.8822 1.86827C10.2964 1.28249 9.34664 1.28249 8.76085 1.86827L10.8822 3.98959ZM10.8822 16.0104L3.8111 8.93934L1.68978 11.0607L8.76085 18.1317L10.8822 16.0104ZM3.8111 11.0607L10.8822 3.98959L8.76085 1.86827L1.68978 8.93934L3.8111 11.0607Z" fill="#1976D2"/></svg><span class="search__pagination-button-text">' . esc_html__( 'Previous', 'nightingale' ) . '</span>
								<span class="govuk-visually-hidden">:</span>',
		'next_text' => '<span class="search__pagination-button-text">' . esc_html__( 'Next', 'nightingale' ) . '</span>
								<svg aria-hidden="true" class="search__pagination-arrow" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.0516 1.86827C10.4659 1.28249 9.51612 1.28249 8.93033 1.86827C8.34454 2.45406 8.34454 3.40381 8.93033 3.98959L11.0516 1.86827ZM17.0621 10L18.1227 11.0607C18.7085 10.4749 18.7085 9.52513 18.1227 8.93934L17.0621 10ZM8.93033 16.0104C8.34454 16.5962 8.34454 17.5459 8.93033 18.1317C9.51612 18.7175 10.4659 18.7175 11.0516 18.1317L8.93033 16.0104ZM8.93033 3.98959L16.0014 11.0607L18.1227 8.93934L11.0516 1.86827L8.93033 3.98959ZM16.0014 8.93934L8.93033 16.0104L11.0516 18.1317L18.1227 11.0607L16.0014 8.93934Z" fill="#1976D2"/></svg>',
	);

	$paginate = paginate_links(
		array(
			'mid_size'  => 2,
			'prev_text' => $args['prev_text'],
			'next_text' => $args['next_text'],
			'type'      => 'array',
		)
	);

	if ( $paginate ) {

		$pagination = '<div class="navigation"><nav class="nhsuk-pagination" role="navigation" aria-label="Pagination"><ul class="nhsuk-list nhsuk-pagination__list">';

		$count = count( $paginate ) - 1;

		$first_item = array_slice( $paginate, 0, 1 )[0];
		$last_item  = array_slice( $paginate, $count, 1 )[0];

		if ( false !== strpos( $last_item, 'class="next page-numbers"' ) ) {

			$pagination .= "<li class='search__pagination-button search__pagination-button--next'>{$last_item}</li>";
			array_pop( $paginate );
		}

		if ( false !== strpos( $first_item, 'class="prev page-numbers"' ) ) {

			$pagination .= "<li class='search__pagination-button search__pagination-button--previous'>{$first_item}</li>";
			array_shift( $paginate );

		}

		$pagination .= "<li class='search__pagination-text'>";

		$pagination .= "Page ";
		$pagination .= (get_query_var('paged')) ? get_query_var('paged') : 1;
		$pagination .= " of ";
		$pagination .= count( $paginate );

		$pagination .= '</li></ul></nav></div>';

		echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Add in a previous and next functionality
 */
function nightingale_get_prev_next() {
	echo '<div class="navigation">
	<nav class="nhsuk-pagination" role="navigation" aria-label="Pagination">
  <ul class="nhsuk-list nhsuk-pagination__list">';
	echo nightingale_the_post_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</ul></nav></div>';
}

/**
 * Add in a method to go backwards and forwards between posts.
 *
 * @param array $args the arguments coming in to the function.
 *
 * @return string the output.
 */
function nightingale_the_post_navigation( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'prev_text'          => '<span class="nhsuk-pagination__title">Previous</span>
									<span class="govuk-visually-hidden">:</span>
									<span class="nhsuk-pagination__page">%title</span>
									<svg class="nhsuk-icon nhsuk-icon__arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
									  <path d="M4.1 12.3l2.7 3c.2.2.5.2.7 0 .1-.1.1-.2.1-.3v-2h11c.6 0 1-.4 1-1s-.4-1-1-1h-11V9c0-.2-.1-.4-.3-.5h-.2c-.1 0-.3.1-.4.2l-2.7 3c0 .2 0 .4.1.6z"></path>
									</svg>',
			'next_text'          => '<span class="nhsuk-pagination__title">Next</span>
									<span class="govuk-visually-hidden">:</span>
									<span class="nhsuk-pagination__page">%title</span>
									<svg class="nhsuk-icon nhsuk-icon__arrow-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
									  <path d="M19.6 11.66l-2.73-3A.51.51 0 0 0 16 9v2H5a1 1 0 0 0 0 2h11v2a.5.5 0 0 0 .32.46.39.39 0 0 0 .18 0 .52.52 0 0 0 .37-.16l2.73-3a.5.5 0 0 0 0-.64z"></path>
									</svg>',
			'in_same_term'       => false,
			'excluded_terms'     => '',
			'taxonomy'           => 'category',
			'screen_reader_text' => __( 'Post navigation', 'nightingale' ),
		)
	);

	$navigation = '';

	$previous = get_previous_post_link(
		'<li class="nhsuk-pagination-item--previous">%link</li>',
		$args['prev_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	$next = get_next_post_link(
		'<li class="nhsuk-pagination-item--next">%link</li>',
		$args['next_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	// Only add markup if there's somewhere to navigate to.
	if ( $previous || $next ) {
		$navigation = $previous . $next;
	}

	return $navigation;
}

/**
 * Filter wp_link_pages to do both next and number for post broken into multiple pages.
 */

add_filter( 'wp_link_pages_args', 'nightingale_link_pages_args_prevnext_add' );
/**
 * Add prev and next links to a numbered link list
 *
 * @param array $args the values passed in to create the links.
 */
function nightingale_link_pages_args_prevnext_add( $args ) {
	global $page, $numpages;
	$args['before'] .= '<nav class="pagination_split_post">'; // Put the pagenav links into their own region.
	$args['after']  .= '</nav>'; // End pagenav links.
	if ( $page - 1 ) {
		// there is a previous page.
		$args['before'] .= _wp_link_page( $page - 1 ) . $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';
	}

	if ( $page < $numpages ) {
		// there is a next page.
		$args['after'] = _wp_link_page( $page + 1 ) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>' . $args['after'];
	}

	return $args;
}
