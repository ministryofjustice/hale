<?php
/**
 * Template part for displaying list item for flexible CPT of type document
 */
?>

<div class="document-list-item">
    <h2 class="document-list-item-title hale-heading-s"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="document-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>

    <div class="document-excerpt">
        <?php
        $document_summary = get_post_meta( get_the_ID(), 'post_summary', true);
        if(!empty($document_summary)){
            echo wpautop($document_summary);
        }
        ?>
    </div>
</div>
