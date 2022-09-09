<?php
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Emergency Banner Settings',
        'menu_title'	=> 'Emergency Banner Settings',
        'menu_slug' 	=> 'emergency-banner-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
}