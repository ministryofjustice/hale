<?php

/**
 * Adds an Dropdown (select) ACF Field for a specific post type. 
 * Extended fleixible version of hale_add_tax_select_acf_field()
 * Can be populated with taxonomy terms or meta fields
 *
 * @param object $post_type The post type object.
 * @param string $field_key The ACF field key.
 * @param string $field_label The ACF field label.
 * @param string $field_name The ACF field name.
 * @param bool $allow_multiple Whether to allow multiple selections.
 * @param string $post_type_field_key The ACF field key that sets the post type
 * @param string $field_group_key The field group key to add the field
 */
function hale_add_select_acf_field($post_type, $field_key, $field_label, $field_name, $allow_multiple, $post_type_field_key, $field_group_key, $field_choices) {

    $choices = [];

    if(array_key_exists("taxonomies", $field_choices) && $field_choices['taxonomies'] == true){
        
        $taxonomies = get_object_taxonomies($post_type->name, 'objects');

        foreach($taxonomies as $tax) {
            $choices[$tax->name] = $tax->label;
        }
    }

    if(array_key_exists("published-date", $field_choices) && $field_choices['published-date'] == true){
        $choices['published-date'] = 'Published date';
    }

    if(array_key_exists("acf-meta-fields", $field_choices) && $field_choices['acf-meta-fields'] == true){
        
        $groups = acf_get_field_groups(array('post_type' => $post_type->name)); 

        if(is_array($groups) && count($groups) > 0){
    
            foreach($groups as $group) {
    
                $fields = acf_get_fields($group['key']);
    
                if (empty($fields)) {
                    continue;
                }
    
                foreach($fields as $field){
                    
                    if($field['type'] == "date_picker"){
                        $choices['meta-' . $field['name']] = $field['label'];
                    }
                }
            }
        }
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