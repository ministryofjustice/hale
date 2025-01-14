<?php


add_filter( 'acf/post_type/additional_settings_tabs', function ( $tabs ) {
    $tabs['banner-settings'] = 'Banner Settings';

    return $tabs;
} );

add_action('acf/post_type/render_settings_tab/banner-settings', function ($acf_post_type) {

	$post_label = $acf_post_type['labels']['singular_name'];
	
    echo '<div class="acf-label"><label for="acf_post_type-admin_menu_parent" style="font-weight:500;">Single view banner</label></div>';
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
    acf_render_field_wrap(
        array(
            'label'        => 'Allow File Download Links',
            'instructions' => "If enabled, this will allow files to be directly linked from the page banner (not recommended)",
            'name'         => 'allow_file_download_links',
            'value'        => isset( $acf_post_type['allow_file_download_links'] ) ? $acf_post_type['allow_file_download_links'] : false,
            'prefix'       => 'acf_post_type',
            'type'         => 'true_false',
            'key'          => 'allow_file_download_links',
            'ui'           => true,

        )
    );
});

add_filter( 'acf/post_type/registration_args', function( $args, $post_type ) {
    if ( isset( $post_type['enable_banner_on_single_view'] ) ) {
        $args['enable_banner_on_single_view'] = $post_type['enable_banner_on_single_view'];
    }
    else {
        $args['enable_banner_on_single_view'] = false;
    }
    if ( isset( $post_type['single_view_banner_max_links'] ) ) {
        $args['single_view_banner_max_links'] = $post_type['single_view_banner_max_links'];
    }
    if ( isset( $post_type['allow_file_download_links'] ) ) {
        $args['allow_file_download_links'] = $post_type['allow_file_download_links'];
    }
    else {
        $args['allow_file_download_links'] = false;
    }
    return $args;
}, 10, 2 );
