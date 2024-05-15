<?php
/*
* Taxonomy Updater
* Adds a backend page in Settings with two fields,
* allowing to replace one taxonomy with another in the db.
*/

add_action('admin_menu', 'hale_taxonomy_updater_menu');

function hale_taxonomy_updater_menu() {
    add_options_page(
        'Taxonomy Updater',
        'Taxonomy Updater',
        'manage_options',
        'taxonomy-updater',
        'hale_taxonomy_updater_page'
    );
}

function hale_taxonomy_updater_page() {
    // Check if the user has submitted the form
    if (isset($_POST['update_taxonomy'])) {

        if (!isset($_POST['taxonomy_updater_nonce']) || !wp_verify_nonce($_POST['taxonomy_updater_nonce'], 'taxonomy_updater_action')) {
            die('Security check failed');
        }

        global $wpdb;

        $old_slug = sanitize_text_field($_POST['old_slug']);
        $new_slug = sanitize_text_field($_POST['new_slug']);

        $sql = $wpdb->prepare(
            "UPDATE {$wpdb->term_taxonomy} SET taxonomy = %s WHERE taxonomy = %s",
            $new_slug,
            $old_slug
        );

        // Execute the query
        $updated_rows = $wpdb->query($sql);

        flush_rewrite_rules();

        // Check for success
        if ($updated_rows > 0) {
            echo '<div class="updated"><p>Taxonomy updated successfully. Rows affected: ' . $updated_rows . '</p></div>';
        } else {
            echo '<div class="error"><p>No rows updated. It\'s possible the old slug did not exist or was already updated.</p></div>';
        }
    }
    ?>

    <div class="wrap">
        <h1>Taxonomy Updater</h1>
        <form method="post" action="">
            <?php wp_nonce_field('taxonomy_updater_action', 'taxonomy_updater_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="old_slug">Old Taxonomy Slug</label></th>
                    <td><input type="text" id="old_slug" name="old_slug" value="" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="new_slug">New Taxonomy Slug</label></th>
                    <td><input type="text" id="new_slug" name="new_slug" value="" required /></td>
                </tr>
            </table>
            <p>
                <input type="submit" name="update_taxonomy" class="button button-primary" value="Update Taxonomy">
            </p>
        </form>
    </div>
    <?php
}
