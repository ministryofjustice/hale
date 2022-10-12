<?php
// Register Document Category Custom Taxonomy
function hale_document_category_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Document Categories',
        'singular_name'              => 'Document Category',
        'menu_name'                  => 'Document Categories',
        'all_items'                  => 'All Document Categories',
        'parent_item'                => 'Parent Document Category',
        'parent_item_colon'          => 'Parent Document Category:',
        'new_item_name'              => 'New Document Category Name',
        'add_new_item'               => 'Add New Document Category',
        'edit_item'                  => 'Edit Document Category',
        'update_item'                => 'Update Document Category',
        'view_item'                  => 'View Document Category',
        'separate_items_with_commas' => 'Separate Document Categories with commas',
        'add_or_remove_items'        => 'Add or remove Document Categories',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Document Categories',
        'search_items'               => 'Search Document Categories',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Document Categories',
        'items_list'                 => 'Document Categories list',
        'items_list_navigation'      => 'Document Categories list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'document_category', array( 'document'), $args );

}
add_action( 'init', 'hale_document_category_custom_taxonomy', 0 );
