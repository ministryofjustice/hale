<?php
/**
 * Template part for displaying news
 */

$show_author = get_post_meta($post->ID, 'hale_show_news_story_author', true);

if (empty($show_author)) {
    $show_author = 'no';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="news-story-header">
		<?php

        the_title( '<h1 class="news-story-title govuk-heading-xl">', '</h1>' );

        ?>
        <div class="news-story-details">
            <div class="news-story-published-date">
                Published: <?php hale_posted_on(); ?>
            </div>
            <?php if($show_author == 'yes'){ ?>
                <div class="news-story-author">
                    <?php hale_posted_by(); ?>
                </div>
            <?php } ?>
        </div>
        <?php
        $story_categories = get_the_category();

        $story_tags = get_the_tags();

        if(!empty($story_categories) || !empty($story_tags) ){ ?>
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
	</header>

	<?php
	if ( has_post_thumbnail() ) {

        echo '<div class="news-story-featured-image">';
        hale_post_thumbnail();
        echo '</div>';

	}
	?>
    <?php

        $news_story_summary = get_post_meta($post->ID, 'news_story_summary', true);
        if(!empty($news_story_summary)){ ?>
        <div class="news-story-excerpt intro">
            <?php echo wpautop($news_story_summary); ?>
        </div>

    <?php
    }
    ?>
	<?php do_action( 'hale_before_single_content' ); ?>

	<div class="news-story-content">
		<?php
		if ( function_exists( 'hale_clean_bad_content' ) ) {
            hale_clean_bad_content( true );
		}
		?>
	</div><!-- .article-content -->
	<div class="govuk-clearfix"></div>

	<?php do_action( 'hale_after_single_content' ); ?>

	<footer class="news-story-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
