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
function hale_add_field_groups() {

    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $post_types = get_post_types([], 'objects');
    $applicable_post_types = [];

    // Only find the post types using our fields
    foreach ($post_types as $slug => $post_type) {

        // Check if the custom field's toggle is turned on
        $fields = ['allow_document_upload', 'post_summary', 'enable_banner_on_single_view'];

        foreach ($fields as $field) {
            if (isset($post_type->$field) && $post_type->$field == '1') {
                $applicable_post_types[$slug] = $post_type;
                break; // Break as soon as any field meets the condition
            }
        }
    }

    // Loop through only the fields that have our custom toggles and apply 
    // the ACF group fields to the post.
    foreach ($applicable_post_types as $slug => $post_type) {
        acf_add_local_field_group([
            'key' => $slug . '_details',
            'title' => $post_type->label . ' Additional Settings',
            'fields' => [],
            'location' => [[
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $slug,
                ],
            ]],
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
    }
}

add_action('acf/init', 'hale_add_field_groups');
