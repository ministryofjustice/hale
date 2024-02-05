<?php
/**
 * Template part for displaying list item for flexible CPT of type news
 */
?>

<div class="news-story-list-item">
    <h2 class="news-story-list-item-title hale-heading-s"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="news-story-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>
    <div class="news-story-excerpt">
        <?php
        $news_story_summary = get_post_meta($post->ID, 'post_summary', true);
        if(!empty($news_story_summary)){
            echo wpautop($news_story_summary);
        }
        ?>
    </div>
</div>
