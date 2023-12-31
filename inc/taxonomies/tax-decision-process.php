<?php
// Register Decision Process Custom Taxonomy
function hale_decision_process_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Process',
        'singular_name'              => 'Process',
        'menu_name'                  => 'Process',
        'all_items'                  => 'All Processes',
        'parent_item'                => 'Parent Process',
        'parent_item_colon'          => 'Parent Process:',
        'new_item_name'              => 'New Process Name',
        'add_new_item'               => 'Add New Process',
        'edit_item'                  => 'Edit Process',
        'update_item'                => 'Update Process',
        'view_item'                  => 'View Process',
        'separate_items_with_commas' => 'Separate Decision Process with commas',
        'add_or_remove_items'        => 'Add or remove Decision Process',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Decision Process',
        'search_items'               => 'Search Decision Process',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Decision Process',
        'items_list'                 => 'Decision Process list',
        'items_list_navigation'      => 'Decision Process list navigation',
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
    register_taxonomy( 'decision_process', array( 'decision'), $args );

}
add_action( 'init', 'hale_decision_process_custom_taxonomy', 0 );
