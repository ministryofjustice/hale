<?php
// Register Page Category Custom Taxonomy
function page_category_custom_taxonomy() {

    $labels = array(
        'name'                       => 'Page Categories',
        'singular_name'              => 'Page Category',
        'menu_name'                  => 'Page Categories',
        'all_items'                  => 'All Page Categories',
        'parent_item'                => 'Parent Page Category',
        'parent_item_colon'          => 'Parent Page Category:',
        'new_item_name'              => 'New Page Category Name',
        'add_new_item'               => 'Add New Page Category',
        'edit_item'                  => 'Edit Page Category',
        'update_item'                => 'Update Page Category',
        'view_item'                  => 'View Page Category',
        'separate_items_with_commas' => 'Separate Page Categories with commas',
        'add_or_remove_items'        => 'Add or remove Page Categories',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Page Categories',
        'search_items'               => 'Search Page Categories',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No Page Categories',
        'items_list'                 => 'Page Categories list',
        'items_list_navigation'      => 'Page Categories list navigation',
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
    register_taxonomy( 'page_category', array( 'page'), $args );

}
add_action( 'init', 'page_category_custom_taxonomy', 0 );
