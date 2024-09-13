<?php

//Adds new labels to taxonomy
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
                'label'     => __( '%s', 'acf' ),
                'replace'   => 'singular',
            ),
            'label'        => __( 'Listing Page Filter', 'acf' ),
            'instructions' => __( 'Displayed on listing page with a taxonomy filter', 'acf' ),
            'placeholder'  => __( 'Tag', 'acf' ),
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
                'label'     => __( 'Sub %s', 'acf' ),
                'replace'   => 'singular',
            ),
            'label'        => __( 'Listing Page Subfilter', 'acf' ),
            'instructions' => __( 'Displayed on listing page when a taxonomy filter has sub terms', 'acf' ),
            'placeholder'  => __( 'Subtag', 'acf' ),
        ),
        'div',
        'field'
    );
});

