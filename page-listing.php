<?php
/**
 * Template Name: Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

$listing_search_text = '';
$search_text_HTML = ''; 

if ($listing_search_text = get_query_var('listing_search')) {
    $listing_search_text = stripslashes(sanitize_text_field(esc_html($listing_search_text)));
}


while (have_posts()) :
    the_post();

    //Check if documents are restricted
    $restrict_documents = get_post_meta(get_the_ID(), 'restrict_documents', true);

    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6">
            <?php echo get_the_title(); ?>
        </h1>

        <?php
        // Page body content
        get_template_part('template-parts/content', 'page');
        ?>

        <div class="govuk-grid-row">

            <?php
            // Lefthand column with filters and search
            ?>
            <div class="govuk-grid-column-one-third">
                <div class="listing-search-section">
                    <div class="listing-search-form">
                    <div class="news-archive-filter-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">
                            <div class="govuk-form-group govuk-!-margin-bottom-4">
                                <label for="listing-search-field" class="govuk-visually-hidden">
                                    <?php _e('Search', 'hale'); ?>
                                </label>
                                <input class="govuk-input" id="listing-search-field" name="listing_search"
                                    value="<?php echo $search_text_HTML; ?>" type="search"
                                    placeholder="<?php _e('Search', 'hale'); ?>">
                            </div>

                            <?php

                            // Listing filters, taxonomies we want to filter our post by
                            $listing_filters = get_field('listing_filters');

                            if(!empty($listing_filters) && is_array($listing_filters)) { ?>
                                <fieldset class="govuk-fieldset govuk-!-margin-bottom-2">
                                    <legend class="govuk-fieldset__legend govuk-fieldset__legend--s">
                                        <h2 class="govuk-fieldset__heading">
                                            <?php _e("Filters","hale"); ?>
                                        </h2>
                                    </legend>
                                    <?php 
                                    get_template_part('template-parts/flexible-cpts/listing-filters', false, 
                                        ['listing-filters' => $listing_filters]
                                    );
                                    ?>
                                </fieldset>

                            <?php } ?>

                            <div>
                                <button class="govuk-button">
                                    <?php _e('Search', 'hale'); ?>
                                </button>
                                <div class="govuk-body govuk-!-margin-left-3 govuk-!-padding-top-1" style="display:inline-block">
                                    <a href="<?php echo get_permalink(); ?>" class="govuk-link">
                                        <?php _e('Clear', 'hale'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                                </div>
                    </div>
                </div>
            </div>

            <?php
            // Righthand column with listing page results
            ?>
            <div class="govuk-grid-column-two-thirds">
                <?php get_template_part('template-parts/flexible-cpts/listing-results', false, 
                        [
                            'listing-filters' => $listing_filters,
                            'listing-search-text' => $listing_search_text,
                        ]
                    );
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();
