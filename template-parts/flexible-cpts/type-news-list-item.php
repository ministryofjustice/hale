<?php
/**
 * Template part for displaying list item for flexible CPT of type news
 */
?>

<div class="list-item type-news">
    <h2 class="list-item-title govuk-heading-m"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="list-item-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>
    <div class="list-item-excerpt">
        <?php
        $news_story_summary = get_post_meta($post->ID, 'post_summary', true);
        if(!empty($news_story_summary)){
            echo wpautop($news_story_summary);
        }
        ?>
    </div>
</div>
