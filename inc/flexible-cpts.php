<?php

//Only allow acf fields of specified type - used to restrict listing display fields
function hale_get_allowed_field_types(){
    return [
        'text',
        'date_picker',
        'number'
    ];
}
//Adds frontend settings tab to custom field - only show if fields are added
add_filter( 'acf/field_group/additional_field_settings_tabs', function ( $tabs ) {
    $tabs['frontend-display-settings'] = 'Frontend Display Settings';

    return $tabs;
} );

//Defines what acf field types have frontend display settings
add_action( 'acf/field_group/render_field_settings_tab/frontend-display-settings/type=text', 'hale_field_frontend_display_settings');
add_action( 'acf/field_group/render_field_settings_tab/frontend-display-settings/type=date_picker', 'hale_field_frontend_display_settings');
add_action( 'acf/field_group/render_field_settings_tabfrontend-display-settings/type=number', 'hale_field_frontend_display_settings');


/**
 * Adds front end display settings for acf field
 */
function hale_field_frontend_display_settings($field)
{
    acf_render_field_setting(
        $field,
        array(
            'label'        => 'Show in single view?',
            'instructions' => '',
            'name'         => 'single_view',
            'type'         => 'true_false',
            'ui'           => 1,
            'default_value' => 1
        ),
        true
    );
}

/**
 * Populates post types to an ACF field.
 *
 * @param array $field The ACF field settings.
 * @return array The modified ACF field settings.
 */
function hale_populate_field_with_post_types( $field ) {

    // Reset choices
    $field['choices'] = array();

    $args = array(
        'public'   => true
      ); 
    
    $post_types = get_post_types($args, 'objects');

    if(!empty($post_types) && is_array($post_types)){
        foreach($post_types as $post_type) {
            $field['choices'][$post_type->name] = $post_type->label;
        }
    }

    return $field;
}

add_filter('acf/load_field/name=listing_post_type', 'hale_populate_field_with_post_types', 99);

/**
 * Creates Filter and Restrict ACF fields used on the listing page
 * A Dropdown (select) is created for each post type (listing assigned taxonomies) and only shown if the post type is selected
 *
 * @param object $tax The taxonomy object.
 */
