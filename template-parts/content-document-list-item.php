<?php
/**
 * Template part for displaying document list item
 */
?>

<div class="document-list-item">
    <h2 class="document-list-item__title"><a
            href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <div class="document-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>

    <?php
    if (!empty($args['show_document_summaries']) && $args['show_document_summaries'] == true) {
    ?>
    <div class="document-excerpt">
        <?php
        $document_summary = get_post_meta( get_the_ID(), 'document_summary', true);
        if(!empty($document_summary)){
            echo wpautop($document_summary);
        }
        ?>
    </div>
    <?php } ?>
</div>
