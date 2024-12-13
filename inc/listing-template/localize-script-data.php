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


function hale_localize_hearing_list_scripts() {
    if ( is_page_template('page-hearing-list.php') ) {

        $all_terms = [];
        $term_names = [];
        $selected_terms = [];

        $tax_terms = get_terms(array(
            'taxonomy' => 'hearing-witness',
        ));
        
        $selected_terms_qry = get_query_var('hearing-witness');

        if(!empty($selected_terms_qry)){
            $selected_terms_ary = explode(",", $selected_terms_qry);

        

            if(!empty($selected_terms_ary)){
                foreach($selected_terms_ary as $term_id){

                    if(is_numeric($term_id) && term_exists((int) $term_id, 'hearing-witness')){
                        $selected_terms[] = (int) $term_id;
                    }
                }
            }
        }

        if(!empty($tax_terms)){

            foreach($tax_terms as $term) { 

                $all_terms[] = array(
                    'term_id' => $term->term_id,
                    'name' => $term->name
                );
    
                if(in_array($term->term_id, $selected_terms)){
                    continue;
                }
    
                $term_names[] = $term->name;
            }
        }
        
        wp_localize_script(
            'multiselect-filter',
            'multiselect_object',
            array(
                'all_terms' => $all_terms,
                'term_names' => $term_names,
                'selected_terms' => $selected_terms
            )
        );


    }
}
add_action('wp_enqueue_scripts', 'hale_localize_hearing_list_scripts', 20);