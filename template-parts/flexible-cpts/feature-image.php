<?php
// Feature image section

if ( has_post_thumbnail() ) {

    // Image crop at 768 wide
    // https://github.com/ministryofjustice/hale/wiki/Image-sizes-in-Hale
    echo '<div class="flexible-post-type-featured-image">';
        the_post_thumbnail( 'medium_large', array( 'class' => 'feature-image-attributes' ) );
    echo '</div>';
}