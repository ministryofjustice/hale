<?php

/* 
 * Disable archives pages 
 * 
 * By default archive pages load in WP. These pages are currently 
 * not designed or styled or used, but are getting picked up
 * by search engines. This disables archive pages from loading
 * with the exception of those specified below.
 *
*/

add_action('template_redirect', 'hale_disable_archives_function');

function hale_disable_archives_function()
{
    // Allow specific archives to display
    $post_types = ['news'];

  if ( (is_archive() && !is_post_type_archive( $post_types )) )
  {
      global $wp_query;
      $wp_query->set_404();
      status_header(404);
  }
}
