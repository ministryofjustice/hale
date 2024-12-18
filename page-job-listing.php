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
$search_text = '';
$search_text_HTML = '';
$page_size = 50;
$selected_job_role_id = 0;
$selected_job_region_id = 0;
$selected_job_min_salary_id = 0;
$selected_job_max_salary_id = 0;
$salaryError = false;
$salaryErrorClass = $salaryErrorMin = $salaryErrorMax = "";

if (get_query_var('search')) {
    $search_text = get_query_var('search');
    $search_text = sanitize_text_field($search_text);
    $search_text_HTML = esc_html($search_text);
    $search_text_HTML = str_replace('\\', '', $search_text_HTML); // kill backslashes
}

if (get_query_var('role_type')) {
    $job_role_id = get_query_var('role_type');
    if (is_numeric($job_role_id)) {
        $job_role_id = intval($job_role_id);
        if (term_exists($job_role_id, 'role_type')) {
            $selected_job_role_id = $job_role_id;
        }
    }
}
if (get_query_var('job_region')) {
    $job_region_id = get_query_var('job_region');
    if (is_numeric($job_region_id)) {
        $job_region_id = intval($job_region_id);
        if (term_exists($job_region_id, 'job_region')) {
            $selected_job_region_id = $job_region_id;
        }
    }
}
if (get_query_var('min_salary')) {
    $min_salary_id = get_query_var('min_salary');
    if (is_numeric($min_salary_id)) {
        $selected_job_min_salary_id = intval($min_salary_id);
    }
}
if (get_query_var('max_salary')) {
    $max_salary_id = get_query_var('max_salary');
    if (is_numeric($max_salary_id)) {
        $selected_job_max_salary_id = intval($max_salary_id);
    }
}

if (get_query_var('page_size')) {
    $page_size_get = get_query_var('page_size');
    if (is_numeric($page_size_get)) {
        $page_size = intval($page_size_get);
    }
}



$dropdown_html_role = wp_dropdown_categories(
    array(
        'name' => 'role_type',
        'id' => 'job-filter-role',
        'class' => 'govuk-select',
        'taxonomy' => 'role_type',
        'show_option_all' => 'Select option',
        'orderby' => 'name',
        'echo' => 0,
        'hide_if_empty' => 1,
        'selected' => $selected_job_role_id
    )
);

foreach (get_terms(array( 'taxonomy' => 'job_region')) as $region) {
    if (strtoupper($region->name) == "NATIONAL") {
        $national_term_ID = $region->term_id;
        break;
    }
}
$dropdown_html_region = wp_dropdown_categories(
    array(
        'name' => 'job_region',
        'id' => 'job-filter-region',
        'class' => 'govuk-select',
        'taxonomy' => 'job_region',
        'show_option_all' => 'Select option',
        'orderby' => 'name',
        'echo' => 0,
        'hide_if_empty' => 1,
        'selected' => $selected_job_region_id,
        'exclude' => $national_term_ID
    )
);

if ($selected_job_max_salary_id != "0" && $selected_job_max_salary_id < $selected_job_min_salary_id) {
    $salaryError = true;
    $salaryErrorClass = "govuk-select--error";
    $salaryErrorMin = "Minimum salary cannot be higher than maximum salary.";
    $salaryErrorMax = "Maximum salary cannot be lower than minimum salary.";
}

$dropdown_html_min_salary = salaryFilter($selected_job_min_salary_id, 'min_salary', 'job-filter-min-salary', $salaryErrorClass, 'No minimum', $salaryError ? "job-filter-min-salary-error" : "");
$dropdown_html_max_salary = salaryFilter($selected_job_max_salary_id, 'max_salary', 'job-filter-max-salary', $salaryErrorClass, 'No maximum', $salaryError ? "job-filter-max-salary-error" : "");

