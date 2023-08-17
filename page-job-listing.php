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
$selected_job_role_id = 0;
$selected_job_region_id = 0;
$selected_job_min_salary_id = 0;
$selected_job_max_salary_id = 0;

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
    if ($region->name == "National")
        $national_term_ID = $region->term_id;
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

$selected0 = $selected20000 = $selected30000 = $selected40000 = $selected50000 = $selected60000 = $selected70000 = $selected80000 = $selected90000 = $selected100000 = "";
$salarySelected = "selected$selected_job_min_salary_id";
$$salarySelected = "selected";
$dropdown_html_min_salary =
"
<select class='govuk-select' name='min_salary' id='job-filter-min-salary'>
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
if ($selected_job_max_salary_id != "0" && $selected_job_max_salary_id < $selected_job_min_salary_id ) {
    $selected_job_max_salary_id = "0";
}
$salarySelected = "selected$selected_job_max_salary_id";
$$salarySelected = "selected";
$dropdown_html_max_salary =
"
<select class='govuk-select' name='max_salary' id='job-filter-max-salary'>
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

                                    <div class="govuk-form-group">
                                        <label class="govuk-label" for="job-filter-min-salary">Minimum salary</label>
                                        <?php echo $dropdown_html_min_salary; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                                <?php
                                    if (!empty($dropdown_html_max_salary)) {
                                ?>

                                    <div class="govuk-form-group">
                                        <label class="govuk-label" for="job-filter-max-salary">Maximum salary</label>
                                        <?php echo $dropdown_html_max_salary; ?>
                                    </div>

                                <?php
                                    }
                                ?>
                            <button class="govuk-button">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">

                <?php

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

                $meta_query = [];
                //don't include jobs in the past (with 1 hour's grace)
                $meta_query[] = array(
                    'key' => 'job_closing_date',
                    'value' => (time() - 60*60),
                    'compare' => '>='
                );

                if ($selected_job_min_salary_id) {
                    //either min or max salary is more than minimum specified salary (max salary might not be specified)
                    $meta_query[] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'job_salary_max',
                            'value' => $selected_job_min_salary_id,
                            'compare' => '>='
                        ),
                        array(
                            'key' => 'job_salary_min',
                            'value' => $selected_job_min_salary_id,
                            'compare' => '>='
                        )
                    );
                }
                if ($selected_job_max_salary_id) {
                    //min salary is less than maximum specified salary
                    $meta_query[] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'job_salary_min',
                            'value' => $selected_job_max_salary_id,
                            'compare' => '<='
                        ),
                        // Unpaid and zero-length string = 0
                        array(
                            'key' => 'job_salary_min',
                            'value' => array("","Unpaid"),
                            'compare' => 'IN'
                        ),
                        // Deal with no specified min salary and assume they mean 0
                        array(
                            'key' => 'job_salary_min',
                            'compare' => 'NOT EXISTS'
                        ),
                    );
                }
                //if there is more than one meta query 'AND' them
                if(count($meta_query) > 1) {
                    $meta_query['relation'] = 'AND';
                }

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $job_args = array(
                    'post_type' => 'job',
                    'posts_per_page' => 25,
                    'relevanssi' => true,
                    'paged' => $paged,
                    'meta_key' => 'job_closing_date',
                    'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
                    'tax_query' => $tax_qry_ary,
                    'meta_query' =>  $meta_query
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



