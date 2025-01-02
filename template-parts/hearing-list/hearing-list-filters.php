<?php
/**
 * ACF data generated side filter component
 * Used by page-listing.php
 *
*/

$listing_filters = $args['filters'];

if (!empty($listing_filters) && is_array($listing_filters)) {
    foreach ($listing_filters as $filter) {

        if($filter['filter_type'] == "multiselect-taxonomy"){ 

            get_template_part('template-parts/hearing-list/hearing-list-multiselect');
            continue;
        }
        if($filter['filter_type'] == "date-range"){ 
            
            $from_date = $filter['value']['from_date'];
            $to_date = $filter['value']['to_date'];

            $error_date_from = false;
            $error_date_to = false;

            if(!empty($filter['errors'])){

                foreach($filter['errors'] as $error){
                    if($error['link'] == '#from-date'){
                        $error_date_from = true;
                    }
                    if($error['link'] == '#to-date'){
                        $error_date_to = true;
                    }
                }
            }   
            
            ?>

                <div class="moj-datepicker" data-module="moj-date-picker">

                <div class="govuk-form-group <?php if ($error_date_from) {echo 'govuk-form-group--error'; }?>">
                    <label class="govuk-label" for="date">
                    Date from
                    </label>

                    <div id="from-date-hint" class="govuk-hint">
                        For example, 13/2/2024.
                    </div>
                    <?php if ($error_date_from) {?>
                        <p id="hearing-filter-date-from-error" class="govuk-error-message">
                            <span class="govuk-visually-hidden">
                                <?php _e('Error:', 'hale'); ?>
                            </span>
                            <?php _e('The Date from field must be a valid date', "hale"); ?>
                        </p>
                     <?php } ?>

                    <input class="govuk-input moj-js-datepicker-input " id="from-date" name="from_date" type="text" aria-describedby="from-date-hint" autocomplete="off" value="<?php echo $from_date; ?>">

                </div>
                

                </div>
                <div class="moj-datepicker" data-module="moj-date-picker" >

                <div class="govuk-form-group <?php if ($error_date_to) {echo 'govuk-form-group--error'; }?>">
                <label class="govuk-label" for="date">
                    Date to
                </label>
                <div id="to-date-hint" class="govuk-hint">
                        For example, 13/2/2024.
                </div>
                <?php if ($error_date_to) {?>
                        <p id="hearing-filter-date-to-error" class="govuk-error-message">
                            <span class="govuk-visually-hidden">
                                <?php _e('Error:', 'hale'); ?>
                            </span>
                            <?php _e('The Date to field must be a valid date', "hale"); ?>
                        </p>
                 <?php } ?>

                <input class="govuk-input moj-js-datepicker-input " id="to-date" name="to_date" type="text" aria-describedby="to-date-hint to-date-error" autocomplete="true" value="<?php echo $to_date; ?>">

                </div>

        <?php
            continue;
        }

        $taxonomy = get_taxonomy($filter['taxonomy_key']);

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

        $dropdown_args = [
            "name" => $taxonomy->query_var,
            "id" => $parent_class_name,
            "class" => "govuk-select",
            'taxonomy' => $filter['taxonomy_key'],
            'show_option_all' => "Select option",
            'depth' => 1,
            'orderby' => 'name',
            'order' => 'ASC',
            'hierarchical' => 1,
            'selected' => $selected_topic
        ];

        $filter_label = $taxonomy->labels->singular_name;

        if(isset($taxonomy->labels->listing_page_filter) && !empty($taxonomy->labels->listing_page_filter)){
            $filter_label = $taxonomy->labels->listing_page_filter;
        }

        echo '<div class="govuk-form-group">';

        echo '<label class="govuk-label" for="' . esc_attr($parent_class_name) . '">' . esc_html($filter_label) . '</label>';
        wp_dropdown_categories($dropdown_args);

        echo '</div>';
        
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

            $subfilter_label = 'Sub ' . $taxonomy->labels->singular_name;

            if(isset($taxonomy->labels->listing_page_subfilter) && !empty($taxonomy->labels->listing_page_subfilter)){
                $subfilter_label = $taxonomy->labels->listing_page_subfilter;
            }

            if($filter == "category"){
                $subfilter_label = "Sub-topic";
            }

            
            echo '<label class="govuk-label" for="' . esc_attr($child_class_name) . '">' . esc_html($subfilter_label) . '</label>';
            echo '<select name="' . esc_attr($subtopic_query_var) . '" id="' . esc_attr($child_class_name) . '" class="govuk-select filter-subtopic" ' . $disabled_subtopics . '>';
            echo '<option value="0"' . selected($selected_sub_topic, 0, false) . '>Select option</option>';

            foreach ($sub_topics as $sub_topic) {
                echo '<option value="' . esc_attr($sub_topic->term_id) . '"' . selected($selected_sub_topic, $sub_topic->term_id, false) . '>';
                echo esc_html($sub_topic->name);
                echo '</option>';
            }
            echo '</select>';
        }
    }
}
