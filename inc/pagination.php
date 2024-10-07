<?php
/**
 * Replace css classes in standard navigation with Hale classes
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
function hale_archive_pagination($template = '', $custom_query = '')
{

    if(!empty($custom_query)){

        $query_to_paginate = $custom_query;
    }
    else {
        global $wp_query;

        $query_to_paginate = $wp_query;
    }
    $max_pages = $query_to_paginate->max_num_pages;

    if ($template == 'archive') {

        $current_page_number = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ($max_pages > 1) {
            ?>
            <nav class="archive-pagination-nav" aria-label="pagination">
                <ul class="archive-pagination">
                    <li class="archive-pagination-current-page">
                        <?php
                        echo "Page " . $current_page_number . " of " . $max_pages; ?>

                    </li>
                    <?php
                        if ($current_page_number > "1") {
                            echo "<li class='archive-pagination-prev-btn'>";
                            previous_posts_link('
                            <svg class="govuk-pagination__icon govuk-pagination__icon--prev" xmlns="http://www.w3.org/2000/svg" height="13" width="15" aria-hidden="true" focusable="false" viewBox="0 0 15 13">
                                <path d="m6.5938-0.0078125-6.7266 6.7266 6.7441 6.4062 1.377-1.449-4.1856-3.9768h12.896v-2h-12.984l4.2931-4.293-1.414-1.414z"></path>
                            </svg><span class="govuk-pagination__link-title">Previous<span class="govuk-visually-hidden"> page</span>
                            </span>
                            ', $max_pages);
                            echo "</li>";
                        }
                        if ($current_page_number < $max_pages) {
                            echo "<li class='archive-pagination-next-btn'>";
                            next_posts_link('
                            <span class="govuk-pagination__link-title">Next<span class="govuk-visually-hidden"> page</span></span><svg class="govuk-pagination__icon govuk-pagination__icon--next" xmlns="http://www.w3.org/2000/svg" height="13" width="15" aria-hidden="true" focusable="false" viewBox="0 0 15 13">
                                <path d="m8.107-0.0078125-1.4136 1.414 4.2926 4.293h-12.986v2h12.896l-4.1855 3.9766 1.377 1.4492 6.7441-6.4062-6.7246-6.7266z"></path>
                            </svg>
                            ', $max_pages);
                            echo "</li>";
                        }
                    ?>
                </ul>
            </nav>
            <?php
        }

    } else {

        $args = array(
            'prev_text' => '<span class="search__pagination-button-text">' . esc_html__('Previous', 'hale') . '</span>',
            'next_text' => '<span class="search__pagination-button-text">' . esc_html__('Next', 'hale') . '</span>',
        );

        $paginate = paginate_links(
            array(
                'mid_size' => 2,
                'prev_text' => $args['prev_text'],
                'next_text' => $args['next_text'],
                'type' => 'array',
            )
        );

        if ($paginate) {

            $pagination = '<hr class="govuk-section-break govuk-section-break--m govuk-section-break--visible"><nav class="moj-pagination" role="navigation" id="pagination-label"><p class="govuk-visually-hidden" aria-labelledby="pagination-label">Pagination navigation</p><ul class="moj-pagination__list">';

            $count = count($paginate) - 1;

            $first_item = array_slice($paginate, 0, 1)[0];
            $last_item = array_slice($paginate, $count, 1)[0];

            for ($i = 0; $i < count($paginate); $i++) {
                if (false !== strpos($paginate[$i], 'class="prev page-numbers"')) {
                    $pagination .= "<li class='moj-pagination__item moj-pagination__item--prev'>" . str_replace("prev page-numbers", "moj-pagination__link", "{$paginate[$i]}") . "</li>";
                } elseif (false !== strpos($paginate[$i], 'class="next page-numbers"')) {
                    $pagination .= "<li class='moj-pagination__item moj-pagination__item--next'>" . str_replace("next page-numbers", "moj-pagination__link", "{$paginate[$i]}") . "</li>";
                } elseif (false !== strpos($paginate[$i], 'class="page-numbers current"')) {
                    $pagination .= "<li class='moj-pagination__item moj-pagination__item--active'>{$paginate[$i]}</li>";
                } else {
                    $pagination .= "<li class='moj-pagination__item'>" . str_replace("page-numbers", "moj-pagination__link", "{$paginate[$i]}") . "</li>";
                }
            }

            if (false !== strpos($first_item, 'class="prev page-numbers"')) {
                array_shift($paginate);
            }
            if (false !== strpos($last_item, 'class="next page-numbers"')) {
                array_pop($paginate);
            }

            $pagination .= '</li></ul>';

            $pagination .= ' <p class="moj-pagination__results">';

            $pagination .= "Showing page <b>";
            $pagination .= (get_query_var('paged')) ? get_query_var('paged') : 1;
            $pagination .= "</b> of <b>";
            $pagination .= $max_pages;

            $pagination .= '</b></p></nav>';

            echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}

add_filter('previous_posts_link_attributes', 'hale_posts_previous_link_attributes');
function hale_posts_previous_link_attributes() {
    return 'class="govuk-link govuk-pagination__link" rel="prev"';
}

add_filter('next_posts_link_attributes', 'hale_posts_next_link_attributes');
function hale_posts_next_link_attributes() {
    return 'class="govuk-link govuk-pagination__link" rel="next"';
}
/**
 * Add in a previous and next functionality
 */
