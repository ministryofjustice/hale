<?php
/**
 * Template part for displaying list item for flexible CPT of type document
 */
?>

<div class="list-item type-document">
    <h2 class="list-item-title govuk-heading-m"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="list-item-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>

    <div class="list-item-excerpt">
        <?php
        $document_summary = get_post_meta( get_the_ID(), 'post_summary', true);
        if(!empty($document_summary)){
            echo wpautop($document_summary);
        }
        ?>
    </div>
</div>
