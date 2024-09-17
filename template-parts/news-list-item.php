<?php
/**
 * Template part for displaying news list item
 */
?>

<div class="news-story-list-item">
    <h2 class="news-story-list-item__title"><a
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
                                <span class="govuk-visually-hidden">
                                    <?php _e("See items with the topic: "); ?>
                                </span>
                                <strong>
                                    <?php echo esc_html($story_category->name); ?>
                                </strong>
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
                                <span class="govuk-visually-hidden">
                                    <?php _e("See items tagged: "); ?>
                                </span>
                                <strong>
                                    #<?php echo esc_html($story_tag->name); ?>
                                </strong>
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
        <?php

        $news_story_summary = get_field('post_summary');

        if(empty($news_story_summary)){
            $news_story_summary = get_post_meta($post->ID, 'news_story_summary', true);
        }

        if(!empty($news_story_summary)){
            echo wpautop($news_story_summary);
        }
        ?>
    </div>
</div>