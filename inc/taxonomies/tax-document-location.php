<?php
// Register Document Location Custom Taxonomy
function hale_document_location_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Document Locations',
        'singular_name'              => 'Document Location',
        'menu_name'                  => 'Document Locations',
        'all_items'                  => 'All Document Locations',
        'parent_item'                => 'Parent Document Location',
        'parent_item_colon'          => 'Parent Document Location:',
        'new_item_name'              => 'New Document Location Name',
        'add_new_item'               => 'Add New Document Location',
        'edit_item'                  => 'Edit Document Location',
        'update_item'                => 'Update Document Location',
        'view_item'                  => 'View Document Location',
        'separate_items_with_commas' => 'Separate Document Locations with commas',
        'add_or_remove_items'        => 'Add or remove Document Locations',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Document Locations',
        'search_items'               => 'Search Document Locations',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Document Locations',
        'items_list'                 => 'Document Locations list',
        'items_list_navigation'      => 'Document Locations list navigation',
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
    register_taxonomy( 'document_location', array( 'document'), $args );

}
add_action( 'init', 'hale_document_location_custom_taxonomy', 0 );
