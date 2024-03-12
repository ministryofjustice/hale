<?php
if( function_exists('acf_add_options_page') ) {
    $customizations = acf_add_options_page(array(
        'page_title' 	=> 'Site Customization',
        'menu_title'	=> 'Site Customization',
        'menu_slug' 	=> 'site-customization',
        'capability'    => 'edit_posts'
    ));
    $critical_information_banner_page = acf_add_options_sub_page(array(
        'page_title' 	=> 'Critical Information Banner Settings',
        'menu_title'	=> 'Critical Information Banner Settings',
        'parent_slug'   => $customizations['menu_slug'],
    ));
    $emergency_banner_page = acf_add_options_sub_page(array(
        'page_title' 	=> 'Emergency Banner Settings',
        'menu_title'	=> 'Emergency Banner Settings',
        'parent_slug'   => $customizations['menu_slug'],
    ));
}