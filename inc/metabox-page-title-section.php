<?php

/**
 * MetaBox for managing the display option for the Page Title section (Page Title and Category Nav)
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

add_action('add_meta_boxes', 'hale_page_title_section_metabox');

function hale_page_title_section_metabox()
{
    add_meta_box(
        'hale-display-page-title-section-metabox',
        __('Title Section', 'hale'),
        'hale_render_page_title_section_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Render Page Title Section Metabox
 *
 * @param array $post the post variables.
 */
function hale_render_page_title_section_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_metabox_title_section_nonce');

    // get previously saved meta values (if any).
    $display_title_section = get_post_meta($post->ID, 'hale_metabox_page_title_section', true);

    if (empty($display_title_section)) {
        $display_title_section = 'yes';
    }

    ?>

    <p><?php esc_html_e('Show Title Section', 'hale'); ?></p>

    <input type="radio" id="page-title-section-on" name="displayPageTitleSection" value="yes"
        <?php
        if ($display_title_section == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-title-section-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="page-title-section-off" name="displayPageTitleSection" value="no"
        <?php
        if ($display_title_section == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-title-section-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_page_title_section_settings');

function hale_save_page_title_section_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if (isset($_POST['hale_page_metabox_title_section_nonce'])) {
        $hale_page_metabox_title_section_nonce = sanitize_text_field(wp_unslash($_POST['hale_page_metabox_title_section_nonce']));
    } else {
        $hale_page_metabox_title_section_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['hale_page_metabox_title_section_nonce']) && (wp_verify_nonce($hale_page_metabox_title_section_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['displayPageTitleSection'])) {
        $display_title_section = sanitize_text_field(wp_unslash($_POST['displayPageTitleSection']));
        update_post_meta($post_id, 'hale_metabox_page_title_section', wp_unslash($display_title_section));
    }
}
