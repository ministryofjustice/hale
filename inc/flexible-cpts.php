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

/*** Prototype Code - adding setting to field group */

add_filter( 'acf/field_group/additional_group_settings_tabs', function ( $tabs ) {
    $tabs['permissions'] = 'Permissions';

    return $tabs;
} );


add_action( 'acf/field_group/render_group_settings_tab/permissions', 'hale_field_group_permissions_settings');

/**
 * Adds permissons settings for acf field group
 */
function hale_field_group_permissions_settings($field_group)
{
    acf_render_field_wrap(
        array(
            'label'        => __( 'Core group', 'acf' ),
            'instructions' => '',
            'type'         => 'true_false',
            'name'         => 'core',
            'prefix'       => 'acf_field_group',
            'value'        => $field_group['core'],
            'ui'           => 1,
      
        )
    );

}

/*** END Prototype Code */

/**
 * Registers flexible post types based on the settings in the CPT and Taxonomy options page.
 */
function hale_register_flexible_post_types()
{

    $cpts = get_field( 'custom_post_types', 'options' );

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){       
            hale_register_post_type($cpt);
        }
    }

    //Add custom fields to post types depending on object type
    hale_add_flexible_post_type_fields();

    // Check if CPT settings were updated
    $options_updated = get_option('hale_cpt_settings_updated');

    if(!empty($options_updated)){
        // Flush rewrite rules and reset the update flag
        flush_rewrite_rules();
        update_option('hale_cpt_settings_updated', 0);

        //TO DO - update relevanssi
    }

}

add_action('init', 'hale_register_flexible_post_types', 10);

/**
 * Registers a custom post type based on the provided settings.
 *
 * @param array $cpt Settings for the custom post type.
 */
function hale_register_post_type($cpt){

    $opject_types = ['simple', 'news', 'document'];

    $post_type_name = $cpt['post_type_name'];
    $post_type_name_plural = $cpt['post_type_name_plural'];
    $post_type_key = $cpt['post_type_key'];
    $post_type_tax = $cpt['post_type_tax'];
    $post_type_menu_icon = $cpt['post_type_menu_icon'];
    $post_type_object_type = $cpt['post_type_object_type'];

    if (array_key_exists('post_type_single_view', $cpt)) {
        $post_type_single_view = $cpt['post_type_single_view'];

        if($post_type_single_view !== false){
            $post_type_single_view = true;
        }

    }
    else {
        $post_type_single_view = true;
    }
    
    if(empty($post_type_name) || empty($post_type_name_plural) || empty($post_type_key) || !in_array($cpt['post_type_object_type'], $opject_types)){
        return false;
    }

    if(empty($post_type_menu_icon)){
        $post_type_menu_icon = 'dashicons-admin-post';
    }
    
    $post_type_supports = array('title');

    if($post_type_single_view){
        $post_type_supports[] = 'editor';
    }
    
    if($post_type_object_type == 'news'){
        $post_type_supports[] = 'thumbnail';
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
        'supports' => $post_type_supports,
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
        'publicly_queryable' => $post_type_single_view,
        'capability_type' => 'page',
    );

    register_post_type($post_type_key, $args);

}

/**
 * Add Custom Fields to Flexible Post Types depending on their 'object type'
 *
 */
