<?php
/**
 * Returns the filters for the hearing list.
 *
 * @return array $filters An array containing the filters for the hearing list.
 */
function hale_get_hearing_list_filters() {

    $filters = [
        [
            'filter_name' => 'hearing-witness',
            'filter_type' => 'multiselect-taxonomy',
            'taxonomy_key' => 'hearing-witness',
        ],
        [
            'filter_name' => 'published-date',
            'filter_type' => 'date-range'
        ],
        [
            'filter_name' => 'hearing-type',
            'filter_type' => 'select-taxonomy',
            'taxonomy_key' => 'hearing-type',
        ]
    ];

    return $filters;
}

function hale_validate_hearing_filters($filters) {

    $validated_filters = [];
    $validated_filters['error_count'] = 0;

    foreach ($filters as $filter) {
        if ($filter['filter_type'] == 'multiselect-taxonomy') {
            //$selected_terms = get_query_var($filter['filter_name']);
            //$selected_terms = explode(',', $selected_terms);

            /*$validated_terms = [];
            foreach ($selected_terms as $term_id) {
                if (is_numeric($term_id) && term_exists((int) $term_id, $filter['taxonomy_key'])) {
                    $validated_terms[] = (int) $term_id;
                }
            }

            $validated_filters[$filter['filter_name']] = $validated_terms;*/
        } else if ($filter['filter_type'] == 'date-range') {
            $from_date = get_query_var('from_date');
            $to_date = get_query_var('to_date');

            $start_date = null;
            $end_date = null;

            if(!empty($from_date)){

                $filter['value']['from_date'] = $from_date;

                $start_date = hale_validate_date($from_date);

                if(!$start_date){
                    $validated_filters['error_count']++;
                    $filter['errors'][] = ['message' => 'The Date from field must be a valid date', 'link' => '#from-date'];
                }
                else {
                    $filter['validated_value']['from_date'] = $start_date;
                }
            }

            if(!empty($to_date)){

              $filter['value']['to_date'] = $to_date;
               $end_date = hale_validate_date($to_date);

                if(!$end_date){
                    $validated_filters['error_count']++;
                    $filter['errors'][] = ['message' => 'The Date to field must be a valid date', 'link' => '#to-date'];
                }
                else {

                    $filter['validated_value']['to_date'] = $end_date;
                   
                }
            }
        } else if ($filter['filter_type'] == 'select-taxonomy') {
          /*  $selected_terms = get_query_var($filter['filter_name']);
            $selected_terms = explode(',', $selected_terms);

            $validated_terms = [];
            foreach ($selected_terms as $term_id) {
                if (is_numeric($term_id) && term_exists((int) $term_id, $filter['taxonomy_key'])) {
                    $validated_terms[] = (int) $term_id;
                }
            }

            $validated_filters[$filter['filter_name']] = $validated_terms;*/
        }

        $validated_filters[] = $filter;
    }

    return $validated_filters;
}

function hale_validate_date($date) {

    $formats = ['d-m-Y', 'd/m/Y', 'd m Y'];
    
    // Loop through each format and check validity
    foreach ($formats as $format) {
        $dateCheck = DateTime::createFromFormat($format, $date);
        if ($dateCheck) {
            return $dateCheck->getTimestamp();
        }
    }

    return false; // Invalid date
}