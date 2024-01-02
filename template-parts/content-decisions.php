<?php
/**
 * Template part for displaying decisions list item
 */
?>

<div class="document-list-item">
    <h2 class="document-list-item-title hale-heading-s"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="document-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>
    <div class="document-excerpt"></div>
</div>
