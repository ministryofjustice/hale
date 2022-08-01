<?php
/**
 *  Restricts core Gutenberg Block in editor
 */
function hale_allowed_block_types( $allowed_blocks ) {

    $restrict_blocks = get_theme_mod('restrict_blocks', "yes");

    if($restrict_blocks == "yes") {

        $allowed_blocks = array(
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
            'core/button',
            'core/buttons',
            'core/table',
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

        //Check if news post type is deactivated
        $deactivate_news = get_theme_mod('deactivate_cpt_news', "yes");
        if ($deactivate_news == "no") {
            $allowed_blocks[] = 'mojblocks/latest-news';
            $allowed_blocks[] = 'mojblocks/featured-news';
        }
        return  $allowed_blocks;
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
