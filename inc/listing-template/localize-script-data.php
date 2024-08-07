<?php

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