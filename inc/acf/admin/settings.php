<?php

/**
 * Add new toggles to the settings page
 * Add the new toggle setting to the field array and it will loop through
 * the ACF render field wrap function.
 * 
 * https://www.advancedcustomfields.com/resources/post-types-and-taxonomies/
 * 
 */
add_action('acf/post_type/basic_settings', function ($acf_post_type) {
    
    $fields = [
        'allow_document_upload' => [
            'label' => 'Document uploads',
            'instructions' => 'Allow the editor the ability to add documents to the post type.',
        ],
        'post_summary' => [
            'label' => 'Summary box',
            'instructions' => 'Add a summary section to the post.',
        ],
        'revision_date' => [
            'label' => 'Revision Date',
            'instructions' => 'Adds a revision date that can be used instead of the updated date',
        ]
    ];

    foreach ($fields as $name => $data) {
        acf_render_field_wrap([
            'label'        => $data['label'],
            'instructions' => $data['instructions'],
            'name'         => $name,
            'key'          => $name,
            'prefix'       => 'acf_post_type',
            'value'        => isset($acf_post_type[$name]) ? $acf_post_type[$name] : false,
            'type'         => 'true_false',
            'ui'           => 1,
        ]);
    }
});

/**
 * Register the new toggles
 */
add_filter('acf/post_type/registration_args', function ($args, $post_type) {
    // Define which properties to check within registration args
    $properties = ['allow_document_upload', 'post_summary', 'revision_date'];

    foreach ($properties as $property) {
        if (isset($post_type[$property])) {
            $args[$property] = (bool) $post_type[$property];
        }
    }

    return $args;
}, 10, 2);
