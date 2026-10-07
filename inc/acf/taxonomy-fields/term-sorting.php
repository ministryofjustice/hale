<?php

/**
 * Taxonomy term sorting
 *
 * Applies the "Term Sort Order" setting (set in ACF -> Taxonomies -> Edit Taxonomy)
 * to term queries, so filters, dropdowns, autocompletes and term lists all use the
 * same order. The setting is registered in inc/acf/admin/taxonomy-settings.php.
 */

/**
 * Available term sort options
 *
 * @return array Sort option key => label
 */
function hale_get_term_sort_options() {
    return [
        ''          => 'Default (alphabetical)',
        'name_desc' => 'Reverse alphabetical (Z to A)',
        'natural'   => 'Natural number order (2 before 10)',
        'month'     => 'Month order (January to December)',
        'newest'    => 'Newest first (date created)',
        'oldest'    => 'Oldest first (date created)',
    ];
}

/**
 * Get the sort setting for a taxonomy
 *
 * @param string $taxonomy_name The taxonomy name.
 *
 * @return string The sort option key, empty string if not set
 */
function hale_get_taxonomy_term_sort($taxonomy_name) {
    $taxonomy = get_taxonomy($taxonomy_name);

    if (!$taxonomy || empty($taxonomy->term_sort)) {
        return '';
    }

    return $taxonomy->term_sort;
}

/**
 * Get the month number (1-12) and year from a term name
 *
 * Matches full and short English month names, e.g. "January", "Jan", "Sept 2024"
 *
 * @param string $name The term name.
 *
 * @return array|null [year, month] or null if no month found. Year is 0 when not present.
 */
function hale_get_term_month($name) {
    $months = [
        'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4, 'may' => 5, 'jun' => 6,
        'jul' => 7, 'aug' => 8, 'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12,
    ];

    $month_pattern = '/\b(jan(?:uary)?|feb(?:ruary)?|mar(?:ch)?|apr(?:il)?|may|june?|july?|aug(?:ust)?|sep(?:t(?:ember)?)?|oct(?:ober)?|nov(?:ember)?|dec(?:ember)?)\b\.?/i';

    if (!preg_match($month_pattern, $name, $month_match)) {
        return null;
    }

    $month = $months[strtolower(substr($month_match[1], 0, 3))];
    $year = preg_match('/\b(\d{4})\b/', $name, $year_match) ? (int) $year_match[1] : 0;

    return [$year, $month];
}

/**
 * Compare two terms by month order
 *
 * Terms are ordered by year (if present) then month. Terms without a
 * recognisable month are placed at the end in natural order.
 *
 * @param WP_Term $a
 * @param WP_Term $b
 *
 * @return int
 */
function hale_compare_terms_by_month($a, $b) {
    $a_month = hale_get_term_month($a->name);
    $b_month = hale_get_term_month($b->name);

    if ($a_month === null || $b_month === null) {
        if ($a_month !== $b_month) {
            return $a_month === null ? 1 : -1;
        }
        return strnatcasecmp($a->name, $b->name);
    }

    if ($a_month !== $b_month) {
        return $a_month <=> $b_month;
    }

    return strnatcasecmp($a->name, $b->name);
}

/**
 * Sort an array of terms using a sort option
 *
 * @param WP_Term[] $terms The terms to sort.
 * @param string $sort The sort option key.
 *
 * @return WP_Term[] The sorted terms
 */
function hale_sort_terms($terms, $sort) {
    switch ($sort) {
        case 'name_desc':
            usort($terms, fn($a, $b) => strcasecmp($b->name, $a->name));
            break;
        case 'natural':
            usort($terms, fn($a, $b) => strnatcasecmp($a->name, $b->name));
            break;
        case 'month':
            usort($terms, 'hale_compare_terms_by_month');
            break;
        case 'newest':
            usort($terms, fn($a, $b) => $b->term_id <=> $a->term_id);
            break;
        case 'oldest':
            usort($terms, fn($a, $b) => $a->term_id <=> $b->term_id);
            break;
    }

    return $terms;
}

/**
 * Checks the terms can be sorted, i.e. a list of WP_Term objects from a single taxonomy
 *
 * @param mixed $terms The terms to check.
 *
 * @return string The taxonomy name, empty string if the terms cannot be sorted
 */
function hale_get_sortable_terms_taxonomy($terms) {
    if (!is_array($terms) || count($terms) < 2) {
        return '';
    }

    $taxonomy_name = '';

    foreach ($terms as $term) {
        if (!$term instanceof WP_Term) {
            return '';
        }
        if ($taxonomy_name !== '' && $term->taxonomy !== $taxonomy_name) {
            return '';
        }
        $taxonomy_name = $term->taxonomy;
    }

    return $taxonomy_name;
}

/**
 * Apply the taxonomy sort setting to get_terms() results
 *
 * Also covers wp_dropdown_categories(), which uses get_terms().
 * Only applied when the query uses the default name ordering, so an explicit
 * orderby (e.g. count, include, meta_value) is respected. Paged queries are
 * skipped as sorting a single page would give the wrong order across pages.
 */
add_filter('get_terms', function ($terms, $taxonomies, $args) {
    if (!empty($args['number'])) {
        return $terms;
    }

    if (!empty($args['orderby']) && $args['orderby'] !== 'name') {
        return $terms;
    }

    $taxonomy_name = hale_get_sortable_terms_taxonomy($terms);

    if ($taxonomy_name === '') {
        return $terms;
    }

    $sort = hale_get_taxonomy_term_sort($taxonomy_name);

    if ($sort === '') {
        return $terms;
    }

    return hale_sort_terms($terms, $sort);
}, 10, 3);

/**
 * Apply the taxonomy sort setting to get_the_terms() results (terms assigned to a post)
 */
add_filter('get_the_terms', function ($terms, $post_id, $taxonomy) {
    if (hale_get_sortable_terms_taxonomy($terms) === '') {
        return $terms;
    }

    $sort = hale_get_taxonomy_term_sort($taxonomy);

    if ($sort === '') {
        return $terms;
    }

    return hale_sort_terms($terms, $sort);
}, 10, 3);
