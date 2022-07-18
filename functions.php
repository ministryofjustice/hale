<?php

/**
 * Hale theme functions and definitions
 *
 * @link      https://developer.wordpress.org/themes/basics/theme-functions/
 * @package   Hale
 * @copyright Ministry Of Justice
 * @version   2.0
 */

/**
 * Add in customizer sanitizer functions
 */
require get_template_directory() . '/inc/sanitization-callbacks.php';


/**
 * Sets up theme defaults and registers support for various WordPress features.
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hale_setup()
{
    load_theme_textdomain('hale');
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menus() in two location.
    $locations = array(
        'main-menu'   => __('Main site navigation, located in the header.', 'hale'),
        'secondary-top-menu'   => __('Secondary navigation, under header.', 'hale'),
        'footer-menu' => __('Main footer navigation area.', 'hale'),
        'secondary-footer-menu' => __('Secondary footer navigation area.', 'hale')
    );
    register_nav_menus($locations);

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'hale_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support(
        'customize-selective-refresh-widgets'
    );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
    // Load regular editor styles into the new block-based editor.
    add_theme_support('editor-styles');
    // Load default block styles.
    add_theme_support('wp-block-styles');
    // Add support for responsive embeds.
    add_theme_support('responsive-embeds');
    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(
        'widgets'    => array(
            // Place pre-defined widget in the sidebar area.
            'sidebar-1' => array(
                'search',
                'subpages-widget',
            ),
            '404-error' => array(
                'archives',
                'tag_cloud',
                'recent_posts',
            ),
        ),
        'posts'      => array(
            'home',
            'blog',
        ),
        // Default to a static front page and assign the front and posts pages.
        'options'    => array(
            'show_on_front'  => 'page',
            'page_on_front'  => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{blog}}',
        ),

        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus'  => array(
            // Assign a menu to the "main-menu" location.
            'main-menu'   => array(
                'name'  => __('Main Menu', 'hale'),
                'items' => array(
                    'link_home',
                    // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_blog',
                ),
            ),
            // Assign a menu to the "footer-menu" location.
            'footer-menu' => array(
                'name'  => __('Footer Links', 'hale'),
                'items' => array(
                    'link_home',
                    'page-blog',
                ),
            ),
        ),
    );
    add_theme_support('starter-content', $starter_content);

    remove_theme_support('custom-header');
    remove_theme_support('custom-background');
}

add_action('after_setup_theme', 'hale_setup');

/* taken from https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#block-font-sizes */
add_action('after_setup_theme', 'wpse_remove_custom_colors');
function wpse_remove_custom_colors() {
    // removes the text box where users can enter custom pixel sizes
    add_theme_support('disable-custom-font-sizes');
    // specifies the options (removed "normal")
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => 'Huge',
            'size' => '50',
            'slug' => 'huge'
        ),
        array(
            'name' => 'Large',
            'size' => '38',
            'slug' => 'large'
        ),
        array(
            'name' => 'Medium',
            'size' => '28',
            'slug' => 'medium'
        ),
        array(
            'name' => 'Small',
            'size' => '22',
            'slug' => 'small'
        )
    ) );
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hale_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('hale_content_width', 640);
}

add_action('after_setup_theme', 'hale_content_width', 0);

/**
 * Enqueue scripts and styles.
 */

function hale_action_customize_save_after( $array ) {
    // generate from options on page rather than preview CSS file to avoid editor clash of styles if someone else is previewing at the same time.

    clearstatcache();
    $upload_file_path = wp_get_upload_dir()["basedir"];
    rename ($upload_file_path."/temp-colours-ie.css", $upload_file_path."/custom-colours-ie.css");
    rename ($upload_file_path."/temp-colours.css", $upload_file_path."/custom-colours.css");
};

add_action( 'customize_save_after', 'hale_action_customize_save_after', 10, 1 );

function hale_scripts() {
    // CSS
    $browser_is_IE = (isset($_SERVER['HTTP_USER_AGENT']) && ( (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false ) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) ) );

    wp_enqueue_style('hale-style', hale_mix_asset('/css/style.min.css'));
    if (!$browser_is_IE) wp_enqueue_style('hale-custom-branding', hale_mix_asset('/css/custom-branding.min.css'));

    $t=time();
    if (is_customize_preview()) {
        $css_file_name = "/temp-colours.css?t=$t";
        $css_file_name_IE = "/temp-colours-ie.css?t=$t";
    } else {
        $css_file_name = "/custom-colours.css?t=$t";
        $css_file_name_IE = "/custom-colours-ie.css?t=$t";
    }


    if (is_ssl()) {
        //wp_get_upload_dir()["baseurl"] only returns http.
        $baseURL = str_replace('http://','https://',wp_get_upload_dir()["baseurl"]);
        if (!$browser_is_IE) wp_enqueue_style('hale-custom-colours', $baseURL . $css_file_name);
        wp_enqueue_style('hale-custom-colours-ie', $baseURL . $css_file_name_IE);
    } else {
        if (!$browser_is_IE) wp_enqueue_style('hale-custom-colours', wp_get_upload_dir()["baseurl"] . $css_file_name);
        wp_enqueue_style('hale-custom-colours-ie', wp_get_upload_dir()["baseurl"] . $css_file_name_IE);
    }

    // JS
    wp_enqueue_script('govuk-frontend', hale_mix_asset('/js/govuk-frontend.js'), '', "4.2.0", true);
    wp_enqueue_script('hale-accordion-auto-expand', hale_mix_asset('/js/accordion-auto-expand.js'), '', null, true);
    wp_enqueue_script('hale-scripts', hale_mix_asset('/js/hale-scripts.js'), '', null, true);
    wp_enqueue_script('hale-skip-link-focus-fix', hale_mix_asset('/js/skip-link-focus-fix.js'), '', null, true);
    wp_enqueue_script('hale-navigation', hale_mix_asset('/js/navigation.js'), '', null, true);

    if ( is_post_type_archive('news') ) {
        wp_register_script('news-archive', hale_mix_asset('/js/news-archive.js') );

        $categories = get_terms( array(
            'taxonomy' => 'category'
        ) );
        wp_localize_script(
            'news-archive',
            'news_archive_object',
            array(
                'categories' => $categories
            )
        );

        wp_enqueue_script('news-archive' );
    }
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'hale_scripts');

