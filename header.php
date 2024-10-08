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
<script>document.body.className += ' js-enabled' + ('noModule' in HTMLScriptElement.prototype ? ' govuk-frontend-supported' : '');</script>
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

$header_quick_exit = get_theme_mod( 'show_quick_exit', 'no' );
?>
<?php do_action( 'hale_after_body' ); ?>
<a class="govuk-skip-link" data-module="govuk-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'hale' ); ?></a>
<?php
  if ( 'yes' === $header_quick_exit) {
    ?>
<a href="https://bbc.co.uk/weather/" class="govuk-skip-link govuk-js-exit-this-page-skiplink" rel="nofollow noreferrer" data-module="govuk-skip-link"><?php esc_html_e( 'Exit this page', 'hale' ); ?></a>
<?php
  }
    ?>
<?php
include "partials/emergency-banner.php";
?>
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
      <?php get_search_form(array('header' => true)); ?>
    </div>
    <?php
  }
?>
  <?php
  if ( 'yes' === $header_quick_exit) {
    ?>
	<div class="govuk-exit-this-page" data-module="govuk-exit-this-page">
	<a href="https://www.bbc.co.uk/weather" role="button" draggable="false" class="govuk-button govuk-button--warning govuk-exit-this-page__button govuk-js-exit-this-page-button" data-module="govuk-button" rel="nofollow noreferrer">
		<span class="govuk-visually-hidden"><?php esc_html_e( 'Emergency', 'hale' ); ?></span> <?php esc_html_e( 'Exit this page', 'hale' ); ?>
		<span class="govuk-visually-hidden"><?php esc_html_e( 'Or press shift key 3 times to exit this page', 'hale' ); ?></span>
	</a>
	</div>
    <?php
  }
?>
	<?php
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

include "partials/information-banner.php";


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
