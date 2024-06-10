<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['display-settings'] = 'Display Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/display-settings', function ($acf_post_type) {
    
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
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {
    if ( isset( $post_type['show_tax_on_single_view'] ) ) {
        $args['show_published_date_on_single_view'] = (bool) $post_type['show_published_date_on_single_view'];
    }
    if ( isset( $post_type['show_tax_on_single_view'] ) ) {
        $args['show_tax_on_single_view'] = (bool) $post_type['show_tax_on_single_view'];
    }
    if ( isset( $post_type['single_view_tax_style'] ) ) {
        $args['single_view_tax_style'] = $post_type['single_view_tax_style'];
    }

    return $args;
}, 10, 2 );
