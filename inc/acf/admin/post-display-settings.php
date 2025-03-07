<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['display-settings'] = 'Display Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/display-settings', function ($acf_post_type) {

    $post_label = $acf_post_type['labels']['singular_name'] ?? "page of this type"; //used in hint text on line 138

    echo '<div class="acf-label"><label for="acf_post_type-admin_menu_parent" style="font-weight:500;">Single view</label></div>';
    echo '<div class="acf-field acf-field-seperator" data-type="seperator" style="margin-top: 15px;"></div>';
    
    acf_render_field_wrap(
        array(
            'label' => 'Show Published Date',
            'instructions' => 'Shows published date on the single view.',
            'name'         => 'show_published_date_on_single_view',
            'value'        => isset( $acf_post_type['show_published_date_on_single_view'] ) ? $acf_post_type['show_published_date_on_single_view'] : true,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'show_published_date_on_single_view',
            'ui' => true,
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Show Summary',
            'instructions' => 'Shows summary on the single view.',
            'name'         => 'show_summary_on_single_view',
            'value'        => isset( $acf_post_type['show_summary_on_single_view'] ) ? $acf_post_type['show_summary_on_single_view'] : true,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'show_summary_on_single_view',
            'ui' => true,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'post_summary',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Show full width heading',
            'instructions' => 'Moves the main page heading to the top of the page.',
            'name'         => 'full_width_heading',
            'value'        => isset( $acf_post_type['full_width_heading'] ) ? $acf_post_type['full_width_heading'] : false,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'full_width_heading',
            'ui' => true,
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Show Table of Contents',
            'instructions' => 'Shows table of contents at the side.',
            'name'         => 'show_toc_on_single_view',
            'value'        => isset( $acf_post_type['show_toc_on_single_view'] ) ? $acf_post_type['show_toc_on_single_view'] : false,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'show_toc_on_single_view',
            'ui' => true,
            'conditional_logic' => array(
				array(
					array(
						'field' => 'post_toc',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Number headings',
            'instructions' => 'Add numbers to the H2 headings.',
            'name'         => 'number_headings',
            'value'        => isset( $acf_post_type['number_headings'] ) ? $acf_post_type['number_headings'] : false,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'number_headings',
            'ui' => true,
            'conditional_logic' => array(
				array(
					array(
						'field' => 'post_number_headings',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Show Taxonomies',
            'instructions' => 'Shows taxonomy terms on the single view.',
            'name'         => 'show_tax_on_single_view',
            'value'        => isset( $acf_post_type['show_tax_on_single_view'] ) ? $acf_post_type['show_tax_on_single_view'] : false,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'show_tax_on_single_view',
            'ui' => true,
        )
    );
    acf_render_field_wrap(
        array(
            'label' => 'Single view taxonomy style',
            'instructions' => '',
            'name'         => 'single_view_tax_style',
            'prefix'       => 'acf_post_type',
            'value'        => isset( $acf_post_type['single_view_tax_style'] ) ? $acf_post_type['single_view_tax_style'] : '',
            'type'         => 'select',
            'choices' => array(
                'list' => 'List',
                'tags' => 'Tags',
            ),
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'show_tax_on_single_view',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        )
    );

    echo '<div class="acf-label"><label for="acf_post_type-admin_menu_parent" style="font-weight:500;">Page-specific banner</label></div>';
    echo '<div class="acf-field acf-field-seperator" data-type="seperator" style="margin-top: 15px;"></div>';

	acf_render_field_wrap(
        array(
            'label'        => 'Enable Page Banner',
            'instructions' => "Allows a page-specific banner to be added individually to each $post_label.",
            'name'         => 'enable_banner_on_single_view',
            'value'        => isset( $acf_post_type['enable_banner_on_single_view'] ) ? $acf_post_type['enable_banner_on_single_view'] : false,
            'prefix'       => 'acf_post_type',
            'type'         => 'true_false',
            'key'          => 'enable_banner_on_single_view',
            'ui'           => true,

        )
    );
    acf_render_field_wrap(
        array(
            'label'        => 'Maximum number of links which can be added to the banner',
            'instructions' => '',
            'name'         => 'single_view_banner_max_links',
            'prefix'       => 'acf_post_type',
            'value'        => isset( $acf_post_type['single_view_banner_max_links'] ) ? $acf_post_type['single_view_banner_max_links'] : '4',
            'type'         => 'range',
            'min'          => 0,
            'max'          => 12,
            'step'         => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'enable_banner_on_single_view',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            )
        )
    );
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {

    if ( isset( $post_type['show_published_date_on_single_view'] ) ) {
        $args['show_published_date_on_single_view'] = (bool) $post_type['show_published_date_on_single_view'];
    }
    else {
        $args['show_published_date_on_single_view'] = true;
    }

    if ( isset( $post_type['show_tax_on_single_view'] ) ) {
        $args['show_tax_on_single_view'] = (bool) $post_type['show_tax_on_single_view'];
    }
    if ( isset( $post_type['single_view_tax_style'] ) ) {
        $args['single_view_tax_style'] = $post_type['single_view_tax_style'];
    }

    if ( isset( $post_type['show_summary_on_single_view'] ) ) {
        $args['show_summary_on_single_view'] = $post_type['show_summary_on_single_view'];
    }
    else {
        $args['show_summary_on_single_view'] = true;
    }

    if ( isset( $post_type['full_width_heading'] ) ) {
        $args['full_width_heading'] = $post_type['full_width_heading'];
    }

    if ( isset( $post_type['show_toc_on_single_view'] ) ) {
        $args['show_toc_on_single_view'] = $post_type['show_toc_on_single_view'];
    }

    if ( isset( $post_type['number_headings'] ) ) {
        $args['number_headings'] = $post_type['number_headings'];
    }

    // Single view banner
    if ( isset( $post_type['enable_banner_on_single_view'] ) ) {
        $args['enable_banner_on_single_view'] = $post_type['enable_banner_on_single_view'];
    }
    else {
        $args['enable_banner_on_single_view'] = false;
    }
    if ( isset( $post_type['single_view_banner_max_links'] ) ) {
        $args['single_view_banner_max_links'] = $post_type['single_view_banner_max_links'];
    }
    return $args;
}, 10, 2 );
