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
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-third">
                <div class="news-archive-filter-section">
                    <p>You can use the filters to show only news items that match your interests.</p>

                    <div class="news-archive-filter-form">
                        <form method="GET">

                            <div></div>
                            <label class="govuk-label" for="news-archive-filter-topic">Topic</label>
                            <?php
                            $dropdown_args = array(
                                "id" => "news-archive-filter-topic",
                                "class" => "govuk-select",
                                'show_option_all' => "All topics",
                                'depth' => 1,
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
                    ?>
                    <div class="news-story-count">
                        <?php echo $news_story_count; ?> articles
                    </div>
                    <div class="news-story-list">
                        <?php
                        while (have_posts()) {
                            the_post(); ?>
                            <div class="news-story-list-item">
                                <h2 class="news-story-list-item-title hale-heading-s"><a
                                        href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                                <div class="news-story-published-date">
                                    Published: <?php hale_posted_on(); ?>
                                </div>
                                <?php
                                $story_categories = get_the_category();

                                $story_tags = get_the_tags();

                                if (!empty($story_categories) || !empty($story_tags)) { ?>
                                    <div class="news-story-categories">
                                        <ul class="news-story-categories-list">
                                            <?php
                                            if (!empty($story_categories)) {
                                                foreach ($story_categories as $story_category) {
                                                    ?>
                                                    <li class="news-story-categories-list-item">
                                                        <a href="<?php echo get_category_link($story_category->term_id); ?>"
                                                           class="news-story-category-link">
                                                            <?php echo $story_category->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if (!empty($story_tags)) {
                                                foreach ($story_tags as $story_tag) {
                                                    ?>
                                                    <li class="news-story-categories-list-item">
                                                        <a href="<?php echo get_tag_link($story_tag->term_id); ?>"
                                                           class="news-story-category-link">
                                                            <?php echo $story_tag->name; ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="news-story-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <?php
                    hale_archive_pagination();
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
