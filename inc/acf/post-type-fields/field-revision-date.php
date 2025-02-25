<?php

/**
 * Registers a revision date field for specific post types in the WordPress admin using ACF.
 *
 * This function iterates through all registered post types and adds a custom ACF Date Time Picker field
 * for entering a date if the post type has an enabled revision date feature flagged by 'revision_date' property.
 * 
 * https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 */
function hale_register_post_type_fields_revision_date()
{
      // Retrieve all registered post types as objects
      $post_types = get_post_types([], 'objects');

      foreach ($post_types as $key => $post_type) {
          if (isset($post_type->revision_date)) {
          
            $post_type_name = $post_type->label;
            $post_type_key = $key;


            acf_add_local_field_group( array(
                'key' => $post_type_key . "_revision_group",
                'title' => 'Revision',
                'fields' => array(
                    array(
                        'key' => $post_type_key . "_revision_date",
                        'label' => 'Revision Date',
                        'name' => 'post_revision_date',
                        'aria-label' => '',
                        'type' => 'date_time_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'relevanssi_exclude' => 0,
                        'display_format' => 'd/m/Y g:i a',
                        'return_format' => 'U',
                        'first_day' => 1,
                        'allow_in_bindings' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => $key,
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'side',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ) );
          }
     }
}

add_action('acf/init', 'hale_register_post_type_fields_revision_date');
