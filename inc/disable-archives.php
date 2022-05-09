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

  // Currently only apply to specific archive pages,
  // as others are being used on other sites
  if ((is_archive() && is_tax('page_category')))
  {
      global $wp_query;
      $wp_query->set_404();
      status_header(404);
  }
}
