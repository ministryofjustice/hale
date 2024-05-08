<?php
/**
 * Adds a custom ACF field to the basic settings of a post type for allowing document uploads.
 *
 * This hook adds a 'Document uploads' setting to each post type in ACF that supports it,
 * enabling or disabling document uploads.
 */
add_action('acf/post_type/basic_settings', function ($acf_post_type) {
    acf_render_field_wrap([
        'label'        => 'Document uploads',
        'instructions' => 'Allow the editor the ability to add documents to the post type.',
        'name'         => 'allow_document_upload',
        'prefix'       => 'acf_post_type',
        'value'        => isset($acf_post_type['allow_document_upload']) ? $acf_post_type['allow_document_upload'] : false,
        'type'         => 'true_false',
        'ui'           => 1,
    ]);
});

/**
 * Filters the registration arguments for custom post types to include document upload support.
 *
 * This filter adjusts the custom post type registration arguments based on the ACF field
 * for document uploads, effectively incorporating the support directly into the post type args.
 *
 * @param array $args Array of arguments for post type registration.
 * @param array $post_type Details of the post type being registered, including custom settings from ACF.
 * @return array Modified post type registration arguments.
 */
add_filter('acf/post_type/registration_args', function ($args, $post_type) {
    if (isset($post_type['allow_document_upload'])) {
        $args['allow_document_upload'] = (bool) $post_type['allow_document_upload'];
    }

    return $args;
}, 10, 2);


/**
 * Adds a custom ACF field to the basic settings of a post type adding a summary.
 */
add_action('acf/post_type/basic_settings', function ($acf_post_type) {
    acf_render_field_wrap([
        'label'        => 'Summary box',
        'instructions' => 'Add a summary section to the post.',
        'name'         => 'post_summary',
        'prefix'       => 'acf_post_type',
        'value'        => isset($acf_post_type['post_summary']) ? $acf_post_type['post_summary'] : false,
        'type'         => 'true_false',
        'ui'           => 1,
    ]);
});

/**
 * Filters the registration arguments for custom post types to include document upload support.
 *
 * This filter adjusts the custom post type registration arguments based on the ACF field
 * for document uploads, effectively incorporating the support directly into the post type args.
 *
 * @param array $args Array of arguments for post type registration.
 * @param array $post_type Details of the post type being registered, including custom settings from ACF.
 * @return array Modified post type registration arguments.
 */
add_filter('acf/post_type/registration_args', function ($args, $post_type) {
    if (isset($post_type['post_summary'])) {
        $args['post_summary'] = (bool) $post_type['post_summary'];
    }

    return $args;
}, 10, 2);

