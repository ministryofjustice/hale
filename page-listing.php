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

// Get the search query variable and sanitize it
if ($listing_search_text = get_query_var('listing_search')) {
    $listing_search_text = stripslashes(sanitize_text_field(esc_html($listing_search_text)));
}

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
                            <div class="govuk-form-group govuk-!-margin-bottom-7">
                                <label for="listing-search-field" class="govuk-label govuk-!-margin-top-0">
                                    <?php _e('Search', 'hale'); ?>
                                </label>
                                <input class="govuk-input" id="listing-search-field" name="listing_search"
                                       value="<?= esc_attr($listing_search_text); ?>" type="search"
                                >
                            </div>

                            <div class="listing-filter-field-wrapper">
                                <?php
                                // Listing filters, taxonomies we want to filter our post by
                                $listing_filters = get_field('listing_filters');

                                if (!empty($listing_filters) && is_array($listing_filters)) : ?>
                                    <fieldset class="govuk-fieldset govuk-!-margin-bottom-2">
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
                ]);
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();
