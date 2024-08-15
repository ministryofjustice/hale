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
 * Includes a template file and makes specified variables available within that template.
 *
 * This function locates a template file and includes it, passing along any variables 
 * provided in the `$variables` array so they are accessible within the included template.
 *
 * @param string $template_path Path to the template file relative to the theme directory.
 * @param array $variables (Optional) An associative array of variables to be extracted and made available in the included template. Default is an empty array.
 */
function hale_include_template_with_variables($template_path, $variables = array()) {
    // Extract the variables to make them available in the included template
    if (!empty($variables) && is_array($variables)) {
        extract($variables);
    }

    // Locate the template file
    $template = locate_template($template_path, false, false);

    // Include the template file if it exists
    if ($template) {
        include($template);
    }
}

function get_taxonomy_term_ids($taxonomies) {
    // Initialize the array to hold the term IDs for each taxonomy
    $taxonomy_term_ids = [];

    if (!is_array($taxonomies)) {
        return;
    }

    foreach ($taxonomies as $taxonomy) {
        // Get terms associated with the current taxonomy
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false, // Include terms that have no posts associated
        ]);

        // Initialize an array to hold term IDs for the current taxonomy
        $term_ids = [];

        // Check if terms were retrieved successfully
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                // Add the term ID to the array
                $term_ids[] = $term->term_id;
            }
        }

        // Add the taxonomy's term IDs to the main array
        $taxonomy_term_ids[$taxonomy] = $term_ids;
    }

    // Return the array containing term IDs for each taxonomy
    return $taxonomy_term_ids;
}