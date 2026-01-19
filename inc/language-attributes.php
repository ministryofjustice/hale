<?php
//Extra option in menus to specify language tag
function hale_lang_attribute( $item_id, $item ) {
    $lang_attribute = get_post_meta( $item_id, '_lang_attribute', true );
    ?>
    <div style="clear: both;">
        <details style="margin-bottom:1em;">
            <summary class="button-link">
                Link in different language?
            </summary>
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
            <label for="lang-attr-<?php echo $item_id ;?>">
                <span class="description"><?php _e( "Language ISO code "); ?></span><br />
                <input
                    type="text"
                    name="lang_attribute[<?php echo $item_id ;?>]"
                    id="lang-attr-<?php echo $item_id ;?>"
                    value="<?php echo esc_attr( $lang_attribute ); ?>"
                /><br />
                <span class="description" style="color:#b10e5e"><?php _e( "Only use if link text is a different language from the main page.  <br />Only works for links in the footer."); ?></span><br />
            </label>
            <div class="description">
                Examples:
                <ul style="list-style-type: square; margin-left: 2em;">
                    <li><strong>cy</strong>: Welsh (general)</li>
                    <li><strong>fr</strong>: French (general)</li>
                    <li><strong>fr-CA</strong>: French (Québec)</li>
                    <li><strong>es-ES</strong>: Spanish (Spain)</li>
                    <li><strong>es-419</strong>: Spanish (Latin America)</li>
                </ul>
            </div>
        </details>
    </div>
<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'hale_lang_attribute', 10, 2 );

function hale_save_lang_attribute( $menu_id, $menu_item_db_id ) {
    if ( isset( $_POST['lang_attribute'][$menu_item_db_id]  ) ) {
        $sanitized_data = sanitize_text_field( $_POST['lang_attribute'][$menu_item_db_id] );
        update_post_meta( $menu_item_db_id, '_lang_attribute', $sanitized_data );
    } else {
        delete_post_meta( $menu_item_db_id, '_lang_attribute' );
    }
}
add_action( 'wp_update_nav_menu_item', 'hale_save_lang_attribute', 10, 2 );


/**
 * Function for adding language attributes to the top-level navigation items
 */
add_filter( 'nav_menu_link_attributes', 'hale_add_lang_from_menu_meta', 10, 4 );
function hale_add_lang_from_menu_meta( $atts, $item, $args, $depth ) {

    $lang_attr = get_post_meta( $item->ID, '_lang_attribute', true );

    if ($lang_attr) {
        $atts['lang'] = $lang_attr;
    }

    return $atts;
}

/**
 * Function for returning the language attribute for the page content
 * and setting the global attribute for translation of content
 */
function hale_get_page_lang_attr($id, $set_global = true) {
    if ($set_global) $GLOBALS['page_language'] = "";
    $main_lang = get_blog_option(get_current_blog_id(), 'WPLANG');
    $custom_lang_code = trim(esc_html(get_post_meta($id, 'page_custom_language_code', true)));
    if (!empty($custom_lang_code) && strpos($main_lang, $custom_lang_code) === false && strlen($custom_lang_code) <= 12) {
        /**
         * If: custom language code is set, and it is not the same as the language for the main page
         * We ignore it if it is longer than 12 chars (longest we'll find is something like zh-Hant-HK, but in reality, es-419 is likely the longest - Spanish in Latin America)
         * We should encourage 2 letter codes, but not exclude the longer ones.
         */
        if ($set_global) $GLOBALS['page_language'] = $custom_lang_code;
        return "lang='$custom_lang_code'";
    }
    return "";
}
