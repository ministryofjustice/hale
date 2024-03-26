<?php
if( function_exists('acf_add_options_page') ) {
	$customizations = acf_add_options_page(array(
		'page_title'  => 'Customization',
		'menu_title'  => 'Customization',
		'menu_slug'   => 'site-customization',
		'capability'  => 'edit_theme_options'
	));
	$banners = acf_add_options_sub_page(array(
		'page_title'  => 'Site-wide Banner Settings',
		'menu_title'  => 'Site-wide Banner Settings',
		'parent_slug' => $customizations['menu_slug'],
	));
}
