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

	$custom_colours_set = ! get_theme_mod("gds_style_tickbox");
	if (!$custom_colours_set) {
		$style_class = " hale-colours-gds-standard";
	} else {
		$style_class = " hale-colours-variable";
	}
	if (is_front_page()) {
		$style_class .= " hale-landing-page";
	}

	return $style_class;
}

/**
 * Get the template which has been selected for the page
 */
function hale_get_template_class() {
	$screen = get_current_screen();
	//Checks if on page edit screen
	if ($screen->base === "post" && $screen->post_type === "page") {
		$template = get_page_template_slug();
		if ($template) {
			$class = preg_replace('/\.php$/', "", $template);
			$classes = " hale-editor hale-editor--template-" . sanitize_html_class($class);
		} else {
			// default template selected
			$classes = " hale-editor hale-editor--template-default";
		}
		return $classes;
	}
	return;
}
add_filter( 'admin_body_class', 'hale_get_template_class' );


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

    $classes .= ' ' . hale_get_branding_class();

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
 * Deprecation handling
 */
function hale_get_deprecation_class() {
	$class = "";
	$deprecated_paragraph_widths = get_theme_mod( 'deprecated_paragraph_widths', 'no' );
	if ($deprecated_paragraph_widths == "yes") $class = "hale-deprecated-paragraph-widths";
	return $class;
}
function hale_deprecation( $classes ) {
	$classes[] .= hale_get_deprecation_class();
	return $classes;
}
add_filter( 'body_class', 'hale_deprecation' );

function hale_admin_deprecation( $classes ) {
    global $pagenow;

    if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
        return;
    }

	$classes .= ' '.hale_get_deprecation_class();
	return $classes;
}
add_filter( 'admin_body_class', 'hale_admin_deprecation', 10, 1);


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

/**
 * This filter changes the content to include the IDs and the ordering number
 *
 * Only called if H2 numbering is enabled or the table of contents is called
 *
 * Uses the function found beneath it
 */

add_filter( 'the_content', 'hale_filter_add_index_for_h2_elements', 1 );

	function hale_filter_add_index_for_h2_elements( $content ) {

	// Check if we're inside the main loop in a single Post.
	if ( is_singular() && in_the_loop() && is_main_query()) {
		$numbered_headings = hale_get_acf_field_status('number_headings');
		$table_of_contents = hale_get_acf_field_status('show_toc_on_single_view');

		if (!$table_of_contents && !$numbered_headings) return $content;

		return hale_get_ordered_content($content, $numbered_headings)["content"];
	}

	return $content;
}

/**
 * This funciton used in the above filter, and in the function beneath it
 *
 * It does 2 things:
 * - returns an array of items for the table of contents (array pos [0] - used in hale_table_of_contents)
 * - amends the $content to include IDs and (if needed) adds numbers to H2s (array pos [1] - used in above filter)
 */

function hale_get_ordered_content($content, $numbered_headings) {
	$index = [];
	if (empty($content)) {
		return ["index" => $index, "content" => $content];
	}
	$count = 0; //index number
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	if (!$dom->loadHtml('<?xml encoding="UTF-8">'.$content)) {
		return array("index"=>$index,"content"=>$content);
	}
	libxml_clear_errors();
	$xpath = new DOMXPath($dom);
	$tags = $xpath->query('//h2');
	foreach($tags as $tag) {
		$tag->setAttribute('class', "hale-toc-item");
		$title = $tag->nodeValue;
		$id = preg_replace('/[^a-zA-Z0-9]/', '', remove_accents($title));
		$id = ++$count."-$id"; //$count is incremented & added to ID (this ensures no duplicates)
		$index[] = ["title"=>$title,"id"=>$id];
		if ($numbered_headings) $tag->prepend($count.". "); //adds the index number before the title if $ordered set

		//Jump to top link
		$jump_link = $dom->createElement("a",__("Back to top","hale"));
		$jump_link->setAttribute('class', 'govuk-link');
		$jump_link->setAttribute('href', '#table-of-contents-heading'); //link to the table of contents title
		$tag_suffix = $dom->createElement("span"," (");
		$tag_suffix->setAttribute('class', 'hale-jump-link govuk-!-font-size-19');
		$tag_suffix->appendChild($jump_link);
		$tag_suffix->append(")");

		$tag->appendChild($tag_suffix);
		$tag->setAttribute('id', $id);
	}

	// This is the content with IDs for all h2 elements (or whatever was set in $tags)
	$changed_content = trim($dom->saveHtml());

	return array("index"=>$index,"content"=>$changed_content);
}

/**
 * This creates the print this page button
 */

	function hale_print_page_button($print = false) {
		$print_button = "";
		if ($print) {
			$print_button_text = __("Print this page");
			$print_button = "<div class='hale-print-button'><button class='govuk-button govuk-button--secondary hale-print-page' onClick='window.print()'>$print_button_text</button></div>";
		}
		return $print_button;
	}

/**
 * This funciton constructs a table of contents
 * from the number of H2s on the page, which it
 * gets from the above funciton
 */

 function hale_table_of_contents( $ordered = false, $print = false) {
	$list_class = "";
	// if it is ordered, the index uses an ordered list and the number is displayed
	if ($ordered) {
		$list_class = "govuk-list--number";
	}

	$print_button = hale_print_page_button($print);

	$index = hale_get_ordered_content(hale_clean_bad_content( false ),$ordered)["index"];

	// Create the table of contents
	$list_of_headings = "";
	$count_headings = 0;
	foreach ($index as $content_item) {
		$list_of_headings .= '<li class="hale-table-of-contents__item"><a id="anchor-for-'.$content_item["id"].'" class="govuk-link govuk-link--no-visited-state" href="#'.$content_item["id"].'">'.$content_item["title"].'</a></li>';
		$count_headings++;
	}

	if ($list_of_headings == "") return ""; // If there are no matched headings, then there is no table of contents to shew

	$print_columns = "";
	// If there are more than 15 headings, put it in columns to make better use of the page
	// Increase to 3 columns after 25 (less space might make more wrap)
	if ($count_headings > 15) $print_columns = "hale-print-col hale-print-col--2";
	if ($count_headings > 25) $print_columns = "hale-print-col hale-print-col--3";

	$toc = "<div id='table-of-contents' class='hale-table-of-contents'>
			<h2 class='govuk-heading-s govuk-!-margin-bottom-2 hale-table-of-contents__heading' id='table-of-contents-heading'>".__("Table of contents","hale")."</h2>
			<ol class='hale-table-of-contents__list govuk-list $list_class $print_columns'>$list_of_headings</ol>
			$print_button
		</div>";

	return $toc;
}


function hook_css() {
	$opens_in_a_new_tab = trim(get_theme_mod("link_new_tab_text"));
	if (!isset($opens_in_a_new_tab) || $opens_in_a_new_tab == "") {
		$opens_in_a_new_tab = "";
	} else {
		$opens_in_a_new_tab = " ($opens_in_a_new_tab)";
	}
?>
	<style>
		.edit-post-visual-editor a[target=_blank]:after,
		.hale-page a[target=_blank]:after {
			content: "<?php echo $opens_in_a_new_tab; ?>";
		}

		.edit-post-visual-editor a[target=_blank]:after {
			opacity: 0.7;
		}
	</style>
    <?php
}
add_action('wp_head', 'hook_css');
add_action('admin_head', 'hook_css');
