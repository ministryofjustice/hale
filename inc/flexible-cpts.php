<?php
function hale_register_flexible_post_types()
{

    $cpts = get_field( 'custom_post_types', 'options' );

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){       
            hale_register_post_type($cpt);
        }
    }

}

add_action('init', 'hale_register_flexible_post_types', 10);

function hale_register_post_type($cpt){
    $post_type_name = $cpt['post_type_name'];
    $post_type_name_plural = $cpt['post_type_name_plural'];
    $post_type_key = $cpt['post_type_key'];
    $post_type_tax = $cpt['post_type_tax'];
    $post_type_menu_icon = $cpt['post_type_menu_icon'];
    

    if(empty($post_type_name)){
        return false;
    }

    if(empty($post_type_menu_icon)){
        $post_type_menu_icon = 'dashicons-admin-post';
    }

    $labels = array(
        'name' => _x($post_type_name_plural, 'Post Type General Name', 'hale'),
        'singular_name' => _x($post_type_name, 'Post Type Singular Name', 'hale'),
        'menu_name' => __($post_type_name_plural, 'hale'),
        'name_admin_bar' => __($post_type_name, 'hale'),
        'archives' => __($post_type_name . ' Archives', 'hale'),
        'attributes' => __($post_type_name . ' Attributes', 'hale'),
        'parent_item_colon' => __('Parent ' . $post_type_name . ':', 'hale'),
        'all_items' => __('All ' . $post_type_name_plural, 'hale'),
        'add_new_item' => __('Add New ' . $post_type_name, 'hale'),
        'add_new' => __('Add New', 'hale'),
        'new_item' => __('New ' . $post_type_name, 'hale'),
        'edit_item' => __('Edit ' . $post_type_name, 'hale'),
        'update_item' => __('Update ' . $post_type_name, 'hale'),
        'view_item' => __('View ' . $post_type_name, 'hale'),
        'view_items' => __('View ' . $post_type_name_plural, 'hale'),
        'search_items' => __('Search ' . $post_type_name_plural, 'hale'),
        'not_found' => __('Not found', 'hale'),
        'not_found_in_trash' => __('Not found in Trash', 'hale'),
        'featured_image' => __('Featured Image', 'hale'),
        'set_featured_image' => __('Set featured image', 'hale'),
        'remove_featured_image' => __('Remove featured image', 'hale'),
        'use_featured_image' => __('Use as featured image', 'hale'),
        'insert_into_item' => __('Insert into ' . $post_type_name, 'hale'),
        'uploaded_to_this_item' => __('Uploaded to this ' . $post_type_name, 'hale'),
        'items_list' => __($post_type_name_plural . ' list', 'hale'),
        'items_list_navigation' => __($post_type_name_plural  . ' list navigation', 'hale'),
        'filter_items_list' => __('Filter ' . $post_type_name_plural  . ' list', 'hale'),
    );

    $args = array(
        'label' => __($post_type_name, 'hale'),
        'description' => __('Contains details of ' . $post_type_name_plural, 'hale'),
        'labels' => $labels,
        'supports' => array('title', 'editor'),
        'taxonomies' => $post_type_tax,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => $post_type_menu_icon,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    register_post_type($post_type_key, $args);



}


function hale_tax_choices( $field ) {

    // Reset choices
    $field['choices'] = array();


    $args = array(
        'public'   => true
      ); 
    
    $taxonomies = get_taxonomies($args, 'objects');

    foreach($taxonomies as $tax) {
        $field['choices'][$tax->name] = $tax->label;
    }

    return $field;
}


add_filter('acf/load_field/name=post_type_tax', 'hale_tax_choices', 99);

/*
function hale_tax_choices2( $field ) {

    global $post;
    //Get the repeater field values
    $post_type = get_field('listing_post_type', $post->ID);

    // Reset choices
    $field['choices'] = array();

    $taxonomies = get_object_taxonomies($post_type, 'objects');

    foreach($taxonomies as $tax) {
        $field['choices'][$tax->name] = $tax->label;
    }

    return $field;
}*/

//add_filter('acf/load_field/name=listing_filters', 'hale_tax_choices2', 999);

function hale_post_type_choices( $field ) {

    // Reset choices
    $field['choices'] = array();


    $args = array(
        'public'   => true
      ); 
    
    $post_types = get_post_types($args, 'objects');

    foreach($post_types as $post_type) {
        $field['choices'][$post_type->name] = $post_type->label;
    }

    return $field;
}


add_filter('acf/load_field/name=listing_post_type', 'hale_post_type_choices', 99);


function hale_add_acf_fields() {

    $args = array(
        'public'   => true
      ); 
    
    $post_types = get_post_types($args, 'objects');

    
    foreach($post_types as $post_type) {

        $choices = array();
        $taxonomies = get_object_taxonomies($post_type->name, 'objects');

        foreach($taxonomies as $tax) {
            $choices[$tax->name] = $tax->label;
        }


    acf_add_local_field(array(
        'key' => 'field_' . $post_type->name . '_listing_filter',
        'label' =>  $post_type->label . ' Listing Filters',
        'name' => 'listing_filters',
        'aria-label' => '',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => 'field_65a710325ad17',
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
        'multiple' => 1,
        'allow_null' => 0,
        'ui' => 1,
        'ajax' => 0,
        'placeholder' => '',
        'parent' => 'group_65a71031ea4fb'
    ));

    }
    

}

//add_action('acf/input/admin_head', 'hale_add_acf_fields', 99);

add_action( 'init', 'hale_add_flexible_cpt_fields' );

function hale_add_flexible_cpt_fields() {

    $cpts = get_field( 'custom_post_types', 'options' );

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){       

            $post_type_name = $cpt['post_type_name'];
            $post_type_key = $cpt['post_type_key'];
            $object_type = $cpt['post_type_object_type'];
            if(!empty($object_type)){
                if($object_type == 'document'){
                    
                    acf_add_local_field_group( array(
                        'key' =>  $post_type_key . '_details',
                        'title' => $post_type_name . ' details',
                        'fields' => array(
                            array(
                                'key' => $post_type_key . 'attached_file',
                                'label' => $post_type_name . ' file',
                                'name' => 'post_attached_file',
                                'aria-label' => '',
                                'type' => 'file',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                                'library' => 'all',
                                'min_size' => '',
                                'max_size' => 20,
                                'mime_types' => 'pdf,doc,docx,rtf,odt,fodt,txt,xls,xlsx,ods,fods',
                            ),
                            array(
                                'key' => $post_type_key . '_summary',
                                'label' => $post_type_name . ' Summary',
                                'name' => 'post_summary',
                                'aria-label' => '',
                                'type' => 'textarea',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'maxlength' => '',
                                'rows' => '',
                                'new_lines' => '',
                            ),
                        ),
                        'location' => array(
                            array(
                                array(
                                    'param' => 'post_type',
                                    'operator' => '==',
                                    'value' => $post_type_key,
                                ),
                            ),
                        ),
                        'menu_order' => 0,
                        'position' => 'acf_after_title',
                        'style' => 'default',
                        'label_placement' => 'top',
                        'instruction_placement' => 'label',
                        'hide_on_screen' => '',
                        'active' => true,
                        'description' => '',
                        'show_in_rest' => 0,
                        'modified' => 1665497612,
                    ) );

                }
            }
        }
    }
    
}