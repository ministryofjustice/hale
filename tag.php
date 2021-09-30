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
        <h1 class="govuk-heading-xl"><?php
            echo '#' . single_tag_title('', false);
            ?>
        </h1>
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-two-thirds">
                <?php
                if (have_posts()) {
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
                                                        #<?php echo $story_tag->name; ?>
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
                    }
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
