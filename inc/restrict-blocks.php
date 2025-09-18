<?php
/**
 *  Restricts core Gutenberg Block in editor
 *  https://developer.wordpress.org/block-editor/reference-guides/core-blocks/
 */
function hale_allowed_block_types( $allowed_blocks ) {

    $cpt_restrict_blocks = hale_get_post_type_setting('restrict_blocks_multi');

    $cpt_restrict_blocks_mode = hale_get_post_type_setting('restrict_blocks_mode');

    //global restrict blocks
    $restrict_blocks = get_theme_mod('restrict_blocks', 1);
    
    if($cpt_restrict_blocks_mode == 'include' && $cpt_restrict_blocks) {

        return $cpt_restrict_blocks;

    }
    else if($cpt_restrict_blocks_mode == 'exclude' && $cpt_restrict_blocks) {
          
        //Currently restricted to main allowed blocks
        $main_block_list = hale_get_allowed_blocks();
        $new_block_list = array();

        foreach($main_block_list as $block) {
            if(!in_array($block, $cpt_restrict_blocks)) {
                $new_block_list[] = $block;
            }
        }

        return $new_block_list;

    }
    else if($restrict_blocks || $restrict_blocks == "yes") {
        return hale_get_allowed_blocks();
    }
    
    return $allowed_blocks;

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

function hale_get_allowed_blocks(){
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
        'core/column',
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
        'mojblocks/iframe',
        'mojblocks/quote',
        'mojblocks/reveal',
        'mojblocks/route-planner',
        'mojblocks/separator',
        'mojblocks/staggered-box',
        'mojblocks/featured-item',
        'mojblocks/auto-item-list'
    );

    if( current_user_can('administrator') ) {
        $allowed_blocks[] = 'mojblocks/laa-chatbot';
    }

    return $allowed_blocks;
}