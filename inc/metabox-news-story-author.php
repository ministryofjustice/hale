<?php

/**
 * Metabox Show/Hide News Story Author
 *
 * @package   Hale
 * @copyright Ministry Of Justice
 * @version   1.0
 */

// Add the new meta box to side of editor page
add_action('add_meta_boxes', 'hale_metabox_news_story_author');

function hale_metabox_news_story_author()
{
    add_meta_box(
        'hale-news-story-author-metabox',
        __('Author', 'hale'),
        'hale_render_news_story_author_metabox',
        'news',
        'side',
        'core'
    );
}

/**
 * Render the metabox and it's contents to the page.
 */
function hale_render_news_story_author_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_metabox_news_story_author_nonce');

    $display_author = get_post_meta($post->ID, 'hale_show_news_story_author', true);

    if (empty($display_author) || $display_author != 'yes') {
        $display_author = 'no';
    }
    ?>

    <p><?php esc_html_e('Show News Story Author', 'hale'); ?></p>

    <input type="radio" id="news-story-author-on" name="news-story-author" value="yes"
        <?php
        if ($display_author == 'yes') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-bg-color-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="news-story-author-off" name="news-story-author" value="no"
        <?php
        if ($display_author == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="page-bg-color-off"><?php esc_html_e('No', 'hale'); ?></label><br>

    <?php
}

add_action('save_post', 'hale_save_news_story_author_settings');
/**
 * Sends any saved news author settings to the DB when user saves post.
 *
 * @param int $post_id the unique post identifier.
 */
function hale_save_news_story_author_settings($post_id)
{
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    $get_settings_nonce = isset($_POST['hale_metabox_news_story_author_nonce']) ? $_POST['hale_metabox_news_story_author_nonce'] : '';

    $hale_metabox_news_story_author_nonce = isset($get_settings_nonce) ? sanitize_text_field(wp_unslash($get_settings_nonce)) : '';

    $is_valid_nonce = ( isset($get_settings_nonce) && ( wp_verify_nonce($hale_metabox_news_story_author_nonce, basename(__FILE__)) ) ) ? true : false;

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['news-story-author'])) {
        $page_bg_colour = sanitize_text_field(wp_unslash($_POST['news-story-author']));
        update_post_meta($post_id, 'hale_show_news_story_author', esc_attr(wp_unslash($page_bg_colour)));
    }
}

