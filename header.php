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
<html <?php language_attributes(); ?>>
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
<body <?php body_class( 'js-enabled' ); ?>>
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
<?php do_action( 'nightingale_after_body' ); ?>
<a class="govuk-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'hale' ); ?></a>
<?php

$header_colour = get_theme_mod( 'header_styles', 'normal' );
$header_search = get_theme_mod( 'show_search', 'yes' );
$show_header_menu = get_theme_mod('show_header_menu', 'yes');

if ( 'normal' !== $header_colour ) {
	$header_colour_text = ' jotw-header--white';
} else {
	$header_colour_text = '';
}
if ($show_header_menu == 'yes') {
  $header_search_class = 'jotw-header--with-search';
} else {
  $header_search_class = '';
}

echo '<header class="govuk-header jotw-header ' . esc_attr( $header_colour_text . $header_search_class ) . '">';
?>
<div class="govuk-width-container govuk-header__container">
	<?php
	get_template_part( 'partials/logo' );
	?>
	<div class="govuk-header__content" id="content-header">
    <div class="jotw-header__header-controls">
<?php
		if ( 'no' === $header_search ) {
			$headersearchextra = 'jotw-header__menu--only';
		} else {
			$headersearchextra = '';
		}

        if ($show_header_menu == 'yes') {
            ?>
            <div class="jotw-header__menu <?php echo esc_attr($headersearchextra); ?>">
                <button class="jotw-header__mobile-controls jotw-header__mobile-controls--menu govuk-header__menu-button govuk-js-header-toggle" id="toggle-menu" aria-controls="header-navigation" aria-label="Open menu" aria-expanded="false">
                  <span>Menu</span>
                </button>
            </div>

            <?php
        }

        if ( 'yes' === $header_search && !is_search()) {
          ?>
          <div class="jotw-header__search">
            <?php get_search_form(); ?>
          </div>
          <?php
        }
        ?>
    </div>
    <?php
      $gds_header = get_theme_mod( 'gds_header', 'yes' );
      if ($gds_header == 'yes') {
        get_template_part( 'partials/topnav' );
      }
    ?>
	</div>
  <?php
    if ($gds_header == 'no') {
      get_template_part( 'partials/topnav' );
    }
  ?>
</div>
</header>
<?php
get_template_part( 'partials/banner' );
?>
<?php echo nightingale_breadcrumb(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

<?php

$page_color = get_post_meta( get_the_id(), 'page-color', true );

$extra_styles = $page_color ? 'page-style--' . $page_color : '';

?>

<div id="content" class="govuk-width-container govuk-width-container--full">
	<main class="govuk-main-wrapper govuk-!-padding-top-0 <?php echo esc_attr( $extra_styles ); ?>" id="maincontent">
		<div id="contentinner">
		<?php
		flush();
