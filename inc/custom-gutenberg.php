<?php
/**
 * Block editor styles for Hale.
 *
 * Two distinct targets:
 *   - Canvas (the post content area) -> add_editor_style() + block_editor_settings_all
 *   - Chrome (sidebars, toolbars, block styles preview) -> enqueue_block_editor_assets
 *
 * Since WordPress 6.3 the post editor canvas may be iframed. In WordPress 7.0 the
 * decision is made per post, based on the apiVersion of the blocks actually
 * inserted in the content, so the SAME site can be iframed on one post and not on
 * another. Styles enqueued via enqueue_block_editor_assets only ever reach the
 * parent admin document, so anything scoped to .interface-interface-skeleton__content,
 * .edit-post-visual-editor, .primary-font--* or .hale-page silently fails whenever
 * the canvas is iframed.
 *
 * add_editor_style() covers both cases: WordPress injects the CSS into the canvas
 * and prefixes selectors with .editor-styles-wrapper regardless of iframing.
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 **/

/**
 * Register the canvas stylesheet.
 *
 * WordPress reads this file server-side and injects its contents into the canvas,
 * rewriting html/body/:root to .editor-styles-wrapper. Relies on the
 * add_theme_support('editor-styles') declared in functions.php.
 *
 * The path is theme-relative and deliberately unversioned: the file is inlined
 * rather than linked, so hale_mix_asset() cache-busting has no effect here.
 */
function hale_add_editor_styles()
{
    add_editor_style('dist/css/editor-canvas.min.css');
}

add_action('after_setup_theme', 'hale_add_editor_styles');

/**
 * Webfont for the canvas.
 *
 * enqueue_block_assets fires in both the editor and on the front end. In the
 * editor, _wp_get_iframed_editor_assets() collects what is queued here and emits
 * real <link> tags inside the iframe, which an inlined CSS @import cannot reliably do.
 */
function hale_editor_canvas_font()
{
    if (!is_admin()) {
        return;
    }

    wp_enqueue_style(
        'hale-webfont',
        'https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        [],
        null
    );
}

add_action('enqueue_block_assets', 'hale_editor_canvas_font');

/**
 * Per-site custom colours and the customizer font choice, injected into the canvas.
 *
 * The colours file is read from disk rather than passed to add_editor_style() as a
 * URL, because core fetches remote editor styles with wp_remote_get() on every
 * editor load.
 *
 * @param array                   $settings Block editor settings.
 * @param WP_Block_Editor_Context $context  Editor context.
 *
 * @return array
 */
function hale_editor_canvas_inline_styles($settings, $context)
{
    if (empty($context->post)) {
        return $settings;
    }

    $colours_file = wp_get_upload_dir()['basedir'] . '/custom-colours.css';

    if (is_readable($colours_file)) {
        $settings['styles'][] = [
            'css' => file_get_contents($colours_file),
        ];
    }

    // transformStyles() rewrites :root to .editor-styles-wrapper, so the custom
    // property lands on the canvas root and inherits normally.
    $fonts = [
        'pt-sans'  => "'PT Sans', sans-serif",
        'frutiger' => "'Frutiger', sans-serif",
    ];

    $font = get_theme_mod('primary_font', 'pt-sans');

    if (isset($fonts[$font])) {
        $settings['styles'][] = [
            'css' => ':root { --hale-primary-font: ' . $fonts[$font] . '; }',
        ];
    }

    return $settings;
}

add_filter('block_editor_settings_all', 'hale_editor_canvas_inline_styles', 10, 2);

/**
 * Chrome styles.
 *
 * These stay on enqueue_block_editor_assets because they target the editor UI
 * outside the iframe, where .primary-font--*, .edit-post-visual-editor and
 * .interface-interface-skeleton__content do exist.
 */
function hale_gutenberg_editor_styles()
{
    $screen = get_current_screen();

    // Only apply to edit backend pages.
    if ('post' !== $screen->base) {
        return;
    }

    wp_enqueue_style('hale-gutenburg-style', hale_mix_asset('/css/style-gutenburg.min.css'));
    wp_enqueue_style('hale-editor-branding', hale_mix_asset('/css/editor-branding.min.css'));

    $t = time();
    $css_file_name = "/custom-colours.css?t=$t";

    if (is_ssl()) {
        //wp_get_upload_dir()["baseurl"] only returns http.
        $baseURL = str_replace('http://', 'https://', wp_get_upload_dir()["baseurl"]);
        wp_enqueue_style('hale-custom-colours', $baseURL . $css_file_name);
    } else {
        wp_enqueue_style('hale-custom-colours', wp_get_upload_dir()["baseurl"] . $css_file_name);
    }
}

add_action('enqueue_block_editor_assets', 'hale_gutenberg_editor_styles', 100);
