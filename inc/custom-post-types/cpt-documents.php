<?php
// Register Document Post Type
function hale_register_doc_post_type()
{

    $labels = array(
        'name' => _x('Documents', 'Post Type General Name', 'hale'),
        'singular_name' => _x('Document', 'Post Type Singular Name', 'hale'),
        'menu_name' => __('Documents', 'hale'),
        'name_admin_bar' => __('Document', 'hale'),
        'archives' => __('Document archives', 'hale'),
        'attributes' => __('Document attributes', 'hale'),
        'parent_item_colon' => __('Parent document:', 'hale'),
        'all_items' => __('All documents', 'hale'),
        'add_new_item' => __('Add new documents', 'hale'),
        'add_new' => __('Add new', 'hale'),
        'new_item' => __('New document', 'hale'),
        'edit_item' => __('Edit document', 'hale'),
        'update_item' => __('Update document', 'hale'),
        'view_item' => __('View document', 'hale'),
        'view_items' => __('View documents', 'hale'),
        'search_items' => __('Search documents', 'hale'),
        'not_found' => __('Not found', 'hale'),
        'not_found_in_trash' => __('Not found in Trash', 'hale'),
        'featured_image' => __('Featured Image', 'hale'),
        'set_featured_image' => __('Set featured image', 'hale'),
        'remove_featured_image' => __('Remove featured image', 'hale'),
        'use_featured_image' => __('Use as featured image', 'hale'),
        'insert_into_item' => __('Insert into document', 'hale'),
        'uploaded_to_this_item' => __('Uploaded to this document', 'hale'),
        'items_list' => __('Document list', 'hale'),
        'items_list_navigation' => __('Document list navigation', 'hale'),
        'filter_items_list' => __('Filter document list', 'hale'),
    );
    $args = array(
        'label' => __('Document', 'hale'),
        'description' => __('Contains details of documents', 'hale'),
        'labels' => $labels,
        'supports' => array('title', 'editor'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-media-default',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'rewrite' => array(
            'slug' => 'document',
            'with_front' => false
        ),
    );

    //Check if post type is deactived
    $deactivate_doc = get_theme_mod('deactivate_cpt_documents', "yes");
    if ($deactivate_doc == "no") {
        register_post_type('document', $args);
    }

}

add_action('init', 'hale_register_doc_post_type', 0);
