<?php
/**
 * Template part for displaying archive posts
 */

// Retrieve the post summary field
$post_summary = get_field('post_summary');
?>

<div class="archive-list-item">

    <h2 class="archive-list-item__title">
        <a href="<?= esc_url( get_permalink() ); ?>">
            <?= esc_html( get_the_title() ); ?>
        </a>
    </h2>

    <div class="archive-item-detail">
        <div class="archive-published-date">
            <span class="archive-item-detail-label">Published:</span>
            <?= hale_posted_on(); ?>
        </div>
    </div>

    <?php if ( !empty( $post_summary ) ) : ?>
        <div class="archive-excerpt">
            <?= wpautop( wp_kses_post( $post_summary ) ); ?>
        </div>
    <?php endif; ?>

</div>
