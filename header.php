<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="hale-page">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="theme" content="MOJ-hale-1.0.11">
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
	wp_enqueue_script( 'jquery' );
	wp_head();
	flush();
	?>
</head>
<body <?php body_class(""); ?>>
<script>
	// add in js-enabled by JavaScript - no JS, JS not enabled
	document.body.className = ((document.body.className) ? document.body.className + ' js-enabled' : 'js-enabled');
</script>
<?php
if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Open the body tag, pull in any hooked triggers.
	 **/
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
wp_body_open();
?>
<?php do_action( 'hale_after_body' ); ?>
<a class="govuk-skip-link" data-module="govuk-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'hale' ); ?></a>
<?php

$header_search = get_theme_mod( 'show_search', 'yes' );
$show_header_menu = get_theme_mod('show_header_menu', 'yes');

if ( 'yes' === $header_search && !is_search()) {
  $header_search_class = 'hale-header--with-search';
} else {
  $header_search_class = '';
}

echo '<header class="govuk-header hale-header ' . esc_attr( $header_search_class ) . '" data-module="govuk-header">';
?>
<div class="govuk-width-container govuk-header__container">
	<?php
	get_template_part( 'partials/logo' );
	?>
 <?php
  if ( 'yes' === $header_search && !is_search()) {
    ?>
    <div class="hale-header__search">
      <?php get_search_form(); ?>
    </div>
    <?php
  }
?>     <?php
        if ( 'no' === $header_search ) {
          $headersearchextra = 'hale-header__menu--only';
        } else {
          $headersearchextra = '';
        }
      ?>
    <?php
    if ($show_header_menu == 'yes') {
    ?>
    <div class="govuk-header__content" id="content-header">
      <div class="hale-header__menu <?php echo esc_attr($headersearchextra); ?>">

      </div>

      <?php get_template_part( 'partials/topnav' );

      ?>

    <div class="hale-header__header-controls">

    </div>
	</div>
    <?php } ?>
</div>
</header>
<?php
get_template_part( 'partials/secondary-top-nav' );

echo hale_breadcrumb(); 

$page_colour = get_post_meta( get_the_id(), 'page-colour', true );

$extra_styles = $page_colour ? 'page-style--' . $page_colour : '';

?>

<div id="content" class="govuk-width-container">
	<main class="govuk-main-wrapper <?php echo esc_attr( $extra_styles ); ?>" id="maincontent">
		<div id="contentinner" class="govuk-grid-row">
		<?php
		flush();
