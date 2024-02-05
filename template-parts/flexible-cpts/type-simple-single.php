<?php
/**
 * Template part for displaying fleixble cpt of type simple
 */

$show_author = get_post_meta($post->ID, 'post_show_author', true);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="news-story-header">
        <?php

        the_title('<h1 class="news-story-title govuk-heading-xl">', '</h1>');

        ?>
    </header>

    <?php do_action('hale_before_single_content'); ?>

    <div class="news-story-content">
        <?php
        if (function_exists('hale_clean_bad_content')) {
            hale_clean_bad_content(true);
        }
        ?>
    </div><!-- .article-content -->
    <div class="govuk-clearfix"></div>

    <?php do_action('hale_after_single_content'); ?>

    <footer class="news-story-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
