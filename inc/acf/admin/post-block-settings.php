<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['block-settings'] = 'Block Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/block-settings', function ($acf_post_type) {
    
    acf_render_field_wrap(
        array(
            'label' => 'Restrict blocks',
            'instructions' => 'Blocks restricted to: Heading, Paragraph, List, Table, Image, Quote, Group, Footnotes, Separator, Spacer and File attachment',
            'name'         => 'restrict_blocks',
            'value'        => isset( $acf_post_type['restrict_blocks'] ) ? $acf_post_type['restrict_blocks'] : false,
            'prefix'       => 'acf_post_type',
            'type' => 'true_false',
            'key' => 'restrict_blocks',
            'ui' => true,
        )
    );
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {

    if ( isset( $post_type['restrict_blocks'] ) ) {
        $args['restrict_blocks'] = (bool) $post_type['restrict_blocks'];
    }

    return $args;
}, 10, 2 );
