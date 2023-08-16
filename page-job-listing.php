<?php
/**
 * Template Name: Job Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

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
                        <strong>Filters</strong>

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
                    'paged' => $paged
                );

                $job_query = new WP_Query($job_args);

                if ($job_query->have_posts()) {

                    if ($job_query->found_posts > 1) {
                        $job_count_text = $job_query->found_posts . ' jobs';
                    } elseif ($job_query->found_posts == 1) {
                        $job_count_text = '1 job';
                    }
                    ?>
                    <div class="job-count">
                        <?php echo $job_count_text; ?>
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



