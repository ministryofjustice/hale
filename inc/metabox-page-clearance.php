<?php
function nightingale_page_clearance_metabox()
{
    add_meta_box(
        'nightingale-display-page-clearance-metabox',
        __('Page Clearance Settings', 'nightingale'),
        'nightingale_render_page_clearance_metabox',
        'page',
        'side',
        'core'
    );
}

add_action('add_meta_boxes', 'nightingale_page_clearance_metabox');

function nightingale_render_page_clearance_metabox($post)
{

    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'nightingale-page-clearance-nonce');

    // get previously saved meta values (if any).
    $header_clr = get_post_meta($post->ID, 'page-header-clearance', true);

    if(empty($header_clr)){
        $header_clr = 'yes';
    }
    ?>

    <p><?php esc_html_e('Header Clearance', 'nightingale'); ?></p>
    <p><?php esc_html_e('This adds vertical spacing between the header and start of the page content', 'nightingale'); ?></p>
    <input type="radio" id="header-clearance-on" name="headerClearance" value="yes"
        <?php
        if ($header_clr == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="header-clearance-on"><?php esc_html_e('Yes', 'nightingale'); ?></label><br>
    <input type="radio" id="header-clearance-off" name="headerClearance" value="no"
        <?php
        if ($header_clr == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="header-clearance-off"><?php esc_html_e('No', 'nightingale'); ?></label><br>

    <?php

}

function nightingale_save_page_clearance_settings($post_id)
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
        $nightingale_colour_picker_nonce = sanitize_text_field(wp_unslash($_POST['nightingale-page-clearance-nonce']));
    } else {
        $nightingale_colour_picker_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['nightingale-page-clearance-nonce']) && (wp_verify_nonce($nightingale_colour_picker_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['headerClearance'])) {
        $show_title = sanitize_text_field(wp_unslash($_POST['headerClearance']));
        update_post_meta($post_id, 'page-header-clearance', wp_unslash($show_title));
    }

}

add_action('save_post', 'nightingale_save_page_clearance_settings');
