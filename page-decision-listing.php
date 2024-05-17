<?php
/**
 * Template Name: Decision Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

// Get Search text Value
$decision_search_text = '';
$search_text_HTML = '';
$show_decision_summaries = '';

if (get_query_var('decision_search')) {
    $decision_search_text = sanitize_text_field(get_query_var('decision_search'));
    $search_text_HTML = esc_html($decision_search_text);
    $search_text_HTML = str_replace('\\', '', $search_text_HTML); // kill backslashes
}

// Get Search Filter Values
$selected_decision_referral_type_id = 0;
$selected_decision_offence_id = 0;
$selected_decision_process_id = 0;

if (get_query_var('decision_referral_type')) {
    $decision_referral_type_id = get_query_var('decision_referral_type');
    if (is_numeric($decision_referral_type_id)) {
        $decision_referral_type_id = intval($decision_referral_type_id);
        if (term_exists($decision_referral_type_id, 'decision_referral_type')) {
            $selected_decision_referral_type_id = $decision_referral_type_id;
        }
    }
}

if (get_query_var('decision_offence')) {
    $decision_offence_id = get_query_var('decision_offence');
    if (is_numeric($decision_offence_id)) {
        $decision_offence_id = intval($decision_offence_id);
        if (term_exists($decision_offence_id, 'decision_offence')) {
            $selected_decision_offence_id = $decision_offence_id;
        }
    }
}

if (get_query_var('decision_process')) {
    $doc_loc_id = get_query_var('decision_process');
    if (is_numeric($doc_loc_id)) {
        $doc_loc_id = intval($doc_loc_id);
        if (term_exists($doc_loc_id, 'decision_process')) {
            $selected_decision_process_id = $doc_loc_id;
        }
    }
}

while (have_posts()) :
    the_post();
    $sidebar = hale_hierarchy();

    if ($sidebar) {
        $primary_class = 'govuk-grid-column-three-quarters-from-desktop hale-content-with-side-nav';
    } else {
        $primary_class = 'govuk-grid-column-full-from-desktop';
    }

    // Check if decisions are restricted
    $restrict_decisions = get_post_meta(get_the_ID(), 'restrict_decisions', true);

    ?>
    <div id="primary" class="<?php echo $primary_class;?>">
        <h1 class="govuk-heading-xl">
            <?php echo get_the_title(); ?>
        </h1>

        <?php
        // Page body content
        get_template_part('template-parts/content', 'page');
        ?>

        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-third">
                <div class="decision-listing-search-section">
                    <div class="decision-listing-search-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">
                            <label for="decision-search-field" class="govuk-visually-hidden">
                                <?php _e('Search', 'hale'); ?>
                            </label>
                            <input class="govuk-input" id="decision-search-field" name="decision_search"
                                value="<?php echo $search_text_HTML; ?>" type="search"
                                placeholder="<?php _e('Search', 'hale'); ?>">

                            <?php
                            $show_decision_referral_type_filter = false;
                            $decision_referral_type_filter_activated = get_post_meta(get_the_ID(), 'decision_referral_type_filter_activated', true);

                            if ($decision_referral_type_filter_activated) {
                                $show_decision_referral_type_filter = true;
                            }

                            $show_decision_offence_filter = false;
                            $decision_offence_filter_activated = get_post_meta(get_the_ID(), 'decision_offence_filter_activated', true);

                            if ($decision_offence_filter_activated) {
                                $show_decision_offence_filter = true;
                            }

                            $show_decision_process_filter = false;
                            $decision_process_filter_activated = get_post_meta(get_the_ID(), 'decision_process_filter_activated', true);

                            if ($decision_process_filter_activated) {
                                $show_decision_process_filter = true;
                            }

                            if ($decision_referral_type_filter_activated || $decision_process_filter_activated || $decision_process_filter_activated) {
                                ?>
                                <p>Filters</p>
                                <?php
                            }
                            // Taxonomy Decision Referral Type Search Filter
                            if ($decision_referral_type_filter_activated) {
                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'decision_referral_type',
                                        'id' => 'decision-search-filter-type',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'decision_referral_type',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_decision_referral_type_id
                                    )
                                );

                                if (!empty($dropdown_html)) { ?>
                                    <label class="govuk-label" for="decision-search-filter-type">
                                        <?php _e('Referral Type', 'hale'); ?>
                                    </label>
                                    <?php echo $dropdown_html; ?>
                                    <?php
                                }
                            }

                            // Taxonomy Decision Offence Search Filter
                            if ($decision_offence_filter_activated) {
                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'decision_offence',
                                        'id' => 'decision-search-filter-category',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'decision_offence',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_decision_offence_id
                                    )
                                );

                                if (!empty($dropdown_html)) { ?>
                                    <label class="govuk-label" for="decision-search-filter-category">
                                        <?php _e('Offence', 'hale'); ?>
                                    </label>
                                    <?php echo $dropdown_html; ?>
                                    <?php
                                }
                            }

                            // Taxonomy Decision Process Search Filter
                            if ($decision_process_filter_activated) {
                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'decision_process',
                                        'id' => 'decision-search-filter-location',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'decision_process',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_decision_process_id
                                    )
                                );

                                if (!empty($dropdown_html)) { ?>
                                    <label class="govuk-label" for="decision-search-filter-location">
                                        <?php _e('Process', 'hale'); ?>
                                    </label>
                                    <?php echo $dropdown_html; ?>
                                    <?php
                                }
                            }
                            ?>

                            <button class="govuk-button">
                                <?php _e('Search', 'hale'); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">

                <?php

                $restrict_by_type = get_post_meta(get_the_ID(), 'restrict_by_type', true);
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $decision_args = array(
                    'post_type' => 'decision',
                    'posts_per_page' => 10,
                    'relevanssi' => true,
                    'paged' => $paged
                );

                // Set Number of Decisions to be displayed per page
                $decisions_per_page = get_post_meta(get_the_ID(), 'decisions_per_page', true);

                if (!empty($decisions_per_page)) {
                    $decision_args['posts_per_page'] = $decisions_per_page;
                } else {
                    $decision_args['posts_per_page'] = 10;
                }

                // Search by text
                if (!empty($decision_search_text)) {
                    $decision_args['s'] = $decision_search_text;
                    // Meta fields (such as summary) are searched using relevanssi
                } else {
                    // Decisions are sorted be relevance if text search is used.
                    // If not, the default sort is used.
                    $decision_listing_sort = get_post_meta(get_the_ID(), 'decision_listing_default_sort', true);

                    if ($decision_listing_sort == 'title') {
                        $decision_args['orderby'] = 'title';
                        $decision_args['order'] = 'ASC';
                    } else {
                        $decision_args['orderby'] = 'post_date';
                        $decision_args['order'] = 'DESC';
                    }
                }

                // Construct Taxonomy query depending on filters and restrictions
                $tax_qry_ary = [];

                // Add Decision Restriction
                if (!empty($restrict_decisions) && $restrict_decisions != 'no') {
                    if (taxonomy_exists($restrict_decisions)) {
                        // Decisions will only display with the given term ids - from a set taxonomy
                        $restrict_term_ids = get_post_meta(get_the_ID(), 'restrict_decisions_by_' . $restrict_decisions, true);

                        if (!empty($restrict_term_ids)) {
                            $tax_qry_ary[] = array(
                                'taxonomy' => $restrict_decisions,
                                'field' => 'term_id',
                                'terms' => $restrict_term_ids
                            );
                        }
                    }
                }

                // decision Type Filter
                if ($restrict_decisions != "decision_referral_type") {
                    if (!empty($selected_decision_referral_type_id)) {
                        $tax_qry_ary[] = array(
                            'taxonomy' => 'decision_referral_type',
                            'field' => 'term_id',
                            'terms' => $selected_decision_referral_type_id
                        );
                    }
                }

                // decision Category Filter
                if ($restrict_decisions != "decision_offence") {
                    if (!empty($selected_decision_offence_id)) {
                        $tax_qry_ary[] = array(
                            'taxonomy' => 'decision_offence',
                            'field' => 'term_id',
                            'terms' => $selected_decision_offence_id
                        );
                    }
                }

                // decision Location Filter
                if ($restrict_decisions != "decision_process") {
                    if (!empty($selected_decision_process_id)) {
                        $tax_qry_ary[] = array(
                            'taxonomy' => 'decision_process',
                            'field' => 'term_id',
                            'terms' => $selected_decision_process_id
                        );
                    }
                }

                if (!empty($tax_qry_ary)) {
                    $decision_args['tax_query'] = $tax_qry_ary;
                }

                $decision_query = new WP_Query($decision_args);
                $decision_referral_type_filter_activated = get_post_meta(get_the_ID(), 'decision_referral_type_filter_activated', true);

                if ($decision_query->have_posts()) {
                    if ($decision_query->found_posts > 1) {
                        $decision_count_text = $decision_query->found_posts . __(' decisions', 'hale');
                    } elseif ($decision_query->found_posts == 1) {
                        $decision_count_text = '1' . __(' decision', 'hale');
                    }
                    ?>
                    <div class="decision-count">
                        <?php echo $decision_count_text; ?>
                    </div>
                    <div class="decision-list">
                        <?php
                        while ($decision_query->have_posts()) {
                            $decision_query->the_post();
                            get_template_part('template-parts/content', 'decisions', array('show_decision_summaries' => $show_decision_summaries));
                        } ?>
                    </div>
                    <?php
                    hale_archive_pagination('archive', $decision_query);
                } elseif (!empty($decision_search_text)) { ?>
                    <h2 class="govuk-heading-l">
                        <?php
                        echo sprintf(__('Your search for &ldquo;%s&rdquo; matched no decisions', 'hale' ), $search_text_HTML);
                        ?>
                    </h2>
                    <p class="govuk-body">
                        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
                    </p>
                    <?php
                } else { ?>
                    <h2 class="job-list-item--title govuk-heading-l">
                        <?php _e('Your search matched no decisions', 'hale'); ?>
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




