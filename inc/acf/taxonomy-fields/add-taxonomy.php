<?php

/**
 * Adds an Dropdown (select) ACF Field for a specific post type. Which lists taxonomies assigned to a post type. Currently only on listing page template.
 *
 * @param object $post_type The post type object.
 * @param string $field_key The ACF field key.
 * @param string $field_label The ACF field label.
 * @param string $field_name The ACF field name.
 * @param bool $allow_multiple Whether to allow multiple selections.
 * @param string $post_type_field_key The ACF field key that sets the post type
 * @param string $field_group_key The field group key to add the field
 */
function hale_add_tax_select_acf_field($post_type, $field_key, $field_label, $field_name, $allow_multiple, $post_type_field_key, $field_group_key) {

    $choices = [];
    $taxonomies = get_object_taxonomies($post_type->name, 'objects');

    foreach($taxonomies as $tax) {
        $choices[$tax->name] = $tax->label;
    }

    acf_add_local_field(array(
        'key' => 'field_' . $field_key,
        'label' =>  $field_label,
        'name' => $field_name,
        'aria-label' => '',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => $post_type_field_key, //Listing Post Type Field
                    'operator' => '==',
                    'value' => $post_type->name,
                ),
            ),
        ),
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => $choices,
        'default_value' => array(
        ),
        'return_format' => 'value',
        'multiple' => $allow_multiple,
        'allow_null' => 0,
        'ui' => 1,
        'ajax' => 0,
        'placeholder' => '',
        'parent' => $field_group_key //Listing Page Details key
    ));

}