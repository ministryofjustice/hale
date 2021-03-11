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

add_filter( 'allowed_block_types', 'hale_allowed_block_types' );