while (have_posts()) :
    the_post();
    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <?php if ($salaryError) { ?>
            <div class="govuk-error-summary" data-module="govuk-error-summary">
                <div role="alert">
                    <h2 class="govuk-error-summary__title">
                        <?php _e('There is a problem', 'hale'); ?>
                    </h2>
                    <div class="govuk-error-summary__body">
                        <ul class="govuk-list govuk-error-summary__list">
                            <li>
                                <a href="#job-filter-min-salary"><?php _e($salaryErrorMin, "hale"); ?></a>
                            </li>
                            <li>
                                <a href="#job-filter-max-salary"><?php _e($salaryErrorMax, "hale"); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
        <h1 class="govuk-heading-xl govuk-!-static-margin-0">
            <?php echo get_the_title(); ?>
        </h1>

        <?php
        // Page body content
        get_template_part('template-parts/content', 'page');

        $tax_qry_ary = [];
        //Rôle type filter
        if ($selected_job_role_id != 0) {
            $tax_qry_ary[] = array(
                'taxonomy' => 'role_type',
                'field' => 'term_id',
                'terms' => $selected_job_role_id
            );
        }

        //Job Region Filter
        if ($selected_job_region_id != 0) {
            $tax_qry_ary[] = array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'job_region',
                    'field' => 'term_id',
                    'terms' => $selected_job_region_id
                ),
                array(
                    'taxonomy' => 'job_region',
                    'field' => 'term_id',
                    'terms' => $national_term_ID
                ),
            );
        }

        $meta_query = $meta_query_part_salary_max = [];

        //don't include jobs in the past (with 1 hour's grace)
        $meta_query[] = array(
            'key' => 'job_closing_date',
            'value' => (time() - 60*60),
            'compare' => '>='
        );

        if ($selected_job_min_salary_id > 0) {
            //either min or max salary is more than minimum specified salary (max salary might not be specified)
            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'job_salary_max',
                    'value' => $selected_job_min_salary_id,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'job_salary_min',
                    'value' => $selected_job_min_salary_id,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                )
            );
        } else {
            // Min salary is not a string of only numbers
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'value' => '^\d+$',
                'compare' => 'NOT REGEXP',
                'type' => 'STRING'
            );
            // Deal with no specified min salary and assume they mean 0
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'value' => '',
                'compare' => 'NOT EXISTS'
            );
        }
        if ($selected_job_max_salary_id > 0) {
            //min salary is less than maximum specified salary
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'value' => $selected_job_max_salary_id,
                'compare' => '<=',
                'type' => 'NUMERIC'
            );
            $meta_query_part_salary_max['relation'] = 'OR';

            $meta_query[] = array(
                'relation' => 'OR',
                $meta_query_part_salary_max,
            );
        }
        //if there is more than one meta query 'AND' them
        if (count($meta_query) > 1) {
            $meta_query['relation'] = 'AND';
        }

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ($page_size === 0) {
            $count_per_page = -1;
        } else {
            $count_per_page = $page_size;
        }

        $job_args = array(
            'post_type' => 'job',
            'posts_per_page' => $count_per_page,
            'relevanssi' => true,
            'paged' => $paged,
            'meta_key' => 'job_closing_date',
            'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
            'tax_query' => $tax_qry_ary,
            'meta_query' =>  $meta_query
        );
        if (!empty($search_text)) {
            $job_args['s'] = $search_text;
            //Meta fields (such as summary) are searched using relevanssi
        }
        $job_query = new WP_Query($job_args);
        $job_type_filter_activated = get_post_meta(get_the_ID(), 'document_type_filter_activated', true);

        $current_page_number = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $total_job_count = $job_query->found_posts;
        $page_job_count_lower = ($current_page_number) * $count_per_page - $count_per_page + 1;
        $page_job_count_upper = min(($current_page_number) * $count_per_page, $total_job_count);
        if ($total_job_count === 0) {
            $job_count_text = "No jobs found";
        } elseif ($total_job_count == 1) {
            $job_count_text = "<strong>1</strong> job found";
        } elseif ($total_job_count <= $count_per_page || $page_size === 0) {
            $job_count_text = "<strong>$total_job_count</strong> jobs found";
        } else {
            $job_count_text = "Showing <strong>$page_job_count_lower</strong> to <strong>$page_job_count_upper</strong> of <strong>$total_job_count</strong> jobs found.";
        }
        ?>

        <div class="govuk-grid-row">
            <div class="govuk-grid-column-full govuk-!-padding-left-3">
                <?php echo "<p class='govuk-body-l' aria-live='polite'>$job_count_text</p>"; ?>
            </div>
            <div class="govuk-grid-column-one-third">
                <div class="job-listing-filter-section">
                    <div class="job-listing-filter-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET" novalidate>
                            <h2 class="govuk-heading-m">
                                <?php _e('Filters', 'hale'); ?>
                            </h2>
                            <div class="govuk-form-group govuk-!-margin-bottom-4">
                                <label for="search-field" class="govuk-label">
                                    <?php _e('Keyword search', 'hale'); ?>
                                </label>
                                <div id="search-field-hint" class="govuk-hint">
                                    <?php _e('For example, prison officer', 'hale'); ?>
                                </div>
                                <input class="govuk-input" id="search-field" name="search"
                                value="<?php echo $search_text_HTML; ?>" type="search"
                                placeholder="" aria-describedby="search-field-hint">
                            </div>
                                <?php
                                if (!empty($dropdown_html_role)) {
                                    ?>

                                    <div class="govuk-form-group govuk-!-margin-bottom-4">
                                        <label class="govuk-label" for="job-filter-role">
                                        <?php _e('Role', 'hale'); ?>
                                        </label>
                                    <?php echo $dropdown_html_role; ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($dropdown_html_region)) {
                                    ?>

                                    <div class="govuk-form-group govuk-!-margin-bottom-4">
                                        <label class="govuk-label" for="job-filter-region">
                                        <?php _e('Region', 'hale'); ?>
                                        </label>
                                    <?php echo $dropdown_html_region; ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($dropdown_html_min_salary)) {
                                    ?>

                                    <div class="govuk-form-group govuk-!-margin-bottom-4 <?php if ($salaryError) {
                                        echo 'govuk-form-group--error';
                                                                                         }?>">
                                        <label class="govuk-label" for="job-filter-min-salary">
                                        <?php _e('Minimum salary', 'hale'); ?>
                                        </label>
                                    <?php if ($salaryError) {?>
                                        <p id="job-filter-min-salary-error" class="govuk-error-message">
                                            <span class="govuk-visually-hidden">
                                                <?php _e('Error:', 'hale'); ?>
                                            </span>
                                            <?php _e($salaryErrorMin, "hale"); ?>
                                        </p>
                                    <?php } ?>
                                    <?php echo $dropdown_html_min_salary; ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($dropdown_html_max_salary)) {
                                    ?>

                                    <div class="govuk-form-group <?php if ($salaryError) {
                                        echo 'govuk-form-group--error';
                                                                 }?>">
                                        <label class="govuk-label" for="job-filter-max-salary">
                                        <?php _e('Maximum salary', 'hale'); ?>
                                        </label>
                                    <?php if ($salaryError) {?>
                                        <p id="job-filter-max-salary-error" class="govuk-error-message">
                                            <span class="govuk-visually-hidden">
                                                <?php _e('Error:', 'hale'); ?>
                                            </span>
                                            <?php _e($salaryErrorMax, "hale"); ?>
                                        </p>
                                    <?php } ?>
                                    <?php echo $dropdown_html_max_salary; ?>
                                    </div>

                                    <?php
                                }
                                ?>
                            <input class="govuk-button" type="submit" name="type" value="<?php _e('Update results', 'hale'); ?>"/>
                            <div class="govuk-body govuk-!-margin-left-3 govuk-!-padding-top-1" style="display:inline-block">
                                <a href="<?php echo get_permalink(); ?>" class="govuk-link">
                                    <?php _e('Clear', 'hale'); ?>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">

            <?php

            if ($job_query->have_posts() && !$salaryError) {
                ?>
                    <div class="job-list">
                    <?php
                    while ($job_query->have_posts()) {
                        $job_query->the_post();
                        get_template_part('template-parts/content', 'job-list-item');
                    } ?>
                    </div>
                    <?php
                    hale_archive_pagination('archive', $job_query);
            } elseif ($search_text == "" && $selected_job_role_id + $selected_job_region_id + $selected_job_min_salary_id + $selected_job_max_salary_id == 0) {
                // No filters and no jobs found ?>
                    <h2 class="job-list-item--title govuk-heading-l">
                        <?php _e('No jobs found', 'hale'); ?>
                    </h2>
                    <p class="govuk-body">
                        <?php _e('There are currently no jobs to display, try again later.', 'hale'); ?>
                    </p>
                    <?php
            } elseif ($salaryError) {
                // Salary error ?>
                    <h2 class="job-list-item--title govuk-heading-l">
                        <?php _e('Your search matched no current vacancies', 'hale'); ?>
                    </h2>
                    <p class="govuk-body">
                        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
                    </p>
                    <?php
            } elseif ($search_text != "") {
                // Search term entered but no results found ?>
                    <h2 class="job-list-item--title govuk-heading-l">
                        <?php
                        echo sprintf(__('Your search for &ldquo;%s&rdquo; matched no current vacancies', 'hale'), $search_text_HTML);
                        ?>
                    </h2>
                    <p class="govuk-body">
                        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
                    </p>
                    <?php
            } else {
                // No search term, but some filters applied but no jobs found ?>
                    <h2 class="job-list-item--title govuk-heading-l">
                        <?php _e('Your search matched no current vacancies', 'hale'); ?>
                    </h2>
                    <p class="govuk-body">
                        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
                    </p>
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
