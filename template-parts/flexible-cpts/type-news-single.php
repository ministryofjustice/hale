<?php
/**
 * Template part for displaying fleixble cpt of type news
 */

$show_author = get_post_meta($post->ID, 'post_show_author', true);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(array('flexible-post-type-single','type-news')); ?>>
    <header class="flexible-post-type-header">
        <?php

        the_title('<h1 class="flexible-post-type-title govuk-heading-xl">', '</h1>');

        ?>
        <div class="flexible-post-type-details">
            <div class="flexible-post-type-published-date">
                Published: <?php hale_posted_on(); ?>
            </div>
            <?php if (!empty($show_author)) {?>
                <div class="flexible-post-type-author">
                    <?php hale_posted_by(); ?>
                </div>
            <?php } ?>
        </div>
    </header>

    <?php
    if (has_post_thumbnail()) {

        echo '<div class="flexible-post-type-featured-image">';
        hale_post_thumbnail();
        echo '</div>';

    }
    ?>
    <?php

    $show_summary = get_post_meta($post->ID, 'post_show_summary', true);

    if(!empty($show_summary)) {

        $news_story_summary = get_post_meta($post->ID, 'post_summary', true);
        if (!empty($news_story_summary)) { ?>
            <div class="flexible-post-type-excerpt intro">
                <?php echo wpautop($news_story_summary); ?>
            </div>

            <?php
        }
    }
    ?>
    <?php do_action('hale_before_single_content'); ?>

    <div class="flexible-post-type-content">
        <?php
        if (function_exists('hale_clean_bad_content')) {
            hale_clean_bad_content(true);
        }
        ?>
    </div><!-- .article-content -->
    <div class="govuk-clearfix"></div>

    <?php do_action('hale_after_single_content'); ?>

    <footer class="flexible-post-type-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
