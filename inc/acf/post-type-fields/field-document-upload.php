<?php

/**
 * Registers a document upload field for post types that allow document uploads.
 * 
 * This function iterates over all registered post types and adds a custom ACF
 * field for document upload if the post type has 'allow_document_upload' enabled.
 * 
 * https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */
function hale_register_post_type_fields_document_upload()
{
    // Retrieve all post types as objects
    $post_types = get_post_types([], 'objects');

    foreach ($post_types as $key => $post_type) {
        // Check if document uploads are allowed for this post type
        if (isset($post_type->allow_document_upload) && $post_type->allow_document_upload == '1') {
            $post_type_name = $post_type->label;
            $post_type_key = $key;

            // Register a new ACF field for document upload
            acf_add_local_field([
                'key' => $post_type_key . '_attached_file',
                'label' => $post_type_name . ' file',
                'name' => 'post_attached_file',
                'parent' => $post_type_key . '_details',
                'type' => 'file',
                'instructions' => 'Add feature report for page',
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
            ]);

            // If a matching post type is found, the loop continues
            continue;
        }
    }
}

add_action('acf/init', 'hale_register_post_type_fields_document_upload');
