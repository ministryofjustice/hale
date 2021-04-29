<?php

/**
 * Metabox custom background
 *
 * @package   Hale
 * @copyright Ministry Of Justice
 * @version   1.0
 */

// Add the new meta box to side of editor page
add_action('add_meta_boxes', 'hale_metabox_page_background');

function hale_metabox_page_background()
{
    add_meta_box(
        'hale-page-background-metabox',
        __('Background', 'hale'),
        'hale_render_page_background_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Render the metabox and it's contents to the page.
 */
function hale_render_page_background_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_metabox_background_nonce');

    $page_bg_colour = get_post_meta($post->ID, 'hale_page_bg_colour', true);

    if (empty($page_bg_colour) || $page_bg_colour != 'yes') {
        $page_bg_colour = 'no';
    }
    ?>

    <p><?php esc_html_e('Page background colour', 'hale'); ?></p>

    <input type="radio" id="page-bg-color-on" name="page-bg-colour" value="yes"
        <?php
        if ($page_bg_colour == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-bg-color-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="page-bg-color-off" name="page-bg-colour" value="no"
        <?php
        if ($page_bg_colour == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-bg-color-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_page_background_settings');
/**
 * Sends any saved background settings to the DB when user saves post.
 *
 * @param int $post_id the unique post identifier.
 */
function hale_save_page_background_settings($post_id)
{
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    $get_settings_nonce = isset($_POST['hale_page_metabox_background_nonce']) ? $_POST['hale_page_metabox_background_nonce'] : '';

    $hale_page_metabox_background_nonce = isset($get_settings_nonce) ? sanitize_text_field(wp_unslash($get_settings_nonce)) : '';

    $is_valid_nonce = ( isset($get_settings_nonce) && ( wp_verify_nonce($hale_page_metabox_background_nonce, basename(__FILE__)) ) ) ? true : false;

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['page-bg-colour'])) {
        $page_bg_colour = sanitize_text_field(wp_unslash($_POST['page-bg-colour']));
        update_post_meta($post_id, 'hale_page_bg_colour', esc_attr(wp_unslash($page_bg_colour)));
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
    if (is_page(get_the_id())) {

        // Get page bg value, is it set to display or not
        $page_bg_colour = get_post_meta(get_the_id(), 'hale_page_bg_colour', true);

        // If it's a new page, set page bg to "no" by default
        if (empty($page_bg_colour) || $page_bg_colour != 'yes') {
            $page_bg_colour = 'no';
        }

        if($page_bg_colour == 'yes'){

            $classes[] =  'page-body-colour';

        }

    }

    return $classes;
}
