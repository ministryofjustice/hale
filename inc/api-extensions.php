<?php
function hale_extend_wp_api($data, $post, $context) {

    // Add featured image to API
    $featured_image_id = $data->data['featured_media']; // get featured image id
    $featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'feature' ); // get url of the feature size

    if( $featured_image_url ) {
        $data->data['featured_image_url'] = $featured_image_url[0];
    } else {
        $data->data['featured_image_url'] = "";
    }

    // Add summary to API
    $summary = get_post_meta( get_the_ID(), 'post_summary', TRUE); // get the value from the meta field
    $data->data['post_meta'] = array( 'summary' => $summary );

    return $data;
}

function hale_add_all_prepare_filters() {
    $args = array(
        'public'   => true,
    );
    $post_types = get_post_types($args);
    foreach ($post_types as $post_type) {
        add_filter( "rest_prepare_$post_type", 'hale_extend_wp_api', 10, 3 );
    }
}
add_action( 'pre_get_posts', 'hale_add_all_prepare_filters' );
