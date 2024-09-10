<?php
/**
 * Localizes taxonomy data for the listing page JavaScript.
 *
 * This function is responsible for preparing and passing taxonomy data from the server to the 
 * client-side JavaScript on the `page-listing.php` template. It retrieves the list of taxonomies 
 * specified by the 'listing_filters' ACF field, and fetches all terms 
 * associated with each taxonomy. This data is then made available to the `page-listing` script 
 * via the `listing_page_object` JavaScript object.
 *
 * @return void
 *
 * @example
 * // On the 'page-listing.php' template, this function will:
 * // - Fetch the list of taxonomies defined in the 'listing_filters' ACF field.
 * // - Retrieve all terms for each of these taxonomies, including empty terms.
 * // - Pass this data to a JavaScript object called 'listing_page_object'.
 * // - The 'listing_page_object.taxonomies' will contain an array of terms for each taxonomy.
 *
 * @hooked 'wp_enqueue_scripts' - Registers the function to run when scripts are enqueued.
 */
function hale_localize_page_listing_script() {
    if ( is_page_template('page-listing.php') ) {
        // Listing filters, taxonomies we want to filter our post by
        $listing_filters = get_field('listing_filters');

        if (!empty($listing_filters) && is_array($listing_filters)) {

            $all_terms = [];

            foreach ($listing_filters as $filter) {

                $terms = get_terms(array(
                    'taxonomy' => $filter,
                    'hide_empty' => false,
                ));
                
                if (!is_wp_error($terms)) {
                    $all_terms[$filter] = $terms;
                }
            }
        } else {
            $all_terms = [];
        }

        wp_localize_script(
            'page-listing',
            'listing_page_object',
            array(
                'taxonomies' => $all_terms
            )
        );
    }
}
 
add_action('wp_enqueue_scripts', 'hale_localize_page_listing_script', 20);