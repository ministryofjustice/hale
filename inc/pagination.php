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
		'prev_text' => '<span class="search__pagination-button-text">' . esc_html__( 'Previous', 'nightingale' ) . '</span>',
		'next_text' => '<span class="search__pagination-button-text">' . esc_html__( 'Next', 'nightingale' ) . '</span>',
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

		$pagination = '<hr class="govuk-section-break govuk-section-break--m govuk-section-break--visible"><nav class="moj-pagination" role="navigation" id="pagination-label"><p class="govuk-visually-hidden" aria-labelledby="pagination-label">Pagination navigation</p><ul class="moj-pagination__list">';

		$count = count( $paginate ) - 1;

		$first_item = array_slice( $paginate, 0, 1 )[0];
		$last_item  = array_slice( $paginate, $count, 1 )[0];

    for ($i=0;$i<count( $paginate );$i++) {
      if (false !== strpos( $paginate[$i], 'class="prev page-numbers"' )) {
        $pagination .= "<li class='moj-pagination__item moj-pagination__item--prev'>".str_replace("prev page-numbers", "moj-pagination__link", "{$paginate[$i]}")."</li>";
      } elseif (false !== strpos( $paginate[$i], 'class="next page-numbers"' )) {
        $pagination .= "<li class='moj-pagination__item moj-pagination__item--next'>".str_replace("next page-numbers", "moj-pagination__link", "{$paginate[$i]}")."</li>";
      } elseif (false !== strpos( $paginate[$i], 'class="page-numbers current"' )) {
        $pagination .= "<li class='moj-pagination__item moj-pagination__item--active'>{$paginate[$i]}</li>";
      } else {
        $pagination .= "<li class='moj-pagination__item'>".str_replace("page-numbers", "moj-pagination__link", "{$paginate[$i]}")."</li>";
      }
    }

		if ( false !== strpos( $first_item, 'class="prev page-numbers"' ) ) {
			array_shift( $paginate );
		}
    if ( false !== strpos( $last_item, 'class="next page-numbers"' ) ) {
			array_pop( $paginate );
		}

		$pagination .= '</li></ul>';

		$pagination .= ' <p class="moj-pagination__results">';

		$pagination .= "Showing page <b>";
		$pagination .= (get_query_var('paged')) ? get_query_var('paged') : 1;
		$pagination .= "</b> of <b>";
		$pagination .= count( $paginate );

		$pagination .= '</b></p></nav>';

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