function hale_add_flexible_post_type_fields() {

    $cpts = get_field( 'custom_post_types', 'options' );

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){       

            $post_type_name = $cpt['post_type_name'];
            $post_type_key = $cpt['post_type_key'];
            $object_type = $cpt['post_type_object_type'];
            if(!empty($object_type)){

                $post_type_fields = [];
                
                if($object_type == 'news'){
                    $post_type_fields = array(
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
                        array(
                            'key' => $post_type_key . '_show_summary',
                            'label' => 'Show Summary on single view',
                            'name' => 'post_show_summary',
                            'aria-label' => '',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 1,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                            'ui' => 1,
                        ),
                        array(
                            'key' => $post_type_key . '_show_author',
                            'label' => 'Show Author',
                            'name' => 'post_show_author',
                            'aria-label' => '',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                            'ui' => 1,
                        ),
                    );
                }
                else if ($object_type == 'document'){
                    $post_type_fields = array(
                        array(
                            'key' => $post_type_key . '_attached_file',
                            'label' => $post_type_name . ' file',
                            'name' => 'post_attached_file',
                            'aria-label' => '',
                            'type' => 'file',
                            'instructions' => '',
                            'required' => 0,
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
                    );
                } 
                else { //simple post type
                    $post_type_fields = array(
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
                        )
                        );
                }

                if(!empty($post_type_fields)){
                    
                    acf_add_local_field_group( array(
                        'key' =>  $post_type_key . '_details',
                        'title' => $post_type_name . ' details',
                        'fields' => $post_type_fields,
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
                        'show_in_rest' => 0
                    ) );
                }

                
            }
        }
    }
    
}

/**
 * Populates taxonomies to an ACF field.
 *
 * @param array $field The ACF field settings.
 * @return array The modified ACF field settings.
 */
function hale_populate_field_with_taxonomies( $field ) {

    // Reset choices
    $field['choices'] = array();


    $args = array(
        'public'   => true
      ); 
    
    $taxonomies = get_taxonomies($args, 'objects');

    foreach($taxonomies as $tax) {
        $field['choices'][$tax->name] = $tax->label . ' ( ' . $tax->name . ' )';
    }

    return $field;
}


add_filter('acf/load_field/name=post_type_tax', 'hale_populate_field_with_taxonomies', 99);

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
 * Updates flag when the CPT options page is saved.
 *
 * @param int $post_id The post ID.
 * @param string $menu_slug The menu slug.
 */
function hale_save_cpt_settings( $post_id, $menu_slug ) {

    if ( 'cpts' !== $menu_slug ) {
        return;     
    }

    update_option('hale_cpt_settings_updated', 1);
    
}

add_action('acf/options_page/save', 'hale_save_cpt_settings', 10, 2);

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
        hale_add_tax_select_acf_field($post_type, $post_type->name . '_listing_restrict', 'Restrict ' . $post_type->label, 'listing_restrict', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
        hale_add_custom_fields_select_acf_field($post_type, $post_type->name . '_list_item_fields', 'Display fields', 'list_item_fields', 1, 'field_65a710325ad17', 'group_65a71031ea4fb'); 
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

}

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

    $choices = array();
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

/**
 * Adds an Dropdown (select) ACF Field for a specific post type. Which lists acf fields assigned to a post type. Currently only on listing page template.
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

    $groups = acf_get_field_groups(array('post_type' => 'fi-report')); 

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
 * Retrieves the object type for a given post type.
 *
 * @param string $post_type The post type key.
 * @return string The object type.
 */
function hale_get_flexible_post_type_object_type($post_type){
    $cpts = get_field( 'custom_post_types', 'options' );

    $object_type = '';

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){    
            $post_type_key = $cpt['post_type_key'];
            if($post_type_key == $post_type){
                $object_type = $cpt['post_type_object_type'];
            }
        }

    }

    return $object_type;

}

/**
 * Retrieves the settings for a given post type.
 *
 * @param string $post_type The post type key.
 * @return array The object type.
 */
function hale_get_flexible_post_type_settings($post_type){
    $cpts = get_field( 'custom_post_types', 'options' );

    $flex_cpt = false;

    if(!empty($cpts) && is_array($cpts)){
        foreach($cpts as $cpt){    
            $post_type_key = $cpt['post_type_key'];
            if($post_type_key == $post_type){
                $flex_cpt = $cpt;
                break;
            }
        }

    }

    if (!array_key_exists('post_type_single_view', $cpt)) {
        $flex_cpt['post_type_single_view'] = true;
    }
    return $flex_cpt;

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
    return $vars;
}

add_filter('query_vars', 'hale_flexible_post_types_add_query_vars_filter');