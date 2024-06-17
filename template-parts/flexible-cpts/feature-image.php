<?php
// Feature image section

if ( has_post_thumbnail() ) {

    // Image max 1366x683 pixels, aspect ratio 2:1, crop = true
    // Display currently crops to landscape. We can change this in the future if needed. 
    echo '<div class="flexible-post-type-featured-image">';
        the_post_thumbnail( 'hero', array( 'class' => 'feature-image-attributes' ) );
    echo '</div>';
}