function hale_get_prev_next()
{
    echo '<nav role="navigation" aria-label="Pagination" class="gem-c-pagination">
  <ul class="gem-c-pagination__list">';
    echo hale_the_post_navigation(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</ul></nav>';
}

/**
 * Add in a method to go backwards and forwards between posts.
 *
 * @param array $args the arguments coming in to the function.
 *
 * @return string the output.
 */

function hale_the_post_navigation($args = array())
{
    $args = wp_parse_args(
        $args,
        array(
            'prev_text' => '
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
            'next_text' => '
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
            'in_same_term' => false,
            'excluded_terms' => '',
            'taxonomy' => 'category',
            'screen_reader_text' => __('Post navigation', 'hale'),
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
    if ($previous || $next) {
        $navigation = $previous . $next;
    }

    return $navigation;
}

/**
 * Filter wp_link_pages to do both next and number for post broken into multiple pages.
 */

add_filter('wp_link_pages_args', 'hale_link_pages_args_prevnext_add');
/**
 * Add prev and next links to a numbered link list
 *
 * @param array $args the values passed in to create the links.
 */
function hale_link_pages_args_prevnext_add($args)
{
    global $page, $numpages;
    $args['before'] .= '<nav class="pagination_split_post">'; // Put the pagenav links into their own region.
    $args['after'] .= '</nav>'; // End pagenav links.
    if ($page - 1) {
        // there is a previous page.
        $args['before'] .= _wp_link_page($page - 1) . $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';
    }

    if ($page < $numpages) {
        // there is a next page.
        $args['after'] = _wp_link_page($page + 1) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>' . $args['after'];
    }

    return $args;
}

//if listing page is url slug is same is post type slug it can cause a lisitng page pagination conflict
// e.g. if lisitng page is on https://example.com/news and post type slug is news. https://example.com/news/page/2 breaks.
function hale_fix_listing_pagination($query_string)
{
    // Don't do anything if in admin or json request
    if (is_admin() || wp_is_json_request()){
        return $query_string;
    }

    if (
        !empty($query_string['name']) && $query_string['name'] === 'page' &&
        !empty($query_string['page']) && 
        !empty($query_string['post_type'])
    ) {
        $post_type = $query_string['post_type'];
        $paged = $query_string['page'];
    
        // If the post type matches 'page', update the query string
        if (!empty($query_string[$post_type]) && $query_string[$post_type] === 'page') {

            unset($query_string['page']);
            unset($query_string['post_type']);
            unset($query_string['name']);
            unset($query_string[$post_type]);

            $query_string['pagename'] = $post_type;
            $query_string['paged'] = $paged;

        }
    }

    return $query_string;
}

add_filter('request', 'hale_fix_listing_pagination');