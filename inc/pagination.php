<?php
/**
 * Replace css classes in standard navigation with Nightingale classes
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
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
	echo '<nav role="navigation" aria-label="Pagination" class="gem-c-pagination">
  <ul class="gem-c-pagination__list">';
	echo nightingale_the_post_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</ul></nav>';
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
			'prev_text'          => '
                <span class="gem-c-pagination__link-title">
                  <svg class="gem-c-pagination__link-icon" xmlns="http://www.w3.org/2000/svg" height="13" width="17" viewBox="0 0 17 13">
                    <path d="m6.5938-0.0078125-6.7266 6.7266 6.7441 6.4062 1.377-1.449-4.1856-3.9768h12.896v-2h-12.984l4.2931-4.293-1.414-1.414z"></path>
                  </svg>
                  <span class="gem-c-pagination__link-text">
                    Previous
                  </span>
                </span>
                <span class="gem-c-pagination__link-divider govuk-visually-hidden">:</span>
                <span class="gem-c-pagination__link-label">
                  %title
                </span>',
			'next_text'          => '
                <span class="gem-c-pagination__link-title">
                  <svg class="gem-c-pagination__link-icon" xmlns="http://www.w3.org/2000/svg" height="13" width="17" viewBox="0 0 17 13">
                    <path d="m10.107-0.0078125-1.4136 1.414 4.2926 4.293h-12.986v2h12.896l-4.1855 3.9766 1.377 1.4492 6.7441-6.4062-6.7246-6.7266z"></path>
                  </svg>
                  <span class="gem-c-pagination__link-text">
                    Next
                  </span>
                </span>
                <span class="gem-c-pagination__link-divider govuk-visually-hidden">:</span>
                <span class="gem-c-pagination__link-label">
                  %title
                </span>',
			'in_same_term'       => false,
			'excluded_terms'     => '',
			'taxonomy'           => 'category',
			'screen_reader_text' => __( 'Post navigation', 'hale' ),
		)
	);

	$navigation = '';

	$previous = get_previous_post_link(
		'<li class="gem-c-pagination__item gem-c-pagination__item--previous">%link</li>',
		$args['prev_text'],
		$args['in_same_term'],
		$args['excluded_terms'],
		$args['taxonomy']
	);

	$next = get_next_post_link(
		'<li class="gem-c-pagination__item gem-c-pagination__item--next">%link</li>',
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
