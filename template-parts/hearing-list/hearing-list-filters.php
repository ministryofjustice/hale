<?php
/**
 * ACF data generated side filter component
 * Used by page-hearing-list.php
 */

$listing_filters = $args['filters'];

if (!empty($listing_filters) && is_array($listing_filters)) {
    foreach ($listing_filters as $filter) {

        // Error handling filter arg produces an init, not an array, so must be handled
        if (!is_array($filter)) {
            continue;
        }

        if ($filter['filter_type'] === 'multiselect-taxonomy') {
            get_template_part('template-parts/hearing-list/hearing-list-multiselect');
            continue;
        }

        if ($filter['filter_type'] === 'date-range') {
            get_template_part('template-parts/hearing-list/hearing-date-picker', false, ['filters' => $filter]);
            continue;
        }

        $taxonomy = get_taxonomy($filter['taxonomy_key']);

        if (!$taxonomy) {
            continue;
        }

        $parent_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-topic');

        // Get the selected parent topic
        $selected_topic = get_query_var($taxonomy->query_var);

        $dropdown_args = [
            'name' => $taxonomy->query_var,
            'id' => $parent_class_name,
            'class' => 'govuk-select',
            'taxonomy' => $filter['taxonomy_key'],
            'show_option_all' => 'Select option',
            'depth' => 1,
            'orderby' => 'name',
            'order' => 'ASC',
            'hierarchical' => 1,
            'selected' => $selected_topic,
        ];

        $filter_label = $taxonomy->labels->singular_name;

        if (isset($taxonomy->labels->listing_page_filter) && !empty($taxonomy->labels->listing_page_filter)) {
            $filter_label = $taxonomy->labels->listing_page_filter;
        }

        echo '<div class="govuk-form-group">';
        echo '<label class="govuk-label" for="' . esc_attr($parent_class_name) . '">' . esc_html($filter_label) . '</label>';
        wp_dropdown_categories($dropdown_args);
        echo '</div>';

        $all_terms = get_terms([
            'taxonomy' => $filter,
            'hide_empty' => false,
        ]);

        $has_subtopics = false;
    }
}
