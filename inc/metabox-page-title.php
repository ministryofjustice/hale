<?php
function nightingale_page_title_metabox()
{
    add_meta_box(
        'nightingale-display-page-title-metabox',
        __('Page Title Settings', 'nightingale'),
        'nightingale_render_page_title_metabox',
        'page',
        'side',
        'core'
    );
}

add_action('add_meta_boxes', 'nightingale_page_title_metabox');

/**
 * Render the last reviewed.
 *
 * @param array $post the post variables.
 */
function nightingale_render_page_title_metabox($post)
{

    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'nightingale-page-title-nonce');

    // get previously saved meta values (if any).
    $show_title = get_post_meta($post->ID, 'display-page-title', true);

    if(empty($show_title)){
        $show_title = 'yes';
    }
    ?>

    <p><?php esc_html_e('Display Page Title', 'nightingale'); ?></p>
    <input type="radio" id="page-title-on" name="displayPageTitle" value="yes"
        <?php
        if ($show_title == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-title-on"><?php esc_html_e('Yes', 'nightingale'); ?></label><br>
    <input type="radio" id="page-title-off" name="displayPageTitle" value="no"
        <?php
        if ($show_title == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-title-off"><?php esc_html_e('No', 'nightingale'); ?></label><br>

    <?php

}

function nightingale_save_page_title_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    if (isset($_POST['nightingale-page-title-nonce'])) {
        $nightingale_colour_picker_nonce = sanitize_text_field(wp_unslash($_POST['nightingale-page-title-nonce']));
    } else {
        $nightingale_colour_picker_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['nightingale-page-title-nonce']) && (wp_verify_nonce($nightingale_colour_picker_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['displayPageTitle'])) {
        $show_title = sanitize_text_field(wp_unslash($_POST['displayPageTitle']));
        update_post_meta($post_id, 'display-page-title', wp_unslash($show_title));
    }

}

add_action('save_post', 'nightingale_save_page_title_settings');
