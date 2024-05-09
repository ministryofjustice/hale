<?php


function hale_get_acf_field_status($field) {
    $current_post_type = get_post_type();

    if (!$current_post_type) {
        return false;
    }

    $post_types = get_post_types([], 'objects');

    // Check if document uploads are allowed for this post type
    if (isset($post_types[$current_post_type]->$field) && $post_types[$current_post_type]->$field == '1') {
        return true;
    }

    return false;
}
