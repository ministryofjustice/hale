<?php

/**
 * Registers a summary field for specific post types in the WordPress admin using ACF.
 *
 * This function iterates through all registered post types and adds a custom ACF textarea field
 * for entering a summary if the post type has an enabled summary feature flagged by 'post_summary' property.
 * 
 * https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 */
function hale_register_post_type_fields_summary()
{
    // Retrieve all registered post types as objects
    $post_types = get_post_types([], 'objects');

    foreach ($post_types as $key => $post_type) {
        if (isset($post_type->post_summary) && $post_type->post_summary == '1') {
            $post_type_name = $post_type->label;
            $post_type_key = $key;

            // Add the ACF field for the summary
            acf_add_local_field([
                'key' => $post_type_key . '_summary',
                'label' => $post_type_name . ' Summary',
                'name' => 'post_summary',
                'type' => 'textarea',
                'parent' => $post_type_key . '_details',
                'instructions' => 'Summary is used throughout the site and on this page',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ]);

            // Continue to the next post type
            continue;
        }
    }
}

add_action('acf/init', 'hale_register_post_type_fields_summary');
