<?php

/**
 * ACF data generated side filter component
 * Used by page-listing.php
 */

$taxonomy_name = $args['taxonomy-name'];
$taxonomy = get_taxonomy($taxonomy_name);

$parent_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-topic');
$child_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-subtopic');

// Get the selected parent topic
$selected_topic = get_query_var($taxonomy->query_var);

// Use a unique query var for each subtopic
$subtopic_query_var = $taxonomy->query_var . '_subtopic';
$selected_sub_topic = get_query_var($subtopic_query_var);

// Construct the field name for the restriction based on the filter
$restrict_field = 'restrict_by_' . $taxonomy_name;

// ACF 'restrict_by_*' custom field is generated via code
// https://github.com/ministryofjustice/hale/blob/6d5ca3c9c6ddbcf27b23857223a54bcdf5778def/inc/flexible-cpts.php
$restrict_terms = get_field($restrict_field);

if (empty($restrict_terms)) {
    $dropdown_exclude = "";
}

if (is_array($restrict_terms) && !empty($restrict_terms)) {
    // Get an array of terms excluding the restricted ones
    $exclude_terms = get_terms([
        'taxonomy' => $taxonomy_name,
        'exclude' => $restrict_terms
    ]);

    if (!empty($exclude_terms)) {
        $dropdown_exclude = array_map(function ($term) {
            return $term->term_id;
        }, $exclude_terms);
    }
}

$all_terms = get_terms(array(
    'taxonomy' => $taxonomy_name,
    'hide_empty' => false,
));

$has_subtopics = false;
foreach ($all_terms as $term) {
    if ($term->parent > 0) {
        $has_subtopics = true;
        break;
    }
}

// Get selected term name for autocomplete
$selected_term_name = '';
if ($selected_topic && is_numeric($selected_topic)) {
    $term = get_term($selected_topic);
    if ($term && !is_wp_error($term)) {
        $selected_term_name = $term->name;
    }
}

// Get filter label
$filter_label = $taxonomy->labels->singular_name;

if (isset($taxonomy->labels->listing_page_filter) && !empty($taxonomy->labels->listing_page_filter)) {
    $filter_label = $taxonomy->labels->listing_page_filter;
}
if ($taxonomy_name == "category") {
    $filter_label = "Topic";
}

echo '<label class="govuk-label" for="' . esc_attr($parent_class_name) . '">' . esc_html($filter_label) . '</label>';

//Determines if the ACF toggle on a taxonomy is turned on
$is_autocomplete_enabled = $taxonomy->autocomplete ?? false;

if ($is_autocomplete_enabled) {
    // Use autocomplete
    get_template_part('template-parts/flexible-cpts/autocomplete-filter', false, [
        'taxonomy-name' => $taxonomy_name,
        'taxonomy' => $taxonomy,
        'selected-topic' => $selected_topic,
        'has-subtopics' => $has_subtopics,
        'child-class-name' => $child_class_name,
        'subtopic-query-var' => $subtopic_query_var,
        'dropdown-exclude' => $dropdown_exclude,
        'selected-term-name' => $selected_term_name,
        'selected-sub-topic' => $selected_sub_topic
    ]);
} else {
    // Use dropdown
    $dropdown_args = [
        "name" => $taxonomy->query_var,
        "id" => $parent_class_name,
        "class" => "govuk-select",
        'taxonomy' => $taxonomy_name,
        'show_option_all' => "Select option",
        'depth' => 1,
        'orderby' => 'name',
        'order' => 'ASC',
        'hierarchical' => 1,
        'selected' => $selected_topic,
        'exclude' => $dropdown_exclude
    ];

    wp_dropdown_categories($dropdown_args);
}

// SUBTOPIC HANDLING (only show if autocomplete is NOT enabled, or handle in template)
if ($has_subtopics && !$is_autocomplete_enabled) {
    $disabled_subtopics = 'disabled="disabled"';
    $subtopic_wrapper_classes = 'govuk-visually-hidden';

    $sub_topics = [];

    if (is_numeric($selected_topic) && $selected_topic > 0) {
        $sub_topics = get_terms(array(
            'taxonomy' => $taxonomy_name,
            'parent' => $selected_topic,
            'hide_empty' => false,
        ));

        if (!empty($sub_topics)) {
            $disabled_subtopics = '';
            $subtopic_wrapper_classes = '';
        }
    }

    $subfilter_label = 'Sub ' . $taxonomy->labels->singular_name;
    if (isset($taxonomy->labels->listing_page_subfilter) && !empty($taxonomy->labels->listing_page_subfilter)) {
        $subfilter_label = $taxonomy->labels->listing_page_subfilter;
    }
    if ($taxonomy_name == "category") {
        $subfilter_label = "Sub-topic";
    }

    $wrapper_id = $child_class_name . '-wrapper';

    echo '<div id="' . $wrapper_id . '" class="' . $subtopic_wrapper_classes . '">';
    echo '<label class="govuk-label" for="' . esc_attr($child_class_name) . '">' . esc_html($subfilter_label) . '</label>';
    echo '<select name="' . esc_attr($subtopic_query_var) . '" id="' . esc_attr($child_class_name) . '" class="govuk-select filter-subtopic" ' . $disabled_subtopics . '>';
    echo '<option value="0"' . selected($selected_sub_topic, 0, false) . '>Select option</option>';

    foreach ($sub_topics as $sub_topic) {
        echo '<option value="' . esc_attr($sub_topic->term_id) . '"' . selected($selected_sub_topic, $sub_topic->term_id, false) . '>';
        echo esc_html($sub_topic->name);
        echo '</option>';
    }
    echo '</select>';
    echo '</div>';
}
