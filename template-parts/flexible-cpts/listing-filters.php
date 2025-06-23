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
            get_template_part('template-parts/flexible-cpts/date-filter', false, []);
        }
        else {

        }
    }
}
