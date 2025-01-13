<?php
/**
 * Template Name: Hearing List
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

$filters = [
    [
        'filter_name' => 'hearing-witness',
        'filter_type' => 'multiselect-taxonomy',
        'taxonomy_key' => 'hearing-witness',
        'value' => [],
        'validated_value' => []
    ],
    [
        'filter_name' => 'published-date',
        'filter_type' => 'date-range',
        'value' => ['from_date' => '', 'to_date' => ''],
        'validated_value' => ['from_date' => '', 'to_date' => '']

    ],
    [
        'filter_name' => 'hearing-type',
        'filter_type' => 'select-taxonomy',
        'taxonomy_key' => 'hearing-type',
        'value' => [],
        'validated_value' => []
    ]
];

//Currently 'published-date' is the only filter validated - option to add others in future
$filters = hale_validate_hearing_filters($filters);

$listing_search_text = stripslashes(sanitize_text_field(esc_html(get_query_var('listing_search'))));

// Start the post loop
while (have_posts()) :
    the_post();

    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        
        <?php get_template_part('template-parts/hearing-list/hearing-list-error-banner', false, array('filters' => $filters)); ?>
        
        <div class="hearing-list-shaded-section">
            <div class="hearing-list-shaded-section-content">
                <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6">
                    <?= esc_html(get_the_title()); ?>
                </h1>

                <?php
                // Page body content
                get_template_part('template-parts/content', 'page');
                ?>
            </div>
        </div>

        <div class="govuk-grid-row">

            <!-- Lefthand column with filters and search -->
            <div class="govuk-grid-column-one-third">
                <div class="listing-search-section">
                    <div class="listing-search-form">
                        <form action="<?= esc_url(get_permalink()); ?>" method="GET">
                            <h2 class="govuk-fieldset__heading">Search and filter</h2>
                            <div class="listing-filter-field-wrapper">

                                    <fieldset class="govuk-fieldset govuk-!-margin-bottom-2">


                                        <div class="govuk-form-group govuk-!-margin-bottom-4">
                                            <label class="govuk-label" for="listing-search-field">
                                                <?php _e('Search', 'hale'); ?>
                                            </label>
                                            <div id="listing-search-field-hint" class="govuk-hint">
                                                <?php _e('For example, witness name or hearing day', 'hale'); ?>
                                            </div>
                                            <input class="govuk-input" id="listing-search-field" name="listing_search"
                                                value="<?= esc_attr($listing_search_text); ?>" type="search"
                                                aria-describedby="listing-search-field-hint"
                                            />
                                        </div>
                                        <?php 
                                        get_template_part('template-parts/hearing-list/hearing-list-filters', false, array('filters' => $filters));
                                        ?>
                                    </fieldset>
                
                                
                                <div>
                                    <button class="govuk-button">
                                        <?php _e('Apply filters', 'hale'); ?>
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
                get_template_part('template-parts/hearing-list/hearing-list-results', false, array('filters' => $filters));
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();
