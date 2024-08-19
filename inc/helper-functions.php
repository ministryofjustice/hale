<?php

/**
 * Processes and adds the selected term to the active filters array.
 *
 * @param string $filter The name of the filter (taxonomy).
 * @param array $listing_active_filters Reference to the array where active filters are stored.
 */
function hale_add_filter_term_if_exists($filter, &$listing_active_filters) {
    // Retrieve the value of the query variable
    $filter_term_id = get_query_var($filter);

    // Check if the filter term ID is numeric
    if (is_numeric($filter_term_id)) {
        // Convert to integer
        $filter_term_id = intval($filter_term_id);

        // Check if the term exists in the specified taxonomy
        if (term_exists($filter_term_id, $filter)) {
            // Set the selected term ID
            $selected_term_id = $filter_term_id;

            // Add to active filters array
            $listing_active_filters[] = array(
                'taxonomy' => $filter,
                'value' => $filter_term_id
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