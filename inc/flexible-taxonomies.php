<?php

/**
 * Registers flexible taxonomies based on the settings in the CPT and Taxonomy options page.
 */
function hale_register_flexible_taxonomies()
{

    $custom_taxonomies = get_field( 'custom_taxonomies', 'options' );

    if(!empty($custom_taxonomies) && is_array($custom_taxonomies)){
        foreach($custom_taxonomies as $tax){       
            hale_register_taxonomy($tax);
        }
    }

}

add_action('init', 'hale_register_flexible_taxonomies', 1);

/**
 * Registers a taxonomy based on the provided settings.
 *
 * @param array $tax Settings for the taxonomy
 */
function hale_register_taxonomy($tax){

    $taxonomy_name = $tax['taxonomy_name'];
    $taxonomy_name_plural = $tax['taxonomy_name_plural'];
    $taxonomy_key = $tax['taxonomy_key'];
    $taxonomy_hierarchical = $tax['taxonomy_hierarchical'];

    if(empty($taxonomy_name) || empty($taxonomy_name_plural) || empty($taxonomy_key)){
        return;
    }

    $labels = array(
        'name'                       => $taxonomy_name_plural,
        'singular_name'              => $taxonomy_name,
        'menu_name'                  => $taxonomy_name_plural,
        'all_items'                  => 'All ' . $taxonomy_name_plural,
        'parent_item'                => 'Parent ' . $taxonomy_name,
        'parent_item_colon'          => 'Parent ' . $taxonomy_name . ':',
        'new_item_name'              => 'New ' . $taxonomy_name . ' Name',
        'add_new_item'               => 'Add New ' . $taxonomy_name,
        'edit_item'                  => 'Edit ' . $taxonomy_name,
        'update_item'                => 'Update ' . $taxonomy_name,
        'view_item'                  => 'View ' . $taxonomy_name,
        'separate_items_with_commas' => 'Separate ' . $taxonomy_name_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_name_plural,
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular ' . $taxonomy_name_plural,
        'search_items'               => 'Search ' . $taxonomy_name_plural,
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No ' . $taxonomy_name_plural,
        'items_list'                 => $taxonomy_name_plural . ' list',
        'items_list_navigation'      => $taxonomy_name_plural . ' list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => $taxonomy_hierarchical,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( $taxonomy_key, array(), $args );

}

/**
 * Adds a custom query variables for flexible taxonomies.
 *
 * @param array $vars The existing query variables.
 * @return array The modified query variables.
 */
function hale_flexible_taxonomies_add_query_vars_filter($vars)
{
    $custom_taxonomies = get_field( 'custom_taxonomies', 'options' );

    if(!empty($custom_taxonomies) && is_array($custom_taxonomies)){
        foreach($custom_taxonomies as $tax){       
            $taxonomy_key = $tax['taxonomy_key'];
            $vars[] = $taxonomy_key;
        }
    }
    return $vars;
}

add_filter('query_vars', 'hale_flexible_taxonomies_add_query_vars_filter');



