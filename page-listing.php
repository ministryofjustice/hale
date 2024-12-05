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
                            <div class="govuk-form-group govuk-!-margin-bottom-4">
                                <label for="listing-search-field" class="govuk-visually-hidden">
                                    <?php _e('Search', 'hale'); ?>
                                </label>

                                <!-- Autocomplete container -->
                                <div id="listing-search-autocomplete-container" class="autocomplete-wrapper">
                                    <div class="autocomplete__wrapper">
                                        <input
                                        aria-describedby="autocomplete-customDropdownArrow__assistiveHint" 
                                        aria-expanded="false" 
                                        aria-controls="autocomplete-customDropdownArrow__listbox" 
                                        aria-autocomplete="list" 
                                        autocomplete="off" 
                                        class="autocomplete__input autocomplete__input--show-all-values" 
                                        id="listing-search-input" 
                                        name="input-autocomplete" 
                                        placeholder="" 
                                        type="hidden" 
                                        role="combobox" 
                                        >
                                        <div class="autocomplete__dropdown-arrow-down-wrapper">
                                            <svg 
                                                class="autocomplete__dropdown-arrow-down" 
                                                viewBox="0 0 512 512"
                                            >
                                                <path 
                                                    d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9  
                                                    c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3  
                                                    z"
                                                ></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- End autocomplete container -->


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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countries = [
                'France',
                'Germany',
                'United Kingdom'
            ];
            
            accessibleAutocomplete({
                element: document.querySelector('#listing-search-autocomplete-container'),
                id: 'listing-search-field', // Matches the hidden input
                source: countries,
                onConfirm: (value) => {
                    document.getElementById('listing-search-field').value = value;
                }
            });
        });
    </script>


<?php
endwhile;

get_footer();
