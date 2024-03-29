<?php

/**
 * MetaBox for managing the News Story Summary
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

add_action('add_meta_boxes', 'hale_news_story_summary_metabox');

function hale_news_story_summary_metabox()
{
    add_meta_box(
        'hale-display-news-story-summary-metabox',
        __('Summary', 'hale'),
        'hale_render_news_story_summary_metabox',
        'news',
        'side',
        'core'
    );
}

/**
 * Render News Story Summary Metabox
 *
 * @param array $post the post variables.
 */
function hale_render_news_story_summary_metabox($post)
{
    // generate a nonce field.
    wp_nonce_field(basename(__FILE__), 'hale_news_story_summary_nonce');

    // get previously saved meta values (if any).
    $news_story_summary = get_post_meta($post->ID, 'news_story_summary', true);

    $news_story_show_summary = get_post_meta($post->ID, 'news_story_show_summary', true);

    if (empty($news_story_show_summary)) {
        $news_story_show_summary = 'yes';
    }
    ?>

    <p><?php esc_html_e('Please enter a short summary about the news story', 'hale'); ?></p>

    <textarea name="newsStorySummary" class="css-1806jio-StyledTextarea-inputStyleNeutral-inputStyleFocus-inputControl" rows="4"><?php echo $news_story_summary; ?></textarea>

    <br/><br/>

    <p><?php esc_html_e('Show summary on news article', 'hale'); ?></p>

    <input type="radio" id="news-summary-on" name="displayNewsSummary" value="yes"
        <?php
        if ($news_story_show_summary == 'yes') :
            echo 'checked';
        endif;
        ?>
    >

    <label for="news-summary-on"><?php esc_html_e('Yes', 'hale'); ?></label><br>
    <input type="radio" id="news-summary-off" name="displayNewsSummary" value="no"
        <?php
        if ($news_story_show_summary == 'no') :
            echo 'checked';
        endif;
        ?>
    >
    <label for="news-summary-off"><?php esc_html_e('No', 'hale'); ?></label><br>
    <?php
}

add_action('save_post', 'hale_save_news_story_summary_settings');

function hale_save_news_story_summary_settings($post_id)
{
    // checking if the post being saved is a 'page',
    // if not, then return.
    global $pagenow;

    if ('post.php' !== $pagenow && 'post-new.php' !== $pagenow) {
        return;
    }

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);

    if (isset($_POST['hale_news_story_summary_nonce'])) {
        $hale_news_story_summary_nonce = sanitize_text_field(wp_unslash($_POST['hale_news_story_summary_nonce']));
    } else {
        $hale_news_story_summary_nonce = '';
    }
    $is_valid_nonce = (isset($_POST['hale_news_story_summary_nonce']) && (wp_verify_nonce($hale_news_story_summary_nonce, basename(__FILE__)))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['newsStorySummary'])) {
        $news_story_summary = sanitize_text_field(wp_unslash($_POST['newsStorySummary']));

        update_post_meta($post_id, 'news_story_summary', $news_story_summary);
    }

    if (isset($_POST['displayNewsSummary'])) {

        $news_story_show_summary = sanitize_text_field(wp_unslash($_POST['displayNewsSummary']));

        //Makes sure yes/no can only be passed
        if(empty($news_story_show_summary) || $news_story_show_summary != 'no'){
            $news_story_show_summary = 'yes';
        }

        update_post_meta($post_id, 'news_story_show_summary', $news_story_show_summary);
    }

}
