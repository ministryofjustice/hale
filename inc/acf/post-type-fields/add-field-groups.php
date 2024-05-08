<?php

/**
 * Registers ACF field groups with additional settings for each registered post type.
 *
 * This function automatically adds a new ACF field group for each post type registered
 * in the WordPress installation, placing these field groups after the title in the admin.
 * Each field group is customized to the specifics of the post type.
 * 
 * https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 */
function hale_add_field_groups()
{
    $post_types = get_post_types([], 'objects');

    foreach ($post_types as $key => $post_type) {
        $post_type_name = $post_type->label;
        $post_type_key = $key;

        if( function_exists('acf_add_local_field_group') ):

        // Add details field group
        acf_add_local_field_group([
            'key' => $post_type_key . '_details',
            'title' => $post_type_name . ' additional settings',
            'fields' => $post_type_fields,
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => $post_type_key,
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0
        ]);

        endif;
        
        // Loop through all post types matching the condition
        continue;
    }
}

add_action('acf/init', 'hale_add_field_groups');
