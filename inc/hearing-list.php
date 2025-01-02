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