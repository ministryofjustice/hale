<?php
/**
 *  Restricts core Gutenberg Block in editor
 */
function hale_allowed_block_types( $allowed_blocks ) {

    $restrict_blocks = get_theme_mod('restrict_blocks', "yes");

    if($restrict_blocks == "yes") {

        return array(
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/code',
            'core/file',
            'core/video',
            'core/columns',
            'core/group',
            'core/spacer',
            'core/legacy-widget',
            'core/social-links',
            'core/social-link',
            'core/embed',
            'mojblocks/accordion',
            'mojblocks/accordion-section',
            'mojblocks/banner',
            'mojblocks/card',
            'mojblocks/cta',
            'mojblocks/hero',
            'mojblocks/highlights-list',
            'mojblocks/intro',
            'mojblocks/quote',
            'mojblocks/reveal',
            'mojblocks/staggered-box'
        );
    }
    else {
        return $allowed_blocks;
    }

}

add_filter( 'allowed_block_types_all', 'hale_allowed_block_types' );

function hale_restrict_embed_blocks() {

    $restrict_blocks = get_theme_mod('restrict_blocks', "yes");

    if($restrict_blocks == "yes") {
        wp_enqueue_script(
            'restrict-embed-blocks',
            hale_mix_asset('/js/restrict-embed-blocks.js'),
            array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), null, true
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'hale_restrict_embed_blocks' );
