<?php
/**
 * Template Name: Job Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

error_reporting(E_ALL);

get_header();


//Get Search Filter Values
$page_size = 25;
$selected_job_role_id = 0;
$selected_job_region_id = 0;
$selected_job_min_salary_id = 0;
$selected_job_max_salary_id = 0;
$salaryError = false;
$salaryErrorClass = $salaryErrorMin = $salaryErrorMax = "";

if (get_query_var('role_type')) {
    $job_rôle_id = get_query_var('role_type');
    if (is_numeric($job_rôle_id)) {
        $job_rôle_id = intval($job_rôle_id);
        if (term_exists($job_rôle_id, 'role_type')) {
            $selected_job_role_id = $job_rôle_id;
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
if (isset($_GET) && $_GET['min_salary']) {
    $min_salary_id = $_GET['min_salary'];
    if (is_numeric($min_salary_id)) {
        $selected_job_min_salary_id = intval($min_salary_id);
    }
}
if (isset($_GET) && $_GET['max_salary']) {
    $max_salary_id = $_GET['max_salary'];
    if (is_numeric($max_salary_id)) {
        $selected_job_max_salary_id = intval($max_salary_id);
    }
}

if (isset($_GET) && $_GET['page_size']) {
    $page_size_get = $_GET['page_size'];
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

if ($selected_job_max_salary_id != "0" && $selected_job_max_salary_id < $selected_job_min_salary_id ) {
    $salaryError = true;
    $salaryErrorClass = "govuk-select--error";
    $salaryErrorMin = "Minimum salary cannot be higher than maximum salary.";
    $salaryErrorMax = "Maximum salary cannot be lower than minimum salary.";
}

$selected0 = $selected20000 = $selected30000 = $selected40000 = $selected50000 = $selected60000 = $selected70000 = $selected80000 = $selected90000 = $selected100000 = "";
$salarySelected = "selected$selected_job_min_salary_id";
$$salarySelected = "selected";
$dropdown_html_min_salary =
"
<select class='govuk-select $salaryErrorClass' name='min_salary' id='job-filter-min-salary'>
    <option value='0' $selected0>No minimum</option>
    <option value='20000' $selected20000>£20,000</option>
    <option value='30000' $selected30000>£30,000</option>
    <option value='40000' $selected40000>£40,000</option>
    <option value='50000' $selected50000>£50,000</option>
    <option value='60000' $selected60000>£60,000</option>
    <option value='70000' $selected70000>£70,000</option>
    <option value='80000' $selected80000>£80,000</option>
    <option value='90000' $selected90000>£90,000</option>
    <option value='100000' $selected100000>£100,000</option>
</select>
";

$selected0 = $selected20000 = $selected30000 = $selected40000 = $selected50000 = $selected60000 = $selected70000 = $selected80000 = $selected90000 = $selected100000 = "";
$salarySelected = "selected$selected_job_max_salary_id";
$$salarySelected = "selected";
$dropdown_html_max_salary =
"
<select class='govuk-select $salaryErrorClass' name='max_salary' id='job-filter-max-salary'>
    <option value='0' $selected0>No maximum</option>
    <option value='20000' $selected20000>£20,000</option>
    <option value='30000' $selected30000>£30,000</option>
    <option value='40000' $selected40000>£40,000</option>
    <option value='50000' $selected50000>£50,000</option>
    <option value='60000' $selected60000>£60,000</option>
    <option value='70000' $selected70000>£70,000</option>
    <option value='80000' $selected80000>£80,000</option>
    <option value='90000' $selected90000>£90,000</option>
    <option value='100000' $selected100000>£100,000</option>
</select>
";

$selected12 = $selected25 = $selected50 = $selected100 = "";
$sizeSelected = "selected$page_size";
$$sizeSelected = "selected";
$dropdown_html_page_count =
"
<select class='govuk-select' name='page_size' id='job-filter-page-size'>
    <option value='12' $selected12>12</option>
    <option value='25' $selected25>25</option>
    <option value='50' $selected50>50</option>
    <option value='100' $selected100>100</option>
</select>
";

while (have_posts()) :
    the_post();
?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <?php if ($salaryError) { ?>
            <div class="govuk-error-summary" data-module="govuk-error-summary">
                <div role="alert">
                    <h2 class="govuk-error-summary__title">
                        There is a problem
                    </h2>
                    <div class="govuk-error-summary__body">
                        <ul class="govuk-list govuk-error-summary__list">
                            <li>
                                <a href="#job-filter-min-salary"><?php echo $salaryErrorMin; ?></a>
                            </li>
                            <li>
                                <a href="#job-filter-max-salary"><?php echo $salaryErrorMax; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
        <h1 class="govuk-heading-xl">
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

        if ($selected_job_min_salary_id && is_numeric($selected_job_min_salary_id)) {
            //either min or max salary is more than minimum specified salary (max salary might not be specified)
            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'job_salary_max',
                    'value' => intval($selected_job_min_salary_id),
                    'compare' => '>='
                ),
                array(
                    'key' => 'job_salary_min',
                    'value' => intval($selected_job_min_salary_id),
                    'compare' => '>='
                )
            );
        } else {
            // Unpaid and zero-length string = 0
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'value' => array("","Unpaid"),
                'compare' => 'IN'
            );
            // Deal with no specified min salary and assume they mean 0
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'compare' => 'NOT EXISTS'
            );
        }
        if ($selected_job_max_salary_id) {
            //min salary is less than maximum specified salary
            $meta_query_part_salary_max[] = array(
                'key' => 'job_salary_min',
                'value' => intval($selected_job_max_salary_id),
                'compare' => '<='
            );
            $meta_query[] = array(
                'relation' => 'OR',
                $meta_query_array_salary_max,
            );
        }
        //if there is more than one meta query 'AND' them
        if(count($meta_query) > 1) {
            $meta_query['relation'] = 'AND';
        }

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $job_args = array(
            'post_type' => 'job',
            'posts_per_page' => $page_size,
            'relevanssi' => true,
            'paged' => $paged,
            'meta_key' => 'job_closing_date',
            'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
            'tax_query' => $tax_qry_ary,
            'meta_query' =>  $meta_query
        );

        $job_query = new WP_Query($job_args);
        $job_type_filter_activated = get_post_meta(get_the_ID(), 'document_type_filter_activated', true);

        $current_page_number = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $total_job_count = $job_query->found_posts;
        $page_job_count_lower = ($current_page_number) * $page_size - $page_size + 1;
        $page_job_count_upper = min(($current_page_number) * $page_size,$total_job_count);
        if ($total_job_count === 0) {
            $job_count_text = "No jobs found";
        } elseif ($total_job_count == 1) {
            $job_count_text = "<strong>1</strong> job found";
        } elseif ($total_job_count <= $page_size) {
            $job_count_text = "<strong>$total_job_count</strong> jobs found";
        } else {
            $job_count_text = "Showing <strong>$page_job_count_lower</strong> to <strong>$page_job_count_upper</strong> of <strong>$total_job_count</strong> jobs found.";
        }
        ?>

        <div class="govuk-grid-row">
            <div class="govuk-grid-column-full govuk-!-padding-left-3">
                <?php echo "<p class='govuk-body-l'>$job_count_text</p>"; ?>
            </div>
            <div class="govuk-grid-column-one-third">
                <div class="job-listing-filter-section">
                    <div class="job-listing-filter-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">
                            <h2 class="govuk-heading-s">Filters</h2>
                                <?php
                                    if (!empty($dropdown_html_role)) {
                                ?>

                                    <div class="govuk-form-group">
                                        <label class="govuk-label" for="job-filter-role">Role</label>
                                        <?php echo $dropdown_html_role; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                                <?php
                                    if (!empty($dropdown_html_region)) {
                                ?>

                                    <div class="govuk-form-group">
                                        <label class="govuk-label" for="job-filter-region">Region</label>
                                        <?php echo $dropdown_html_region; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                                <?php
                                    if (!empty($dropdown_html_min_salary)) {
                                ?>

                                    <div class="govuk-form-group <?php if ($salaryError) echo 'govuk-form-group--error';?>">
                                        <label class="govuk-label" for="job-filter-min-salary">Minimum salary</label>
                                        <?php if ($salaryError) {?>
                                        <p id="job-filter-min-salary-error" class="govuk-error-message">
                                            <span class="govuk-visually-hidden">Error: </span><?php echo $salaryErrorMin; ?>
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

                                    <div class="govuk-form-group  <?php if ($salaryError) echo 'govuk-form-group--error';?>">
                                        <label class="govuk-label" for="job-filter-max-salary">Maximum salary</label>
                                        <?php if ($salaryError) {?>
                                        <p id="job-filter-max-salary-error" class="govuk-error-message">
                                            <span class="govuk-visually-hidden">Error: </span><?php echo $salaryErrorMax; ?>
                                        </p>
                                        <?php } ?>
                                        <?php echo $dropdown_html_max_salary; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                                <?php
                                    if (!empty($dropdown_html_page_count)) {
                                ?>

                                    <div class="govuk-form-group">
                                        <label class="govuk-label" for="job-filter-page-size">Number of results per page</label>
                                        <?php echo $dropdown_html_page_count; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                            <button class="govuk-button">Update results</button>
                            <div class="govuk-body govuk-!-margin-left-3 govuk-!-padding-top-1" style="display:inline-block">
                                <a href="<?php echo get_permalink(); ?>" class="govuk-link">Clear</a>
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
                } elseif ($selected_job_role_id + $selected_job_region_id + $selected_job_min_salary_id + $selected_job_max_salary_id == 0) {
                    // No filters and no jobs found ?>
                    <h2 class="job-list-item--title hale-heading-m">
                        No jobs found
                    </h2>
                    <p class="govuk-body">
                        There are currently no jobs to display, try again later.
                    </p>
                    <?php
                } else {
                    // Filters applied but no jobs found ?>
                    <h2 class="job-list-item--title hale-heading-m">
                        Your search matched no current vacancies
                    </h2>
                    <p class="govuk-body">
                        Try searching again with expanded criteria.
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



