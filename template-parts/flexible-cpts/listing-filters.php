<?php
// ACF flexible CPT taxonomies brought in to filter
// This is a component from page-listing.php



foreach ($listing_filters as $filter) {

    $taxonomy = get_taxonomy($filter);

    if (!$taxonomy) {
        continue;
    }

    $parent_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-topic');
    $child_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-subtopic');

    // Get the selected parent topic
    $selected_topic = get_query_var($taxonomy->query_var);

    // Use a unique query var for each genre_subtopic
    $subtopic_query_var = $taxonomy->query_var . '_subtopic';
    $selected_sub_topic = get_query_var($subtopic_query_var);

    // Restrictions on WP QUERY
    // Restrictions on filter

    // Parent dropdown
    $dropdown_args = [
        "name" => $taxonomy->query_var,
        "id" => $parent_class_name,
        "class" => "govuk-select",
        'taxonomy' => $filter,
        'show_option_all' => "All topics",
        'depth' => 1,
        'orderby' => 'name',
        'order' => 'ASC',
        'hierarchical' => 1,
        'selected' => $selected_topic, // Persist selected value
    ];

    echo '<label class="govuk-label" for="' . esc_attr($parent_class_name) . '">' . esc_html($taxonomy->label) . '</label>';
    wp_dropdown_categories($dropdown_args);

    $all_terms = get_terms(array(
        'taxonomy' => $filter,
        'hide_empty' => false,
    ));

    $has_subtopics = false;

    foreach ($all_terms as $term) {
        if ($term->parent > 0) {
            $has_subtopics = true;
            break;
        }
    }

    if ($has_subtopics) {
        $disabled_subtopics = 'disabled="disabled"';

        $sub_topics = [];

        if (is_numeric($selected_topic) && $selected_topic > 0) {
            $sub_topics = get_terms(array(
                'taxonomy' => $filter,
                'parent' => $selected_topic,
                'hide_empty' => false,
            ));

            if (!empty($sub_topics)) {
                $disabled_subtopics = '';
            }
        }

        echo '<label class="govuk-label" for="' . esc_attr($child_class_name) . '">' . esc_html($taxonomy->label) . ' Sub-topic</label>';
        echo '<select name="' . esc_attr($subtopic_query_var) . '" id="' . esc_attr($child_class_name) . '" class="govuk-select" ' . $disabled_subtopics . '>';
        echo '<option value="0"' . selected($selected_sub_topic, 0, false) . '>All Sub-topics</option>';

        foreach ($sub_topics as $sub_topic) {
            echo '<option value="' . esc_attr($sub_topic->term_id) . '"' . selected($selected_sub_topic, $sub_topic->term_id, false) . '>';
            echo esc_html($sub_topic->name);
            echo '</option>';
        }
        echo '</select>';
    }
}
?>
