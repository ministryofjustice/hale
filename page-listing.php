<?php
/**
 * Template Name: Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

// Initialize variables
$listing_search_text = '';
$search_text_HTML = '';
$selectedASC = $selectedDESC = $listing_sort_by = '';

// Get the search query variable and sanitize it
if ($listing_search_text = get_query_var('listing_search')) {
    $listing_search_text = stripslashes(sanitize_text_field(esc_html($listing_search_text)));
}

if ($listing_order_direction = get_query_var('order')) {
    if ($listing_order_direction == "DESC") $selectedDESC = 'checked';
    if ($listing_order_direction == "ASC") $selectedASC = 'checked';
}

$listing_sort_by = "";
if (isset($_GET) && isset($_GET['sort'])) $listing_sort_by = $_GET['sort'];

$selected_display_fields = get_field('list_item_fields');

// Start the post loop
while (have_posts()) :
    the_post();

    // Check if documents are restricted
    $restrict_documents = get_post_meta(get_the_ID(), 'restrict_documents', true);
    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6">
            <?= esc_html(get_the_title()); ?>
        </h1>

        <?php
        // Page body content
        get_template_part('template-parts/content', 'page');
        ?>

        <div class="govuk-grid-row">

            <!-- Lefthand column with filters and search -->
            <div class="govuk-grid-column-one-third">
                <div class="listing-search-section">
                    <div class="listing-search-form">
                        <form action="<?= esc_url(get_permalink()); ?>" method="GET">
                            <div class="govuk-form-group govuk-!-margin-bottom-4">
                                <label for="listing-search-field" class="govuk-visually-hidden">
                                    <?php _e('Search', 'hale'); ?>
                                </label>
                                <input class="govuk-input" id="listing-search-field" name="listing_search"
                                       value="<?= esc_attr($listing_search_text); ?>" type="search"
                                       placeholder="<?php _e('Search', 'hale'); ?>">
                            </div>

                            <div class="listing-filter-field-wrapper">
                                <?php
                                // Listing filters, taxonomies we want to filter our post by
                                $listing_filters = get_field('listing_filters');
                                $listing_filters = get_field('listing_filters');

                                if (!empty($listing_filters) && is_array($listing_filters)) : ?>
                                    <fieldset class="govuk-fieldset govuk-!-margin-bottom-4">
                                        <legend class="govuk-fieldset__legend govuk-fieldset__legend--s">
                                            <h2 class="govuk-fieldset__heading">
                                                <?php _e('Filters', 'hale'); ?>
                                            </h2>
                                        </legend>
                                        <?php 
                                        get_template_part('template-parts/flexible-cpts/listing-filters', false, [
                                            'listing-filters' => $listing_filters
                                        ]);
                                        ?>
                                    </fieldset>
                                <?php endif; ?>

                                <fieldset class="govuk-fieldset govuk-!-margin-bottom-4">
                                    <legend class="govuk-fieldset__legend govuk-fieldset__legend--s">
                                        <h2 class="govuk-fieldset__heading">
                                            <?php _e('Sort results by', 'hale'); ?>
                                        </h2>
                                    </legend>
                                    <select class="govuk-select" id="sort" name="sort">
                                        <option value=""></option>
                                        <option
                                            value="title"
                                            <?php if ($listing_sort_by =="title") echo "selected";?>
                                        >
                                            <?php _e('Title', 'hale'); ?>
                                        </option>
                                        <option
                                            value="publish-date"
                                            <?php if ($listing_sort_by =="publish-date") echo "selected";?>
                                        >
                                            <?php _e('Publish date', 'hale'); ?>
                                        </option>
                                        <option
                                            value="updated-date"
                                            <?php if ($listing_sort_by =="updated-date") echo "selected";?>
                                        >
                                            <?php _e('Updated date', 'hale'); ?>
                                        </option>
                                        <?php
                                        foreach($selected_display_fields as $field) {
                                            if(taxonomy_exists($field)) {
                                                $tax = get_taxonomy($field);
                                                $label = $tax->labels->singular_name;
                                            } else {
                                                $field_object = get_field_object($field);
                                                $field = $field_object["name"];
                                                $label = $field_object["label"];
                                            }
                                            $listing_sort_by == $field ? $selected = "selected" : $selected = "";
                                            echo "<option value='$field' $selected>$label</option>";
                                        }
                                        ?>
                                    </select>
                                </fieldset>

                                <fieldset class="govuk-fieldset govuk-!-margin-bottom-4">
                                    <legend class="govuk-fieldset__legend govuk-fieldset__legend--s">
                                        <h2 class="govuk-fieldset__heading">
                                            <?php _e('Sort direction', 'hale'); ?>
                                        </h2>
                                    </legend>
                                    <div class="govuk-radios govuk-radios--small" data-module="govuk-radios">
                                        <div class="govuk-radios__item">
                                            <input class="govuk-radios__input" id="order-by-asc" name="order" type="radio" value="ASC" <?php echo $selectedASC; ?>>
                                            <label class="govuk-label govuk-radios__label govuk-!-margin-top-0" for="order-by-asc">
                                                <?php _e('Ascending', 'hale'); ?>
                                            </label>
                                        </div>
                                        <div class="govuk-radios__item">
                                            <input class="govuk-radios__input" id="order-by-desc" name="order" type="radio" value="DESC" <?php echo $selectedDESC; ?>>
                                            <label class="govuk-label govuk-radios__label govuk-!-margin-top-0" for="order-by-desc">
                                                <?php _e('Descending', 'hale'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <div>
                                    <button class="govuk-button">
                                        <?php _e('Search', 'hale'); ?>
                                    </button>
                                    <div class="govuk-body govuk-!-margin-left-3 govuk-!-padding-top-1" style="display:inline-block">
                                        <a href="<?= esc_url(get_permalink()); ?>" class="govuk-link">
                                            <?php _e('Clear', 'hale'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Righthand column with listing page results -->
            <div class="govuk-grid-column-two-thirds">
                <?php
                get_template_part('template-parts/flexible-cpts/listing-results', false, [
                    'listing-filters'      => $listing_filters,
                    'listing-search-text'  => $listing_search_text,
                    'listing-order-dir'    => $listing_order_direction,
                    'listing-sort-by'      => $listing_sort_by,
                ]);
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();