function hale_add_listing_page_acf_fields() {

    $args = array(
        'public'   => true
      ); 
    
    $post_types = get_post_types($args, 'objects');

    foreach($post_types as $post_type) {
        hale_add_tax_select_acf_field($post_type, $post_type->name . '_listing_filter', $post_type->label . ' Listing Filters', 'listing_filters', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
        hale_add_custom_fields_select_acf_field($post_type, $post_type->name . '_list_item_fields', 'Display fields', 'list_item_fields', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
        hale_add_tax_select_acf_field($post_type, $post_type->name . '_display_terms_taxonomies', 'Display Terms', 'display_terms_taxonomies', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
        hale_add_tax_select_acf_field($post_type, $post_type->name . '_listing_restrict', 'Restrict ' . $post_type->label, 'listing_restrict', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
    }
    
    $taxonomies = get_taxonomies(['public' => true], 'objects');

    foreach ($taxonomies as $tax){
        hale_add_taxonomy_acf_field($tax);
    }
}

add_action( 'admin_init', 'hale_add_listing_page_acf_fields' );

/**
 * Adds an ACF taxonomy field for a specific taxonomy. This allows user to select terms. Currently only on listing page template.
 *
 * @param object $tax The taxonomy object.
 */
function hale_add_taxonomy_acf_field($tax) {

    $conditional_logic = [];

    $post_types = $tax->object_type;

    if(empty($post_types)){
        return;
    }
   

    foreach($post_types as $post_type) {
        $conditional_logic[] = array(
            array(
                'field' => 'field_' . $post_type .'_listing_restrict',
                'operator' => '==',
                'value' => $tax->name,
            ),
        );
    }
    acf_add_local_field(
        array(
            'key' => 'restrict_by_' . $tax->name,
            'label' => 'Restrict by ' . $tax->labels->singular_name,
            'name' => 'restrict_by_' . $tax->name,
            'aria-label' => '',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => $conditional_logic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => $tax->name,
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'id',
            'field_type' => 'multi_select',
            'allow_null' => 0,
            'multiple' => 0,
            'bidirectional_target' => array(
            ),
            'parent' => 'group_65a71031ea4fb' //Listing Page Details key
        )
    );

    //Hide sub terms
    add_filter('acf/fields/taxonomy/query/name=restrict_by_' . $tax->name, 'restrict_taxonomy_terms_to_top', 10, 3);

}

function restrict_taxonomy_terms_to_top( $args, $field, $post_id ) {

    // get only top level terms
    $args['parent'] = 0;

    return $args;
}

/**
 * Adds an Dropdown (select) ACF Field for a specific post type. Which lists acf fields and taxonomies assigned to a post type. Currently only on listing page template.
 *
 * @param object $post_type The post type object.
 * @param string $field_key The ACF field key.
 * @param string $field_label The ACF field label.
 * @param string $field_name The ACF field name.
 * @param bool $allow_multiple Whether to allow multiple selections.
 * @param string $post_type_field_key The ACF field key that sets the post type
 * @param string $field_group_key The field group key to add the field
 */
function hale_add_custom_fields_select_acf_field($post_type, $field_key, $field_label, $field_name, $allow_multiple, $post_type_field_key, $field_group_key) {

    $choices = array('published-date' => 'Published Date');

    if (isset($post_type->post_summary) && $post_type->post_summary == '1') {
        $choices[$post_type->name . '_summary'] = "Summary";
    }

    $taxonomies = get_object_taxonomies($post_type->name, 'objects');

    foreach($taxonomies as $tax) {
        $choices[$tax->name] = $tax->label;
    }

    $groups = acf_get_field_groups(array('post_type' => $post_type->name)); 

    $allowed_field_types = hale_get_allowed_field_types();

    
    if(is_array($groups) && count($groups) > 0){

        foreach($groups as $group) {

            $fields = acf_get_fields($group['key']);

            if(is_array($fields) && count($fields) > 0){

                foreach($fields as $field) {

                    if(in_array($field['type'], $allowed_field_types)){
                        $choices[$field['key']] = $field['label'];
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
                    'field' => $post_type_field_key, 
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
        'parent' => $field_group_key 
    ));

}

/**
 * Adds a custom query variables for flexible post types.
 *
 * @param array $vars The existing query variables.
 * @return array The modified query variables.
 */
function hale_flexible_post_types_add_query_vars_filter($vars)
{
    $vars[] = "listing_search";
    $vars[] = "from_date";
    $vars[] = "to_date";
    return $vars;
}

add_filter('query_vars', 'hale_flexible_post_types_add_query_vars_filter');

/**
 * Registers custom query variables for all public taxonomies.
 *
 * This function adds custom query variables for each public taxonomy and its corresponding 
 * subtopic to the list of recognized query variables. 
 *
 * @param array $vars The existing array of query variables.
 * @return array Modified array of query variables with added custom taxonomy and subtopic query variables.
 *
 * @example
 * // If you have a taxonomy called 'genre', this function will register:
 * // - 'genre' as the main query variable for the taxonomy.
 * // - 'genre_subtopic' as the query variable for subtopics within the 'genre' taxonomy.
 *
 * @hooked 'query_vars' - The WordPress filter that allows customization of query variables.
 */
function hale_add_custom_query_vars_filter($vars) {

    $taxonomies = get_taxonomies(array('public' => true), 'objects');

    foreach ($taxonomies as $taxonomy) {
        // Register the main taxonomy query var
        $vars[] = $taxonomy->query_var;

        // Register the subtopic query var
        $vars[] = $taxonomy->query_var . '_subtopic';
    }

    return $vars;
}

add_filter('query_vars', 'hale_add_custom_query_vars_filter');

//Makes sure Flexible CPTS are on category and tag archive pages
function hale_flexible_post_types_pre_get_posts($query) {

    if ( ! is_admin() && $query->is_main_query() ) {
        
        $tax = '';

        if(is_category()) {
            $tax = get_taxonomy('category');
        }

        if(is_tag()) {
            $tax = get_taxonomy('post_tag');
        }

        if(!empty($tax)){
            $query->set( 'post_type', $tax->object_type );
        }

    }    

    return $query;
}
add_filter('pre_get_posts', 'hale_flexible_post_types_pre_get_posts');

