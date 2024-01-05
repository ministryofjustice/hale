<?php
// Register Decision Referral Type Custom Taxonomy
function hale_decision_referral_type_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Referral Types',
        'singular_name'              => 'Referral',
        'menu_name'                  => 'Referral Type',
        'all_items'                  => 'All Referral Types',
        'parent_item'                => 'Parent Document Category',
        'parent_item_colon'          => 'Parent Document Category:',
        'new_item_name'              => 'New Document Category Name',
        'add_new_item'               => 'Add New Document Category',
        'edit_item'                  => 'Edit Document Category',
        'update_item'                => 'Update Document Category',
        'view_item'                  => 'View Document Category',
        'separate_items_with_commas' => 'Separate Decision Referral Types with commas',
        'add_or_remove_items'        => 'Add or remove Decision Referral Types',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Decision Referral Types',
        'search_items'               => 'Search Decision Referral Types',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Decision Referral Types',
        'items_list'                 => 'Decision Referral Types list',
        'items_list_navigation'      => 'Decision Referral Types list navigation',
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
    register_taxonomy( 'decision_referral_type', array( 'decision'), $args );

}
add_action( 'init', 'hale_decision_referral_type_custom_taxonomy', 0 );
