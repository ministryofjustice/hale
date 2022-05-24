<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function hale_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = hale_get_header_style();

	return $classes;
}

add_filter( 'body_class', 'hale_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function hale_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'hale_pingback_header' );

if ( ! function_exists( 'hale_get_header_style' ) ) {
	/**
	 * Figure whether we are using standard blue header with white text, or an inverse header which is white with blue / grey text.
	 *
	 * @return string $default_position.
	 */
	function hale_get_header_style() {

		$themeoptions_header_style = get_theme_mod( 'theme-header-style', 'default' );

		if ( 'default' === $themeoptions_header_style ) {
			$default_position = 'page-header-default';
		} elseif ( 'centered' === $themeoptions_header_style ) {
			$default_position = 'page-header-white';
		}

		return $default_position;
	}
}

/*
 * Add excerpt ability to posts so the excerpt can be used in search results.
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Shortens the excerpt to 20 char
 *
 * @param int $length length to shorten content to.
 */
function hale_shorten_excerpt( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return 20;
}

add_filter( 'excerpt_length', 'hale_shorten_excerpt', 10 );

/**
 * Adds the readmore link to excerpts
 *
 * @param string $more the default more string.
 */
function hale_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	global $post;
	$link  = '';
	$title = get_the_title( $post->ID );

	return hale_read_more_posts( $title, $link );
}

add_filter( 'excerpt_more', 'hale_excerpt_more' );
/**
 * Customise the read more link.
 *
 * @param string $title The title for the link (used in visually hidden area for screen readers to better describe the link).
 * @param string $link  The href of the resource being linked to.
 *                      return string output html.
 */
function hale_read_more_posts( $title, $link ) {
  $readmorelink = '';
	if ( '' !== $link ) {
		$readmorelink .= '<a class="govuk-button" href="' . $link . '">' . esc_html__( 'Read more ', 'hale' ) . '</a>';
	}
	return $readmorelink;
}

/**
 * Whether show sidebar returns true or false
 */
function hale_show_sidebar() {
	return ( 'true' === get_theme_mod( 'blog_sidebar' ) );
}

/**
 * Determine if page should have sidebar on left or right, and return additional class if required.
 *
 * @param string $sidebar location string for sidebar.
 */
function hale_sidebar_location( $sidebar ) {
	$sidebar_location = get_theme_mod( 'sidebar_location', 'right' );
	$sidefloat        = 'contentleft';
	if ( 'right' !== $sidebar_location ) {
		if ( is_active_sidebar( $sidebar ) ) {
			$sidefloat = ' contentright';
		}
	}

	return $sidefloat;
}

require get_template_directory() . '/inc/colour-branding.php';

function hale_get_branding_class() {

	if (is_customize_preview()) {
		hale_generate_custom_colours();
	}

	return "hale-site-" . get_current_blog_id();
}

/**
 * Get the custom colour name to return into the body class if required
 *
 * @param array $classes the pre-existing classes for a WordPress page.
 */
function hale_custom_page_colour( $classes ) {

  $classes[] = hale_get_branding_class();

  return $classes;
}

add_filter( 'body_class', 'hale_custom_page_colour' );

function hale_admin_custom_page_colour( $classes ) {

    global $pagenow;

    if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
        return;
    }

    $classes .= ' ' . hale_get_branding_class(); //none set = use Neptune

    return $classes;

}

add_filter( 'admin_body_class', 'hale_admin_custom_page_colour', 10, 1);

function hale_get_typography_class() {

    $font_class = '';
    $font = get_theme_mod( 'primary_font', 'pt-sans' );
    if ( !empty($font) ) {
        $font_class = 'primary-font--'. $font;
    }

    return $font_class;
}

function hale_custom_typography( $classes ) {
    $font_class = hale_get_typography_class();
    if ( !empty($font_class) ) {
        $classes[]  = $font_class;
    }

    return $classes;
}

add_filter( 'body_class', 'hale_custom_typography' );

function hale_admin_custom_typography( $classes ) {

    global $pagenow;

    if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
        return;
    }

    $classes .= ' ' . hale_get_typography_class();

    return $classes;

}

add_filter( 'admin_body_class', 'hale_admin_custom_typography', 10, 1);

/**
 * Function to sanitise content and remove empty elements that cause a11y and w3c validation errors.
 *
 * @param bool $b_print Boolean argument specifying whether or not to print the function output.
 *
 * @return mixed|string|string[]|void|null Return the sanitised output, or original output if flag set to false.
 */
function hale_clean_bad_content( $b_print = false ) {

	global $post;
	$hale_post_content  = $post->post_content;
	$hale_remove_filter = array( '~<p[^>]*>\s?</p>~', '~<a[^>]*>\s?</a>~', '~<h[^>]*>\s?</h[^>]>~', '~<font[^>]*>~', '~<\/font>~' );
	$hale_post_content  = preg_replace( $hale_remove_filter, '', $hale_post_content );
	$hale_post_content  = apply_filters( 'the_content', $hale_post_content );
	if ( false === $b_print ) {
		return $hale_post_content;
	} else {
		echo $hale_post_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
