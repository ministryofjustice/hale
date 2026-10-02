<?php

/**
 * Add autocomplete toggle to the taxonomy settings page
 *
 * https://www.advancedcustomfields.com/resources/post-types-and-taxonomies/
 *
 */
add_action('acf/taxonomy/basic_settings', function ($acf_taxonomy) {

    acf_render_field_wrap([
        'label'        => 'Autocomplete',
        'instructions' => 'Enable autocomplete on all listing page filters using this taxonomy.',
        'name'         => 'autocomplete',
        'key'          => 'autocomplete',
        'prefix'       => 'acf_taxonomy',
        'value'        => isset($acf_taxonomy['autocomplete']) ? $acf_taxonomy['autocomplete'] : false,
        'type'         => 'true_false',
        'ui'           => 1,
    ]);
});

/**
 * Register the autocomplete toggle for taxonomies
 */
add_filter('acf/taxonomy/registration_args', function ($args, $taxonomy) {
    if (isset($taxonomy['autocomplete'])) {
        $args['autocomplete'] = (bool) $taxonomy['autocomplete'];
    }

    return $args;
}, 10, 2);

/**
 * Add term sort order select to the taxonomy settings page
 *
 * Sorting is applied in inc/acf/taxonomy-fields/term-sorting.php
 */
add_action('acf/taxonomy/basic_settings', function ($acf_taxonomy) {

    acf_render_field_wrap([
        'label'        => 'Term Sort Order',
        'instructions' => 'How terms in this taxonomy are ordered in filters, dropdowns and term lists.',
        'name'         => 'term_sort',
        'key'          => 'term_sort',
        'prefix'       => 'acf_taxonomy',
        'value'        => isset($acf_taxonomy['term_sort']) ? $acf_taxonomy['term_sort'] : '',
        'type'         => 'select',
        'choices'      => hale_get_term_sort_options(),
        'ui'           => 0,
    ]);
});

/**
 * Register the term sort order for taxonomies
 */
add_filter('acf/taxonomy/registration_args', function ($args, $taxonomy) {
    if (isset($taxonomy['term_sort']) && array_key_exists($taxonomy['term_sort'], hale_get_term_sort_options())) {
        $args['term_sort'] = $taxonomy['term_sort'];
    }

    return $args;
}, 10, 2);

//Adds new labels to taxonomy
//Found in Advanced Settings -> Labels
add_action('acf/taxonomy/render_settings_tab/labels', function ($acf_taxonomy) {

    acf_render_field_wrap(
        array(
            'type'         => 'text',
            'key'          => 'listing_page_filter',
            'name'         => 'listing_page_filter',
            'prefix'       => 'acf_taxonomy[labels]',
            'value'        => $acf_taxonomy['labels']['listing_page_filter'],
            'data'         => array(
                /* translators: %s Singular form of taxonomy name */
                'label'     => __('%s', 'acf'),
                'replace'   => 'singular',
            ),
            'label'        => __('Listing Page Filter', 'acf'),
            'instructions' => __('Displayed on listing page with a taxonomy filter', 'acf'),
            'placeholder'  => __('Tag', 'acf'),
        ),
        'div',
        'field'
    );

    acf_render_field_wrap(
        array(
            'type'         => 'text',
            'key'          => 'listing_page_subfilter',
            'name'         => 'listing_page_subfilter',
            'prefix'       => 'acf_taxonomy[labels]',
            'value'        => $acf_taxonomy['labels']['listing_page_subfilter'],
            'data'         => array(
                /* translators: %s Singular form of taxonomy name */
                'label'     => __('Sub %s', 'acf'),
                'replace'   => 'singular',
            ),
            'label'        => __('Listing Page Subfilter', 'acf'),
            'instructions' => __('Displayed on listing page when a taxonomy filter has sub terms', 'acf'),
            'placeholder'  => __('Subtag', 'acf'),
        ),
        'div',
        'field'
    );
});
