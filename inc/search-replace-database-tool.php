<?php

/**
 * Displays a form to run a search and replace operation
 *
 * This function hooks into the `network_site_info_form` action to display a form for running a search and replace operation
 * on the WordPress database. The form allows the user to specify search and replace strings,
 * and whether to perform a dry run. Upon submission, the function executes a WP-CLI command to perform the search and replace
 * operation and displays the command and its output if all required fields are filled.
 * 
 * The form is located on the admin page /wp-admin/network/site-info.php
 *
 * @since 4.3.0
 */
function hale_search_and_replace_database_tool() {
    // We need to close off info-php page form we are hooking into
    submit_button('Save Changes', 'primary', 'primary-save', true, "");
    echo "</form>";

    // Start our new form
    $site_url = get_option('siteurl');
    $blogid = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

    // Pre-populate field with current domain
    $field_search_for = '';
    if ($field_search_for == "") {
        $field_search_for = $site_url;
    }
    ?>

    <form method="post" action="site-info.php?action=run-search-and-replace&id=<?php echo $blogid; ?>">
        <hr><h3>Search and Replace</h3>
        <p>Run a search and replace against keywords in the database, limited to this site.</p>

        <table>
            <tr>
                <td>
                    <?php wp_nonce_field('edit-site'); ?>

                    <input type="hidden" name="id" value="<?php echo esc_attr($blogid); ?>" />
                    <table class="form-table" role="presentation">
                        <tr class="form-field">
                            <th scope="row"><label for="search_value"><?php _e('Search for'); ?></label></th>
                            <td><input name="search_value" type="text" id="search_value"
                                       value="<?php echo esc_attr($field_search_for); ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="replace_with"><?php _e('Replace with'); ?></label></th>
                            <td><input name="replace_value" type="text" id="replace_value"
                                       value="<?php echo esc_attr($replace_with_field); ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="checkbox_field"><?php _e('Dry run'); ?></label></th>
                            <td><input name="dryrun_value" type="checkbox" id="dryrun_value"
                                       <?php echo checked($checkbox_field, 1); ?>>
                                <label for="checkbox_field"></label>
                            </td>
                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </table>

        <?php
        // Submit form
        submit_button('Run search and replace', 'secondary', 'run-search-and-replace', true, "");
        ?>
    </form>

    <?php
        // This styling is needed to surpress the info-php page's button duplicating
        // on the page.
    ?>
    <style>
        .submit .button {
            display: none;
        }

        #run-search-and-replace, #primary-save {
            display: block;
        }
    </style>

    <?php
    // Get form input values
    $search_for = isset($_POST['search_value']) ? $_POST['search_value'] : "";
    $replace_with = isset($_POST['replace_value']) ? $_POST['replace_value'] : "";
    $dry_run = isset($_POST['dryrun_value']) ? $_POST['dryrun_value'] : "";

    // Set dry run flag
    $dry_run = ($dry_run === 'on') ? "--dry-run" : "";

    // Prepare WP-CLI command
    $command = "wp search-replace '$search_for' '$replace_with' ";
    $command .= "--all-tables-with-prefix 'wp_{$blogid}_*' ";
    $command .= "--network ";
    $command .= "--precise ";
    $command .= "--skip-columns=guid ";
    $command .= "--report-changed-only ";
    $command .= "--recurse-objects ";
    $command .= $dry_run;

    // Execute the WP-CLI command and capture its output
    $wp_cli_output = shell_exec($command);

    // Display WP-CLI command and its output
    if ($search_for !== "" && $replace_with !== "" && $dry_run !== "") {
        echo "<pre>$command</pre>";
        echo "<pre>$wp_cli_output</pre>";
    }
}

// Hook into the network site info form
add_action('network_site_info_form', 'hale_search_and_replace_database_tool', 10, 0);
