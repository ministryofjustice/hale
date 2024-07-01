<?php

/**
 * Returns the taxonomy and terms details for the current post 
 *
 * @param array $taxonomies The taxonimies to check. If empty check all that are registered to post type.
 *
 * @return array Returns array of taxonomies that contain terms for current post
 *
 */
function hale_get_post_tax_details($taxonomies = array()){

    $tax_details = [];

    if(empty($taxonomies)){

        $current_post_type = get_post_type();

        $taxonomies = get_object_taxonomies($current_post_type);
    }

    foreach($taxonomies as $tax){

        $tax_obj = get_taxonomy( $tax );
        $tax_terms = get_the_terms( get_the_ID(), $tax);

        if(!empty($tax_terms)){

            $tax_details[] = [
                'slug' => $tax,
                'label' => $tax_obj->labels->singular_name,
                'terms' => $tax_terms
            ];
        }

    }

    return $tax_details;
}
