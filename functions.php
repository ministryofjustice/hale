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
    load_theme_textdomain('hale',get_template_directory() . '/languages');
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
    rename ($upload_file_path."/temp-colours.css", $upload_file_path."/custom-colours.css");
};

add_action( 'customize_save_after', 'hale_action_customize_save_after', 10, 1 );

function hale_scripts() {
    wp_enqueue_style('hale-style', hale_mix_asset('/css/style.min.css'));
    wp_enqueue_style('hale-custom-branding', hale_mix_asset('/css/custom-branding.min.css'));
    
    $t=time();

    if (is_customize_preview()) {
        $css_file_name = "/temp-colours.css?t=$t";
    } else {
        $css_file_name = "/custom-colours.css?t=$t";
    }


    if (is_ssl()) {
        //wp_get_upload_dir()["baseurl"] only returns http.
        $baseURL = str_replace('http://','https://',wp_get_upload_dir()["baseurl"]);
        wp_enqueue_style('hale-custom-colours', $baseURL . $css_file_name);
    } else {
        wp_enqueue_style('hale-custom-colours', wp_get_upload_dir()["baseurl"] . $css_file_name);
    }

    // JS
    wp_enqueue_script('govuk-frontend', hale_mix_asset('/js/govuk-frontend.js'), '', "5.0.0", true);
    wp_enqueue_script('hale-accordion-auto-expand', hale_mix_asset('/js/accordion-auto-expand.js'), '', null, true);
    wp_enqueue_script('hale-combined-scripts', hale_mix_asset('/js/hale-combined-scripts.js'), '', null, true);

    // Load Listing template JS
    if ( is_page_template('page-listing.php') ) {
        $script_path = get_template_directory() . '/dist/js/page-listing.js';
        $script_version = file_exists($script_path) ? filemtime($script_path) : false;
        wp_register_script('page-listing', hale_mix_asset('/js/page-listing.js'), array(), $script_version, true);
        wp_enqueue_script('page-listing');
    }

    if ( is_page_template('page-hearing-list.php') ) {

        //autocomplete styles and js
        wp_enqueue_style('hale-autocomplete', hale_mix_asset('/css/accessible-autocomplete.min.css'));
        wp_enqueue_script('autocomplete', hale_mix_asset('/js/accessible-autocomplete.min.js'), '', "3.0.1", true);

        //used for date picker
        wp_enqueue_script('moj-frontend', hale_mix_asset('/js/moj-frontend.js'), '', "3.2.0", true);

        $script_path = get_template_directory() . '/dist/js/multiselect-filter.js';
        $script_version = file_exists($script_path) ? filemtime($script_path) : false;
        wp_register_script('multiselect-filter', hale_mix_asset('/js/multiselect-filter.js'), array(), $script_version, true);
        wp_enqueue_script('multiselect-filter');
    }

}

add_action('wp_enqueue_scripts', 'hale_scripts');

/**
 * Enqueue listing template JS and 
 * localize the script with data
 */
require get_template_directory() . '/inc/listing-template/localize-script-data.php';

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
    $manifest_path = get_template_directory() . '/dist/mix-manifest.json';
    
    if (!file_exists($manifest_path)) {
        error_log("Mix manifest file does not exist at path: $manifest_path");
        return '';
    }

    $manifest_content = file_get_contents($manifest_path);
    $manifest = json_decode($manifest_content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Error decoding JSON from mix manifest: " . json_last_error_msg());
        return '';
    }

    if (!isset($manifest[$filename])) {
        error_log("Mix asset '$filename' does not exist in manifest.");
        return '';
    }

    return get_template_directory_uri() . '/dist' . $manifest[$filename];
}


/**
 * Taxonomies functions
 */
require get_template_directory() . '/inc/taxonomies.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enable custom colours for sites.
 */
require get_template_directory() . '/inc/colours.php';
/**
 * Functions which enable address sanitization and job listing stuff.
 */
require get_template_directory() . '/inc/job-listing.php';

/**
 * Functions for hearing list template
 */
require get_template_directory() . '/inc/hearing-list.php';

/**
 * Functions which holds the prison location data.
 */
require get_template_directory() . '/inc/job-prison-locations.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
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
 * Footer scripts element.
 */
require get_template_directory() . '/inc/footer-scripts.php';

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
 * Widget functions
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Social Widget.
 */
require get_template_directory() . '/inc/widgets/social-widget.php';

/**
 * Emergency and critical info banners
 */
require get_template_directory() . '/inc/banner-settings.php';

/**
 * Flexible Custom Post Types
 */
require get_template_directory() . '/inc/flexible-cpts.php';

/**
 * ACF additions
 */

 // Admin changes
require get_template_directory() . '/inc/acf/admin/settings.php';
require get_template_directory() . '/inc/acf/admin/post-display-settings.php';
require get_template_directory() . '/inc/acf/admin/post-banner-settings.php';
require get_template_directory() . '/inc/acf/admin/taxonomy-settings.php';

// General utilities
require get_template_directory() . '/inc/acf/utilities.php';

// Register fields
require get_template_directory() . '/inc/acf/post-type-fields/add-field-groups.php';
require get_template_directory() . '/inc/acf/post-type-fields/field-document-upload.php';
require get_template_directory() . '/inc/acf/post-type-fields/field-summary.php';
require get_template_directory() . '/inc/acf/post-type-fields/field-banner.php';

// Register taxonomies
require get_template_directory() . '/inc/acf/taxonomy-fields/add-taxonomy.php';

// Stop ACF from saving or loading JSON files
require get_template_directory() . '/inc/acf/disable-json.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/dashboard-customisations.php';

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

/**
 * Remove default post type 
 */
require get_template_directory() . '/inc/remove-default-post-type.php';

function hale_manage_page_templates($post_templates,  $theme, $post, $post_type)
{

    if(is_admin()) {
        $screen = get_current_screen();

        //Checks if on page edit screen - means all templates show on acf settings
        if ($screen && $screen->base == "post" && $screen->post_type == "page") {

            //Checks if page templates are being requested
            if ($post_type == 'page') {

                if (!post_type_exists('job')) {
                    unset($post_templates['page-job-listing.php']);
                }
                
                if (!post_type_exists('hearing')) {
                    unset($post_templates['page-hearing-list.php']);
                }

            }
        }
    }
    return $post_templates;
}

add_filter( 'theme_templates', 'hale_manage_page_templates' , 10, 4);

function hale_add_module_tag( $tag, $handle, $src ) {
    $modules = ["govuk-frontend"];
    if ( in_array($handle, $modules) ) {
        $tag = str_replace( 'src=', 'type="module" src=', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'hale_add_module_tag', 10, 3 );

// Remove Yoast `SEO Manager` role
if ( get_role('wpseo_manager') ) {
    remove_role( 'wpseo_manager' );
}

// Remove Yoast `SEO Editor` role
if ( get_role('wpseo_editor') ) {
    remove_role( 'wpseo_editor' );
}

//Remove relevanssi throttle as it prevents some documents and pages showing on listing and search pages
remove_filter( 'relevanssi_query_filter', 'relevanssi_limit_filter' );

/**
 * Add options for lang attribute for footer menu links
 */
require get_template_directory() . '/inc/footer-language-attributes.php';

/**
 * Utility functions to help with various tasks
 */
require get_template_directory() . '/inc/helper-functions.php';

/**
 * Extend API with custom post type info
 */
require get_template_directory() . '/inc/api-extensions.php';
