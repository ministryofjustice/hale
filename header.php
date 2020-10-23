<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package   Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version   1.1 21st August 2019
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="theme" content="NHS-nightingale-2.2.0">
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
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nightingale' ); ?></a>
<?php

$header_layout = get_theme_mod( 'logo_type', 'transactional' );
$header_colour = get_theme_mod( 'header_styles', 'normal' );

if ( 'normal' !== $header_colour ) {
	$header_colour_text = ' nhsuk-header--white';
} else {
	$header_colour_text = '';
}
echo '<header class="nhsuk-header nhsuk-header--' . esc_attr( $header_layout . $header_colour_text ) . '">';
?>
<div class="nhsuk-width-container nhsuk-header__container">
	<?php
	get_template_part( 'partials/logo' );
	?>
	<div class="nhsuk-header__content" id="content-header">

		<?php
		$header_search = get_theme_mod( 'show_search', 'yes' );
		if ( 'no' === $header_search ) {
			$headersearchextra = 'nhsuk-header__menu--only';
		} else {
			$headersearchextra = '';
		}

        $show_header_menu = get_theme_mod('show_header_menu', 'yes');
        if ($show_header_menu == 'yes') {
            ?>
            <div class="nhsuk-header__menu <?php echo esc_attr($headersearchextra); ?>">
                <button class="nhsuk-header__menu-toggle" id="toggle-menu" aria-controls="header-navigation"
												aria-label="Open menu">
												<svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M0.857143 3.84437H23.1429C23.6163 3.84437 24 3.46191 24 2.99007V0.854305C24 0.382462 23.6163 0 23.1429 0H0.857143C0.383732 0 0 0.382462 0 0.854305V2.99007C0 3.46191 0.383732 3.84437 0.857143 3.84437ZM0.857143 12.3874H23.1429C23.6163 12.3874 24 12.005 24 11.5331V9.39735C24 8.92551 23.6163 8.54305 23.1429 8.54305H0.857143C0.383732 8.54305 0 8.92551 0 9.39735V11.5331C0 12.005 0.383732 12.3874 0.857143 12.3874ZM0.857143 20.9305H23.1429C23.6163 20.9305 24 20.548 24 20.0762V17.9404C24 17.4686 23.6163 17.0861 23.1429 17.0861H0.857143C0.383732 17.0861 0 17.4686 0 17.9404V20.0762C0 20.548 0.383732 20.9305 0.857143 20.9305Z" fill="white"/>
												</svg>
												Menu
                </button>
            </div>

            <?php
        }

		if ( 'yes' === $header_search ) {
			?>
			<div class="nhsuk-header__search">
				<?php get_search_form(); ?>
			</div>
			<?php
		}
		?>

	</div>

</div>
<?php
get_template_part( 'partials/topnav' );
?>
</header>
<?php
get_template_part( 'partials/banner' );
?>
<?php echo nightingale_breadcrumb(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

<?php

$page_color = get_post_meta( get_the_id(), 'page-color', true );

$extra_styles = $page_color ? 'page-style--' . $page_color : '';

?>

<div id="content" class="nhsuk-width-container nhsuk-width-container--full">
	<main class="nhsuk-main-wrapper nhsuk-main-wrapper--no-padding <?php echo esc_attr( $extra_styles ); ?>" id="maincontent">
		<div id="contentinner">
		<?php
		flush();
