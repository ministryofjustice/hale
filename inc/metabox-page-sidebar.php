<?php

/**
 * MetaBox for managing the sidebar
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

add_action('add_meta_boxes', 'hale_page_sidebar_metabox');

function hale_page_sidebar_metabox()
{
    add_meta_box(
        'hale-display-page-sidebar-metabox',
        __('Sidebar', 'hale'),
        'hale_render_page_sidebar_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Render the last reviewed.
 *
 * @param array $post the post variables.
 */
function hale_render_page_sidebar_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_metabox_sidebar_nonce');

    // get previously saved meta values (if any).
    $display_sidebar = get_post_meta($post->ID, 'hale_metabox_page_sidebar', true);

    if (empty($display_sidebar)) {
        $display_sidebar = 'yes';
    }

    ?>

    <p><?php esc_html_e('Show sidebar', 'hale'); ?></p>

    <input type="radio" id="page-sidebar-on" name="displayPageSidebar" value="yes"
        <?php
        if ($display_sidebar == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-sidebar-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="page-sidebar-off" name="displayPageSidebar" value="no"
        <?php
        if ($display_sidebar == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-sidebar-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_page_sidebar_settings');

function hale_save_page_sidebar_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if (isset($_POST['hale_page_metabox_sidebar_nonce'])) {
        $hale_colour_picker_nonce = sanitize_text_field(wp_unslash($_POST['hale_page_metabox_sidebar_nonce']));
    } else {
        $hale_colour_picker_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['hale_page_metabox_sidebar_nonce']) && (wp_verify_nonce($hale_colour_picker_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['displayPageSidebar'])) {
        $display_sidebar = sanitize_text_field(wp_unslash($_POST['displayPageSidebar']));
        update_post_meta($post_id, 'hale_metabox_page_sidebar', wp_unslash($display_sidebar));
    }
}
