<?php
// Register Document Type Custom Taxonomy
function hale_document_type_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Document Types',
        'singular_name'              => 'Document Type',
        'menu_name'                  => 'Document Types',
        'all_items'                  => 'All Document Types',
        'parent_item'                => 'Parent Document Type',
        'parent_item_colon'          => 'Parent Document Type:',
        'new_item_name'              => 'New Document Type Name',
        'add_new_item'               => 'Add New Document Type',
        'edit_item'                  => 'Edit Document Type',
        'update_item'                => 'Update Document Type',
        'view_item'                  => 'View Document Type',
        'separate_items_with_commas' => 'Separate Document Types with commas',
        'add_or_remove_items'        => 'Add or remove Document Types',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Document Types',
        'search_items'               => 'Search Document Types',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Document Types',
        'items_list'                 => 'Document Types list',
        'items_list_navigation'      => 'Document Types list navigation',
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
    register_taxonomy( 'document_type', array( 'document'), $args );

}
add_action( 'init', 'hale_document_type_custom_taxonomy', 0 );
