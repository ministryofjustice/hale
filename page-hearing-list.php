<?php
/**
 * Template Name: Hearing List
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

// Start the post loop
while (have_posts()) :
    the_post();

    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
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

                                        <?php 
                                        get_template_part('template-parts/hearing-list/hearing-list-filters');
                                        ?>
                                    </fieldset>
                
                                
                                <div>
                                    <button class="govuk-button">
                                        <?php _e('Apply filters', 'hale'); ?>
                                    </button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Righthand column with listing page results -->
            <div class="govuk-grid-column-two-thirds">
                <?php
                get_template_part('template-parts/hearing-list/hearing-list-results');
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();
