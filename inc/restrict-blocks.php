<?php
/**
 *  Restricts core Gutenberg Block in editor
 */
function hale_allowed_block_types( $allowed_blocks ) {

    $restrict_blocks = get_theme_mod('restrict_blocks', 1);

    if($restrict_blocks || $restrict_blocks == "yes") { //old way to be deleted once new settings saved

        $allowed_blocks = array(
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/list-item',
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
            'core/footnotes',
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
        $cpt_news_activated = get_theme_mod('cpt_news_activated', 0);
        $deactivate_news = get_theme_mod('deactivate_cpt_news', "yes"); //old way to be deleted once new settings saved
        if ($cpt_news_activated || $deactivate_news == "no") {
            $allowed_blocks[] = 'mojblocks/latest-news';
            $allowed_blocks[] = 'mojblocks/featured-news';
        }

        $cpt_documents_activated = get_theme_mod('cpt_documents_activated', 0);

        if($cpt_documents_activated) {
            $allowed_blocks[] = 'mojblocks/featured-document';
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
