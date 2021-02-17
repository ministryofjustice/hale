<?php

/**
 * MetaBox for managing the Page Breadcrumb
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

add_action('add_meta_boxes', 'hale_page_breadcrumb_metabox');

function hale_page_breadcrumb_metabox()
{
    add_meta_box(
        'hale-display-page-breadcrumb-metabox',
        __('Breadcrumb', 'hale'),
        'hale_render_page_breadcrumb_metabox',
        'page',
        'side',
        'core'
    );
}

/**
 * Render Page Breadcrumb Metabox
 *
 * @param array $post the post variables.
 */
function hale_render_page_breadcrumb_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_page_metabox_breadcrumb_nonce');

    // get previously saved meta values (if any).
    $display_breadcrumb = get_post_meta($post->ID, 'hale_metabox_page_breadcrumb', true);

    if (empty($display_breadcrumb)) {
        $display_breadcrumb = 'yes';
    }

    ?>

    <p><?php esc_html_e('Show Breadcrumb', 'hale'); ?></p>

    <input type="radio" id="page-breadcrumb-on" name="displayPageBreadcrumb" value="yes"
        <?php
        if ($display_breadcrumb == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-breadcrumb-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="page-breadcrumb-off" name="displayPageBreadcrumb" value="no"
        <?php
        if ($display_breadcrumb == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-breadcrumb-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_page_breadcrumb_settings');

function hale_save_page_breadcrumb_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if (isset($_POST['hale_page_metabox_breadcrumb_nonce'])) {
        $hale_page_metabox_breadcrumb_nonce = sanitize_text_field(wp_unslash($_POST['hale_page_metabox_breadcrumb_nonce']));
    } else {
        $hale_page_metabox_breadcrumb_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['hale_page_metabox_breadcrumb_nonce']) && (wp_verify_nonce($hale_page_metabox_breadcrumb_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['displayPageBreadcrumb'])) {
        $display_breadcrumb = sanitize_text_field(wp_unslash($_POST['displayPageBreadcrumb']));
        update_post_meta($post_id, 'hale_metabox_page_breadcrumb', wp_unslash($display_breadcrumb));
    }
}
