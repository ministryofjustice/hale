<?php
// Add custom toggles to the backend of ACF in the post type section

/**
 * Function to render a custom field setting for a post type in ACF.
 *
 * This function integrates a "Allow document uploads" option into the ACF
 * post type settings. The option appears as a true/false toggle and allows
 * users to enable or disable document uploads for the specific post type.
 *
 * @param array $acf_post_type An associative array containing post type settings.
 *                             The array should include a key 'allow_document_upload' 
 *                             that holds the initial value for this setting.
 */
function hale_post_type_basic_settings_allow_document_upload( $acf_post_type )
{
    acf_render_field_wrap(
        array(
            'label'        => __( 'Document uploads', 'acf' ),
            'type'         => 'true_false',
            'name'         => 'Allow document',
            'prefix'       => 'acf_post_type',
            'instructions' => __( 'Allow the editor the ability to add documents to the post type.', 'acf' ),
            'value'        => '',
            'ui'           => true
        )
    );

}

add_action( 'acf/post_type/basic_settings', 'hale_post_type_basic_settings_allow_document_upload');