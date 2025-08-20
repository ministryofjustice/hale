<?php

/**
 * MetaBox for managing the display option for the Numbered Headings
 */

add_action('add_meta_boxes', 'hale_page_numbered_headings_metabox');

function hale_page_numbered_headings_metabox()
{
    add_meta_box(
        'hale-display-page-numbered-headings-metabox',
        __('Numbered headings', 'hale'),
        'hale_render_page_numbered_headings_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Show Numbered Headings Metabox
 *
 * @param array $post the post variables.
 */
function hale_render_page_numbered_headings_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_metabox_numbered_headings_nonce');

    // get previously saved meta values (if any).
    $display_numbered_headings = get_post_meta($post->ID, 'hale_metabox_page_numbered_headings', true);

    if (empty($display_numbered_headings)) {
        $display_numbered_headings = 'no';
    }

    ?>

    <p><?php esc_html_e('Show Numbered Headings', 'hale'); ?></p>
    <p><?php esc_html_e('Add numbers to the H2 headings', 'hale'); ?></p>
    <input type="radio" id="page-numbered-headings-on" name="displayNumberedHeadings" value="yes"
        <?php
        if ($display_numbered_headings == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-numbered-headings-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="page-numbered-headings-off" name="displayNumberedHeadings" value="no"
        <?php
        if ($display_numbered_headings == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-numbered-headings-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_page_numbered_headings_settings');

function hale_save_page_numbered_headings_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if (isset($_POST['hale_page_metabox_numbered_headings_nonce'])) {
        $hale_page_metabox_numbered_headings_nonce = sanitize_text_field(wp_unslash($_POST['hale_page_metabox_numbered_headings_nonce']));
    } else {
        $hale_page_metabox_numbered_headings_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['hale_page_metabox_numbered_headings_nonce']) && (wp_verify_nonce($hale_page_metabox_numbered_headings_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['displayNumberedHeadings'])) {
        $display_numbered_headings = sanitize_text_field(wp_unslash($_POST['displayNumberedHeadings']));
        update_post_meta($post_id, 'hale_metabox_page_numbered_headings', wp_unslash($display_numbered_headings));
    }
}
