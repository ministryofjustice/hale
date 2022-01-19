<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

get_header();


?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl">
            News
        </h1>
        <?php if ( is_active_sidebar( 'news-listing' ) ) { ?>
            <div id="hale-news-listing-widgets" class="hale-news_listing__widgets">
                <?php dynamic_sidebar( 'news-listing' ); ?>
            </div>
        <?php } ?>
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-third">
                <div class="news-archive-filter-section">
                    <p>Filter news by topic.</p>

                    <div class="news-archive-filter-form">
                        <form method="GET">

                            <label class="govuk-label" for="news-archive-filter-topic">Topic</label>
                            <?php
                            $dropdown_args = array(
                                "id" => "news-archive-filter-topic",
                                "class" => "govuk-select",
                                'show_option_all' => "All topics",
                                'depth' => 1,
                                'orderby'           => 'name',
                                'order'             => 'ASC',
                                'hierarchical' => 1,
                            );
                            wp_dropdown_categories($dropdown_args);

                            $disabled_subtopics = 'disabled="disabled"';

                            $selected_topic = get_query_var('cat');
                            $selected_sub_topic = get_query_var('subtopic');
                            $sub_topics = [];


                            if (is_numeric($selected_topic)) {

                                $sub_topics = get_terms(array(
                                    'taxonomy' => 'category',
                                    'parent' => $selected_topic
                                ));

                                if (is_array($sub_topics) && !empty($sub_topics)) {
                                    $disabled_subtopics = '';
                                }

                            }


                            ?>
                            <label class="govuk-label" for="news-archive-filter-subtopic">Sub-topic</label>
                            <select name="subtopic" id="news-archive-filter-subtopic"
                                    class="govuk-select" <?php echo $disabled_subtopics; ?>>
                                <option
                                    value="0" <?php if ($selected_sub_topic == 0) { ?> selected="selected" <?php } ?> >
                                    All Sub-topics
                                </option>

                                <?php if (is_array($sub_topics) && !empty($sub_topics)) {
                                    foreach ($sub_topics as $sub_topic) {
                                        ?>
                                        <option
                                            value="<?php echo $sub_topic->term_id; ?>" <?php if ($selected_sub_topic == $sub_topic->term_id) { ?> selected="selected" <?php } ?> ><?php echo $sub_topic->name; ?></option>
                                        <?php

                                    }
                                }
                                ?>
                            </select>
                            <button class="govuk-button">Filter</button>
                        </form>

                    </div>

                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">
                <?php
                if (have_posts()) {
                    $news_story_count = $GLOBALS['wp_query']->found_posts;

                    if($news_story_count > 1){
                        $news_story_count_text = $news_story_count . ' articles';
                    }
                    elseif($news_story_count == 1) {
                        $news_story_count_text = '1 article';
                    }
                    ?>
                    <div class="news-story-count">
                        <?php echo $news_story_count_text; ?>
                    </div>
                    <div class="news-story-list">
                        <?php
                        while (have_posts()) {
                            the_post();
                            get_template_part( 'template-parts/content', 'news-list-item' );
                        } ?>
                    </div>
                    <?php
                    hale_archive_pagination('archive');
                } else { ?>
                    <p><?php _e('No news articles found', 'hale'); ?></p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php

get_footer();
