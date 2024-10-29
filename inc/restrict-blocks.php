<?php
/**
 *  Restricts core Gutenberg Block in editor
 *  https://developer.wordpress.org/block-editor/reference-guides/core-blocks/
 */
function hale_allowed_block_types( $allowed_blocks ) {

    $restrict_blocks = get_theme_mod('restrict_blocks', 1);

    if($restrict_blocks || $restrict_blocks == "yes") {
        $allowed_blocks = array(
            // Text blocks
            'core/code',
            'core/footnotes',
            'core/heading',
            'core/list',
            'core/list-item',
            'core/paragraph',
            'core/table',

            // Media blocks
            'core/cover',
            'core/file',
            'core/image',
            'core/media-text',
            'core/video',

            // Design blocks
            'core/buttons',
            'core/button',
            'core/columns',
            'core/group',
            'core/spacer',

            // Widgets
            'core/legacy-widget',
            'core/social-links',
            'core/social-link',

            // Embeds
            'core/embed',
            
            //Custom HTML
            'core/html',

            // Pattern blocks
            'core/block',
            'core/pattern',

            // MoJ blocks
            'mojblocks/accordion',
            'mojblocks/accordion-section',
            'mojblocks/banner',
            'mojblocks/card',
            'mojblocks/cta',
            'mojblocks/hero',
            'mojblocks/highlights-list',
            'mojblocks/quote',
            'mojblocks/reveal',
            'mojblocks/separator',
            'mojblocks/staggered-box',
            'mojblocks/featured-item'
        );

        if (post_type_exists('news')) {
            $allowed_blocks[] = 'mojblocks/latest-news';
        }

        if( current_user_can('administrator') ) {
            $allowed_blocks[] = 'mojblocks/laa-chatbot';
        }

        return  $allowed_blocks;
    }
    else {
        return $allowed_blocks;
    }

}

add_filter( 'allowed_block_types_all', 'hale_allowed_block_types' );

function hale_restrict_embed_blocks() {

    $restrict_blocks = get_theme_mod('restrict_blocks', 1);

    if($restrict_blocks || $restrict_blocks == "yes") {
        wp_enqueue_script(
            'restrict-embed-blocks',
            hale_mix_asset('/js/restrict-embed-blocks.js'),
            array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), null, true
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'hale_restrict_embed_blocks' );
