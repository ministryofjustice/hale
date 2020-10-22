<?php

/**
 * Setup Custom Page Settings metabox
 *
 * @package   Hale
 * @copyright Ministry Of Justice
 * @version   1.0
 */

// Add the new meta box to side of editor page
add_action('add_meta_boxes', 'hale_page_custom_settings_metabox');

function hale_page_custom_settings_metabox()
{
    add_meta_box(
        'hale-page-custom-settings-metabox',
        __('Custom Page Settings', 'hale'),
        'hale_render_page_custom_settings_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Render the metabox and it's contents to the page.
 */
function hale_render_page_custom_settings_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_custom_settings_metabox_nonce');

    // Settings for Setting Hale Page Background Colour
    $theme_colours = hale_get_theme_colours();
    $hale_page_bg_colour = esc_attr(get_post_meta($post->ID, 'hale_page_bg_colour', true));
    ?>

    <label for="page-bg-colour-picker"><?php esc_html_e('Set page background colour.', 'hale'); ?></label>
    <select id="page-bg-colour-picker" name="page-bg-colour-picker" class="wide">
        <?php foreach ($theme_colours as $name => $colour) : ?>
            <?php $select = esc_attr(sanitize_title($colour)) === $hale_page_bg_colour ? 'selected' : ''; ?>
            <option value="<?php echo esc_attr(sanitize_title($colour)); ?>" <?php echo esc_html($select); ?> >
            <?php echo esc_html($colour); ?></option>
        <?php endforeach; ?>
    </select>

    <?php
}

add_action('save_post', 'hale_save_page_custom_settings');
/**
 * Sends any saved custom settings to the DB when user saves post.
 *
 * @param int $post_id the unique post identifier.
 */
function hale_save_page_custom_settings($post_id)
{
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    $get_settings_nonce = $_POST['hale_page_custom_settings_metabox_nonce'];

    $hale_page_custom_settings_metabox_nonce = isset($get_settings_nonce) ? sanitize_text_field(wp_unslash($get_settings_nonce)) : '';

    $is_valid_nonce = ( isset($get_settings_nonce) && ( wp_verify_nonce($hale_page_custom_settings_metabox_nonce, basename(__FILE__)) ) ) ? true : false;

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['page-bg-colour-picker'])) {
        $page_bg_colour_picker = sanitize_text_field(wp_unslash($_POST['page-bg-colour-picker']));
        update_post_meta($post_id, 'hale_page_bg_colour', esc_attr(wp_unslash($page_bg_colour_picker)));
    }
}


add_filter('body_class', 'hale_append_selected_bg_colour_to_body');

/**
 * Appends the selected background colour to the body CSS class of the theme
 *
 * @param string
 */
function hale_append_selected_bg_colour_to_body($classes)
{
    $page_bg_color = esc_attr(get_post_meta(get_the_id(), 'hale_page_bg_colour', true));

    // If a selected colour exsits in the DB add the name to the CSS class and add to WP body class array, if not, return the $classes array.
    $classes = $page_bg_color ? array_merge($classes, [ 'page-body-color--' . $page_bg_color ]) : $classes;

    return $classes;
}
