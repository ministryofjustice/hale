<?php

/**
 * Template part for displaying term tag.
 */

$tax_details = $args['tax-details'];

if (!empty($tax_details)) {
    ?>
    <div class="flexible-post-type-terms-tag-wrapper">
        <ul class="flexible-post-type-terms-tag">
            <?php
            foreach ($tax_details as $tax) {
                foreach ($tax['terms'] as $term) {
                    ?>
                    <li class="flexible-post-type-terms-tag-item">
                       <?php echo esc_html($term->name); ?></li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php
}
