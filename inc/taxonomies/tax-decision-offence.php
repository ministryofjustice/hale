<?php
// Register Decision Offence Custom Taxonomy
function hale_decision_offence_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Offence',
        'singular_name'              => 'Offence',
        'menu_name'                  => 'Offence',
        'all_items'                  => 'All Offence',
        'parent_item'                => 'Parent Offence',
        'parent_item_colon'          => 'Parent Offence:',
        'new_item_name'              => 'New Offence Name',
        'add_new_item'               => 'Add New Offence',
        'edit_item'                  => 'Edit Offence',
        'update_item'                => 'Update Offence',
        'view_item'                  => 'View Offence',
        'separate_items_with_commas' => 'Separate Decision Offence with commas',
        'add_or_remove_items'        => 'Add or remove Decision Offence',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Decision Offence',
        'search_items'               => 'Search Decision Offence',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Decision Offence',
        'items_list'                 => 'Decision Offence list',
        'items_list_navigation'      => 'Decision Offence list navigation',
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
    register_taxonomy( 'decision_offence', array( 'decision'), $args );

}
add_action( 'init', 'hale_decision_offence_custom_taxonomy', 0 );
