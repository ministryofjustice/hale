<?php
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Headline Banner Settings',
        'menu_title'	=> 'Headline Banner Settings',
        'menu_slug' 	=> 'headline-banner-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
}