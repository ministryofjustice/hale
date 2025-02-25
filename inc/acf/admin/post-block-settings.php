<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['block-settings'] = 'Block Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/block-settings', function ($acf_post_type) {
    
    $allowed_blocks = hale_get_allowed_blocks();

    //sets keys to the same as value e.g. core/paragraph => core/paragraph
    $allowed_blocks = array_combine($allowed_blocks, $allowed_blocks);

    acf_render_field_wrap(
        array(
            'label' => 'Restrict blocks',
            'instructions' => 'Restricts blocks in editor',
            'name'         => 'restrict_blocks',
            'value'        => isset( $acf_post_type['restrict_blocks_multi'] ) ? $acf_post_type['restrict_blocks_multi'] : [],
            'prefix'       => 'acf_post_type',
            'type' => 'select',
            'key' => 'restrict_blocks_multi',
            'ui' => true,
            'multiple' => 1,
            'choices' => $allowed_blocks,
        )
    );

    acf_render_field_wrap(
        array(
            'label' => 'Restrict mode',
            'instructions' => '',
            'name'         => 'restrict_blocks_mode',
            'prefix'       => 'acf_post_type',
            'value'        => isset( $acf_post_type['restrict_blocks_mode'] ) ? $acf_post_type['restrict_blocks_mode'] : '',
            'type'         => 'select',
            'choices' => array(
                'include' => 'Include',
                'exclude' => 'Exclude',
            ),
        )
    );
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {

    if ( isset( $post_type['restrict_blocks_multi'] ) ) {
        $args['restrict_blocks_multi'] = $post_type['restrict_blocks_multi'];
    }

    if ( isset( $post_type['restrict_blocks_mode'] ) ) {
        $args['restrict_blocks_mode'] = $post_type['restrict_blocks_mode'];
    }
    else {
        $args['restrict_blocks_mode'] = 'include';
    }

    return $args;
}, 10, 2 );
