<?php

// Register Decision Post Type
function register_decision_post_type() {

    $labels = array(
        'name'                  => _x( 'Decisions', 'Post Type General Name', 'hale' ),
        'singular_name'         => _x( 'Decision', 'Post Type Singular Name', 'hale' ),
        'menu_name'             => __( 'Decision Archive', 'hale' ),
        'name_admin_bar'        => __( 'Decision', 'hale' ),
        'archives'              => __( 'Decision Archives', 'hale' ),
        'attributes'            => __( 'Decision Attributes', 'hale' ),
        'parent_item_colon'     => __( 'Parent Decision:', 'hale' ),
        'all_items'             => __( 'All Decisions', 'hale' ),
        'add_new_item'          => __( 'Add New Decision', 'hale' ),
        'add_new'               => __( 'Add New', 'hale' ),
        'new_item'              => __( 'New Decision', 'hale' ),
        'edit_item'             => __( 'Edit Decision', 'hale' ),
        'update_item'           => __( 'Update Decision', 'hale' ),
        'view_item'             => __( 'View Decision', 'hale' ),
        'view_items'            => __( 'View Decisions', 'hale' ),
        'search_items'          => __( 'Search Decision', 'hale' ),
        'not_found'             => __( 'Not found', 'hale' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'hale' ),
        'featured_image'        => __( 'Featured Image', 'hale' ),
        'set_featured_image'    => __( 'Set featured image', 'hale' ),
        'remove_featured_image' => __( 'Remove featured image', 'hale' ),
        'use_featured_image'    => __( 'Use as featured image', 'hale' ),
        'insert_into_item'      => __( 'Insert into Decision', 'hale' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Decision', 'hale' ),
        'items_list'            => __( 'Decision list', 'hale' ),
        'items_list_navigation' => __( 'Decision list navigation', 'hale' ),
        'filter_items_list'     => __( 'Filter Decision list', 'hale' ),
    );

    $args = array(
        'label'               => __( 'Decision', 'hale' ),
        'description'         => __( 'Contains details of decisions', 'hale' ),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-archive',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'taxonomies'          => false,
        'rewrite'             => array(
            'slug'       => 'decision',
            'with_front' => false
        ),
    );

    register_post_type( 'decision', $args );

}
add_action( 'init', 'register_decision_post_type', 0 );


// Register Custom Taxonomies
function custom_taxonomy() {
    // Custom Category (hierarchical)
    $labels = array(
        'name' => _x('Decision Categories', 'taxonomy general name'),
        'singular_name' => _x('Decision Category', 'taxonomy singular name'),
        'search_items' => __('Search Decision Categories'),
        'all_items' => __('All Decision Categories'),
        'parent_item' => __('Parent Decision Category'),
        'parent_item_colon' => __('Parent Decision Category:'),
        'edit_item' => __('Edit Decision Category'),
        'update_item' => __('Update Decision Category'),
        'add_new_item' => __('Add New Decision Category'),
        'new_item_name' => __('New Decision Category Name'),
        'menu_name' => __('Decision Categories'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'decision-category'),
    );

    register_taxonomy('decision_category', array('decision'), $args);

    // Custom Tag (non-hierarchical)
    $labels = array(
        'name' => _x('Decision Tags', 'taxonomy general name'),
        'singular_name' => _x('Decision Tag', 'taxonomy singular name'),
        'search_items' => __('Search Decision Tags'),
        'all_items' => __('All Decision Tags'),
        'edit_item' => __('Edit Decision Tag'),
        'update_item' => __('Update Decision Tag'),
        'add_new_item' => __('Add New Decision Tag'),
        'new_item_name' => __('New Decision Tag Name'),
        'menu_name' => __('Decision Tags'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'decision-tag'),
    );

    register_taxonomy('decision_tag', array('decision'), $args);
}

add_action('init', 'custom_taxonomy');
