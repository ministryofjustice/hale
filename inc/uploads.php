<?php

/**
 * Management of files uploaded to WP
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

// Ensure all network sites include WebP support.
// Filter needed to support multisite - 20.10.21
// https://make.wordpress.org/core/2021/06/07/wordpress-5-8-adds-webp-support/

add_filter(
    'site_option_upload_filetypes',
    function ($filetypes) {
        $filetypes = explode(' ', $filetypes);
        if (! in_array('webp', $filetypes, true)) {
            $filetypes[] = 'webp';
        }
        $filetypes = implode(' ', $filetypes);
        return $filetypes;
    }
);

if( current_user_can('administrator') ) {
    function add_upload_mimes( $types ) {
        $types['json'] = 'application/json';
        return $types;
    }
    add_filter( 'upload_mimes', 'add_upload_mimes' );
}
