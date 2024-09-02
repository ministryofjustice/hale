<?php
/**
 * Adds a filter term and its subtopic to the active filters array if they exist.
 *
 * This function checks if a given filter term and its associated subtopic term exist in the specified taxonomy.
 * If they do, they are added to the `$listing_active_filters` array, which tracks active filters applied to a listing.
 *
 * @param string $filter The base name of the filter (taxonomy) to check.
 *                       This string is also used to generate the subtopic filter key by appending '_subtopic'.
 * @param array &$listing_active_filters An array that holds active filters. This array is passed by reference
 *                                       and will be updated with the filter terms that exist.
 *
 * @return void
 *
 * @example
 * // Example usage:
 * $listing_active_filters = [];
 * hale_add_filter_term_if_exists('genre', $listing_active_filters);
 * // If 'genre' and 'genre_subtopic' query variables exist and correspond to valid terms,
 * // they will be added to $listing_active_filters.
 */
function hale_add_filter_term_if_exists($filter, &$listing_active_filters) {


    $taxonomy = get_taxonomy($filter);

    if (!$taxonomy) {
        return;
    }

    // Generate the subtopic filter key
    $filter_term_id_subtopic = $taxonomy->query_var . '_subtopic';

    // Retrieve the value of the main filter and subtopic query variables
    $filter_term_id = get_query_var($taxonomy->query_var);
    $filter_term_id_subtopic_value = get_query_var($filter_term_id_subtopic);

    // Combine them into an associative array
    $filter_terms = [
        'term_id' => $filter_term_id,
        'subtopic_term_id' => $filter_term_id_subtopic_value
    ];

    // Check if the main filter term ID is numeric and exists
    if (is_numeric($filter_terms['term_id'])) {
        $filter_terms['term_id'] = intval($filter_terms['term_id']);

        if (term_exists($filter_terms['term_id'], $filter)) {
            $listing_active_filters[] = array(
                'taxonomy' => $filter,
                'value' => $filter_terms['term_id']
            );
        }
    }

    // Check if the subtopic term ID is numeric and exists in the main taxonomy
    if (is_numeric($filter_terms['subtopic_term_id'])) {
        $filter_terms['subtopic_term_id'] = intval($filter_terms['subtopic_term_id']);

        if (term_exists($filter_terms['subtopic_term_id'], $filter)) {
            $listing_active_filters[] = array(
                'taxonomy' => $filter,
                'value' => $filter_terms['subtopic_term_id']
            );
        }
    }
}


/**
 * Retrieve term IDs for specified taxonomies.
 *
 * This function accepts an array of taxonomy names, retrieves all terms associated with each taxonomy,
 * and returns an associative array where the keys are the taxonomy names and the values are arrays 
 * of term IDs belonging to those taxonomies.
 *
 * @param array $taxonomies An array of taxonomy names. Each element should be a string representing a valid taxonomy.
 *
 * @return array|null An associative array where keys are taxonomy names and values are arrays of term IDs. 
 *                    Returns null if the input is not an array.
 *
 */
function get_taxonomy_term_ids($taxonomies) {
    // Initialize the arrays
    $taxonomy_term_ids = [];
    $term_ids = [];

    if (!is_array($taxonomies)) {
        return;
    }

    foreach ($taxonomies as $taxonomy) {
        // Get terms associated with the current taxonomy
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);

        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                // Add the term ID to the array
                $term_ids[] = $term->term_id;
            }
        }
        $taxonomy_term_ids[$taxonomy] = $term_ids;
    }

    // Return the array containing term IDs for each taxonomy
    return $taxonomy_term_ids;
}