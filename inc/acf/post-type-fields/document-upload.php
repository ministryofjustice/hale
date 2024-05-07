<?php
/**
 * Registers document upload fields for post types where document uploads are allowed.
 *
 * This function iterates over all registered post types and adds custom ACF fields.
 * 
 * The fields it adds are:
 * File upload
 * Summary
 * 
 * The condition met needs to be if the post type has 'allow_document_upload' enabled
 * on the settings page.
 */
function hale_register_post_type_fields_document_upload()
{
    $post_types = get_post_types([], 'objects');

    foreach ($post_types as $key => $post_type) {
        if (isset($post_type->allow_document_upload) && $post_type->allow_document_upload == '1') {

            $post_type_name = $post_type->label;
            $post_type_key = $key;

            $post_type_fields = [
                [
                    'key' => $post_type_key . '_attached_file',
                    'label' => $post_type_name . ' file',
                    'name' => 'post_attached_file',
                    'aria-label' => '',
                    'type' => 'file',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '20',
                    'mime_types' => 'pdf,doc,docx,rtf,odt,fodt,txt,xls,xlsx,ods,fods',
                ],
                [
                    'key' => $post_type_key . '_summary',
                    'label' => $post_type_name . ' Summary',
                    'name' => 'post_summary',
                    'aria-label' => '',
                    'type' => 'textarea',
                    'instructions' => '',
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
                ],
            ];

            if (!empty($post_type_fields)) {
                acf_add_local_field_group([
                    'key' => $post_type_key . '_details',
                    'title' => $post_type_name . ' details',
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
            }

            // Loop through all post types matching the condition
            continue;
        }
    }
}

add_action('init', 'hale_register_post_type_fields_document_upload', 10);

flush_rewrite_rules();
