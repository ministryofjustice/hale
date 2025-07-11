<?php

/**
 * Adds an Dropdown (select) ACF Field for a specific post type. 
 * Extended fleixible version of hale_add_tax_select_acf_field()
 * Can be populated with taxonomy terms or meta fields
 *
 * @param string $field_key The ACF field key.
 * @param string $field_label The ACF field label.
 * @param string $field_name The ACF field name.
 * @param string $true e.g. Yes
 * @param string $false e.g. No
 * @param string $field_group_key The field group key to add the field
 */
function hale_add_boolean_acf_field($field_key, $field_label, $field_name, $true, $false, $field_group_key) {

    acf_add_local_field(array(
        'key' => 'field_' . $field_key,
        'label' =>  $field_label,
        'name' => $field_name,
        'aria-label' => '',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => array(
            $true   => $true,
            $false  => $false
        ),
        'default_value' => $false,
        'return_format' => 'value',
        'layout' => 'horizontal',
        'parent' => $field_group_key //Listing Page Details key
    ));

}