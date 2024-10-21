<?php

/**
 * Checks the status of a specific ACF field for the current post type.
 *
 * This function is used to determine if a specific ACF custom field is set to '1'
 * for the currently active post type. It is typically used to check settings or features
 * enabled via ACF fields on a post type basis, such as whether document uploads or other
 * functionalities are allowed.
 *
 * @param string $field The name of the ACF field to check. This should correspond
 *                      to the exact field name as configured in ACF.
 *
 * @return bool Returns true if the specified field is enabled (i.e., set to '1')
 *              for the current post type. Returns false if the field is not enabled,
 *              the field does not exist, or there is no current post type determined.
 *
 */
function hale_get_acf_field_status($field, $post_type = "") {

    if ($post_type == "") $post_type = get_post_type();

    if (!$post_type) {
        return false;
    }

    $post_types = get_post_types([], 'objects');

    // Check if document uploads are allowed for this post type
    if (isset($post_types[$post_type]->$field) && $post_types[$post_type]->$field == '1') {
        return true;
    }

    return false;
}

/**
 * Checks the status of a specific setting for the current post type.
 *
 * @param string $setting The name of the setting to check.
 *
 * @return bool Returns value of setting for the current post type. Returns false if setting not found.
 *
 */
function hale_get_post_type_setting($setting) {
    $current_post_type = get_post_type();

    if (!$current_post_type) {
        return false;
    }

    $post_types = get_post_types([], 'objects');

    if (isset($post_types[$current_post_type]->$setting)) {
        return $post_types[$current_post_type]->$setting;
    }

    return false;
}