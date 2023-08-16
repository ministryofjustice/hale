<?php
/**
 * Template Name: Job Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

//Get Search Filter Values
$selected_job_region_id = 0;

while (have_posts()) :
    the_post();
?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl">
            <?php echo get_the_title(); ?>
        </h1>

        <?php
        // Page body content
        get_template_part('template-parts/content', 'page');
        ?>

        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-third">
                <div class="job-listing-filter-section">
                    <div class="job-listing-filter-form">
                        <h2 class="govuk-heading-s">Filters</h2>
                        <?php
                            $dropdown_html = wp_dropdown_categories(
                                array(
                                    'name' => 'job_region',
                                    'id' => 'job-search-filter-region',
                                    'class' => 'govuk-select',
                                    'taxonomy' => 'job_region',
                                    'show_option_all' => 'Select option',
                                    'orderby' => 'name',
                                    'echo' => 0,
                                    'hide_if_empty' => 1,
                                    'selected' => $selected_job_region_id
                                )
                            );
                        if (!empty($dropdown_html)) { ?>

                                <label class="govuk-label" for="job-search-filter-region">Region</label>
                                <?php echo $dropdown_html; ?>

                                <?php
                            }
                        ?>
                    </div>

                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">

                <?php

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $job_args = array(
                    'post_type' => 'job',
                    'posts_per_page' => 25,
                    'relevanssi' => true,
                    'paged' => $paged,
                    'meta_key' => 'job_closing_date',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC'
                );

                $job_query = new WP_Query($job_args);
                $job_type_filter_activated = get_post_meta(get_the_ID(), 'document_type_filter_activated', true);
                if ($job_query->have_posts()) {

                    if ($job_query->found_posts > 1) {
                        $job_count_text = $job_query->found_posts . ' jobs';
                    } elseif ($job_query->found_posts == 1) {
                        $job_count_text = '1 job';
                    }
                    ?>
                    <div class="job-count">
                        <p class="govuk-body"><?php echo $job_count_text; ?></p>
                    </div>
                    <div class="job-list">
                        <?php
                        while ($job_query->have_posts()) {
                            $job_query->the_post();
                        
                            get_template_part('template-parts/content', 'job-list-item');
                        } ?>
                    </div>
                    <?php
                    hale_archive_pagination('archive', $job_query);
                } else { ?>
                    <p><?php _e('No Jobs found', 'hale'); ?></p>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();



