<?php
// ************* Remove default Posts type since no blog *************

// Remove side menu
add_action( 'admin_menu', 'hale_remove_default_post_type' );

function hale_remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

// Remove +New post in top Admin Menu Bar
add_action( 'admin_bar_menu', 'hale_remove_default_post_type_menu_bar', 999 );

function hale_remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
}

// Remove Quick Draft Dashboard Widget
add_action( 'wp_dashboard_setup', 'hale_remove_draft_widget', 999 );

function hale_remove_draft_widget(){
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}
// End remove post type