<?php
/**
 * Template part for displaying archive posts
 */

$post_summary = get_field('post_summary');
?>

<div class="archive-list-item">
    <h2 class="archive-list-item__title">
        <a href="<?= get_permalink(); ?>">
            <?= get_the_title(); ?>
        </a>
    </h2>

    <div class="archive-published-date">
        Published: <?= hale_posted_on(); ?>
    </div>

    <?php if (!empty($post_summary)): ?>
        <div class="archive-excerpt">
            <?= wpautop($post_summary); ?>
        </div>
    <?php endif; ?>
</div>
