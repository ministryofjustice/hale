<?php
/**
 * Template part for displaying autocomplete filter
 * Used by page-listing.php as replacement for wp_dropdown_categories
 */

// Get variables from args
$taxonomy_name = $args['taxonomy-name'];
$taxonomy = $args['taxonomy'];
$selected_topic = $args['selected-topic'];
$has_subtopics = $args['has-subtopics'];
$child_class_name = $args['child-class-name'];
$subtopic_query_var = $args['subtopic-query-var'];
$dropdown_exclude = $args['dropdown-exclude'];
$selected_term_name = $args['selected-term-name'];



// Create parent class name for label consistency (matches original dropdown structure)
$parent_class_name = str_replace(' ', '-', $taxonomy->name . '-filter-topic');
?>

<!-- Autocomplete Container -->
<div id="autocomplete-hint-<?php echo esc_attr($taxonomy_name); ?>" class="govuk-hint">
    <input
        type="hidden"
        id="listing-template-hidden-input-<?php echo esc_attr($taxonomy_name); ?>" 
        name="<?php echo esc_attr($taxonomy->query_var); ?>"
        value="<?php echo esc_attr($selected_topic); ?>" 
        aria-describedby="autocomplete-hint-<?php echo esc_attr($taxonomy_name); ?>"
    />
</div>

<div 
    id="listing-template-autocomplete-container-<?php echo esc_attr($taxonomy_name); ?>" 
    data-taxonomy="<?php echo esc_attr($taxonomy_name); ?>"
    data-selected-value="<?php echo esc_attr($selected_topic); ?>"
    data-selected-name="<?php echo esc_attr($selected_term_name); ?>"
    data-query-var="<?php echo esc_attr($taxonomy->query_var); ?>"
    data-has-subtopics="<?php echo $has_subtopics ? '1' : '0'; ?>"
    data-child-class="<?php echo esc_attr($child_class_name); ?>"
    data-subtopic-query-var="<?php echo esc_attr($subtopic_query_var); ?>"
    data-exclude-terms="<?php echo esc_attr(is_array($dropdown_exclude) ? implode(',', $dropdown_exclude) : ''); ?>"
></div>

<?php if ($has_subtopics): ?>
    <?php
    // Get current selected subtopic
    $selected_sub_topic = get_query_var($subtopic_query_var);

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

    // Get subtopic label (same logic as main filter)
    $subfilter_label = 'Sub ' . $taxonomy->labels->singular_name;
    if (isset($taxonomy->labels->listing_page_subfilter) && !empty($taxonomy->labels->listing_page_subfilter)) {
        $subfilter_label = $taxonomy->labels->listing_page_subfilter;
    }
    if ($taxonomy_name == "category") {
        $subfilter_label = "Sub-topic";
    }

    $wrapper_id = $child_class_name . '-wrapper';
    ?>
    
    <div id="<?php echo esc_attr($wrapper_id); ?>" class="<?php echo esc_attr($subtopic_wrapper_classes); ?>">
        <label class="govuk-label" for="<?php echo esc_attr($child_class_name); ?>">
            <?php echo esc_html($subfilter_label); ?>
        </label>
        <select name="<?php echo esc_attr($subtopic_query_var); ?>" 
                id="<?php echo esc_attr($child_class_name); ?>" 
                class="govuk-select filter-subtopic" 
                <?php echo $disabled_subtopics; ?>>
            <option value="0" <?php selected($selected_sub_topic, 0); ?>>Select option</option>
            <?php foreach ($sub_topics as $sub_topic): ?>
                <option value="<?php echo esc_attr($sub_topic->term_id); ?>" 
                        <?php selected($selected_sub_topic, $sub_topic->term_id); ?>>
                    <?php echo esc_html($sub_topic->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>