/**
 * Dequeue nuisance plugins and their scripts.
 *
 * Hooked to the wp_print_scripts action, with a late priority (100),
 * so that it is after the script was enqueued.
 */
function hale_dequeue_scripts()
{

    // Stop a clash from MoJ Blocks plugin, as this theme already uses Gov UK JS
    wp_dequeue_script('mojblocks-govuk-js');
}

add_action('wp_print_scripts', 'hale_dequeue_scripts', 100);

/**
 * @param $filename
 * @return string
 */
function hale_mix_asset($filename)
{

    $manifest = file_get_contents(get_template_directory() . '/dist/mix-manifest.json');
    $manifest = json_decode($manifest, true);

    if (!isset($manifest[$filename])) {
        error_log("Mix asset '$filename' does not exist in manifest.");
    }
    return get_template_directory_uri() . '/dist' . $manifest[$filename];
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enable custom colours for sites.
 */
require get_template_directory() . '/inc/colours.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Add in a limitation to only NHS colour blocks.
 */
require get_template_directory() . '/inc/custom-colours.php';
/**
 * Add in custom Gutenberg modifications.
 */
require get_template_directory() . '/inc/custom-gutenberg.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Pagination
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Breadcrumb element.
 */
require get_template_directory() . '/inc/breadcrumbs.php';

/**
 * Last reviewed.
 */
require get_template_directory() . '/inc/metabox-page-last-reviewed.php';

/**
 * Custom Page Background Metabox
 */
require get_template_directory() . '/inc/metabox-page-background.php';

/**
 * Custom Page Breadcrumb Metabox
 */
require get_template_directory() . '/inc/metabox-page-breadcrumb.php';

/**
 * Custom Page Title Section Metabox
 */
require get_template_directory() . '/inc/metabox-page-title-section.php';

/**
 * Custom News Story Summary Metabox
 */
require get_template_directory() . '/inc/metabox-news-story-summary.php';

/**
 * Custom News Story Author Metabox
 */
require get_template_directory() . '/inc/metabox-news-story-author.php';

/**
 * Widget functions
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Social Widget.
 */
require get_template_directory() . '/inc/widgets/social-widget.php';

/**
 * Create an array of active plugins.
 */

$active_plugins  = apply_filters('active_plugins', get_option('active_plugins'));
$network_plugins = apply_filters('active_plugins', get_site_option('active_sitewide_plugins'));
if (! empty($network_plugins)) { // add network plugins to array if network array isn't empty.
    foreach ($network_plugins as $key => $value) {
        $active_plugins[] = $key;
    }
}

/**
 * LearnDash style over-ride.
 * N.B. This is not a plugin, nor does it provide any plugin-like changes. This is a theme file for
 * the LearnDash plugin so any content generated by LearnDash fits in to this theme.
 * The check around the require is to see if the plugin is active on this install
 */
if (in_array('sfwd-lms/sfwd-lms.php', $active_plugins, true)) {
    if (! is_admin()) {
        require get_template_directory() . '/inc/learndash.php';
    }

    add_action('admin_head', 'hale_learndash_admin_fix');
}

/**
 * Add custom styling to admin header for learndash pages so you can actually use the links. Dont ask.
 */
function hale_learndash_admin_fix()
{
    echo '<!-- Tony woz here --><style type="text/css">
			    #swfd-header {
					position: fixed !important;
					height: 120px;
				}
				@media (min-width: 600px)
					.ld-header-has-tabs .edit-post-layout, .ld-header-has-tabs .edit-post-layout.has-fixed-toolbar {
						padding-top: 120px;
					}
				}
  </style>';
}

/**
 * Restrict Blocks
 */
require get_template_directory() . '/inc/restrict-blocks.php';

/**
 * Custom Post Types
 * When adding a new cpt make sure to add it to the cpts array in customizer
 */
require get_template_directory() . '/inc/custom-post-types/cpt-news.php';
require get_template_directory() . '/inc/custom-post-types/cpt-documents.php';

/**
 * Taxonomies
 */
require get_template_directory() . '/inc/taxonomies/tax-page-category.php';

/**
 * Image management
 */
require get_template_directory() . '/inc/image-management.php';

/**
 * Manage uploads
 */
require get_template_directory() . '/inc/uploads.php';

/**
 * Disable archives 
 */
require get_template_directory() . '/inc/disable-archives.php';
