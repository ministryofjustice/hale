<?php

/**
 * ACF data generated side filter component
 * Used by page-listing.php
 *
*/
$listing_filters = $args['listing-filters'];

if (!empty($listing_filters) && is_array($listing_filters)) {
    foreach ($listing_filters as $filter) {

        // Handle different filter types
        if (taxonomy_exists($filter)) {

            get_template_part('template-parts/flexible-cpts/taxonomy-filter', false, [
                           'taxonomy-name' => $filter
            ]);

        } elseif ($filter === 'published-date') {
            // Handle published date filter
            get_template_part('template-parts/flexible-cpts/date-filter', false, [
                'name' => 'date_published',
                'label' => ''
            ]);
        } elseif (str_starts_with($filter, 'meta-')) {
            // Handle meta field filters
            $field_name = str_replace('meta-', '', $filter);
            $listing_post_type = get_post_meta(get_the_ID(), 'listing_post_type', true);

            // Get field label
            $label = '';
            $fields = hale_get_post_type_date_fields($listing_post_type);

            if (!empty($fields)) {
                foreach ($fields as $field) {
                    if ($field['name'] === $field_name) {
                        $label = $field['label'];
                        break;
                    }
                }
            }

            get_template_part('template-parts/flexible-cpts/date-filter', false, [
                'name' => $field_name,
                'label' => $label
            ]);
        }

    }
}
