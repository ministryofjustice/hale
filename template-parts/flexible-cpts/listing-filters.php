<?php
/**
 * ACF data generated side filter component
 * Used by page-listing.php
 *
*/
$listing_filters = $args['listing-filters'];

if (!empty($listing_filters) && is_array($listing_filters)) {
    foreach ($listing_filters as $filter) {

        if (taxonomy_exists($filter)) {
            get_template_part('template-parts/flexible-cpts/taxonomy-filter', false, ['taxonomy-name' => $filter ]);
        }
        else if($filter == 'published-date'){
            get_template_part('template-parts/flexible-cpts/date-filter', false, ['name' => "date_published", "label" => ""]);
        }
        else if(str_starts_with($filter, "meta-")){
            //METAFIELDS
            $field_name = str_replace("meta-", "", $filter);
            $listing_post_type = get_post_meta(get_the_ID(), 'listing_post_type', true);
            $label = "";
            
            $groups = acf_get_field_groups(array('post_type' => $listing_post_type)); 

            $fields = hale_get_post_type_date_fields($listing_post_type);

            if (!empty($fields)) {
                foreach($fields as $field){
                            
                    if($field['name'] == $field_name){
                        $label = $field['label'];
                    }
                }
            }

            get_template_part('template-parts/flexible-cpts/date-filter', false, ['name' => $field_name, "label" => $label]);
            
        }
    }
}
