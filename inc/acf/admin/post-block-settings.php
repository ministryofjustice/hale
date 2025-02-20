<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['block-settings'] = 'Block Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/block-settings', function ($acf_post_type) {
    
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
            'choices' => array(
                
                // Text blocks
                'core/code' => 'core/code',
                'core/footnotes' => 'core/footnotes',
                'core/heading' => 'core/heading',
                'core/list' => 'core/list',
                'core/list-item' => 'core/list-item',
                'core/paragraph' => 'core/paragraph',
                'core/table' => 'core/table',
                /*
                // Media blocks
                'core/cover',
                'core/file',
                'core/image',
                'core/media-text',
                'core/video',
    
                // Design blocks
                'core/buttons',
                'core/button',
                'core/columns',
                'core/group',
                'core/spacer',
    
                // Widgets
                'core/legacy-widget',
                'core/social-links',
                'core/social-link',
    
                // Embeds
                'core/embed',
                
                //Custom HTML
                'core/html',
    
                // Pattern blocks
                'core/block',
                'core/pattern',
    
                // MoJ blocks
                'mojblocks/accordion',
                'mojblocks/accordion-section',
                'mojblocks/banner',
                'mojblocks/card',
                'mojblocks/cta',
                'mojblocks/hero',
                'mojblocks/highlights-list',
                'mojblocks/quote',
                'mojblocks/reveal',
                'mojblocks/separator',
                'mojblocks/staggered-box',
                'mojblocks/featured-item',
                'mojblocks/auto-item-list'*/
            )
        )
    );
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {

    if ( isset( $post_type['restrict_blocks_multi'] ) ) {
        $args['restrict_blocks_multi'] = $post_type['restrict_blocks_multi'];
    }

    return $args;
}, 10, 2 );
