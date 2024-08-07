<?php


echo '<label class="govuk-label" for="news-archive-filter-topic">Topic</label>';


// ACF flexible CPT taxonomies brought in to filter
// This is a component from page-listing.php

// For go through all the taxonomies
foreach($listing_filters as $filter) {

 

    $dropdown_args = array(
        "name" => $filter,
        "id" => "news-archive-filter-topic",
        "class" => "govuk-select",
        'taxonomy' => $filter,
        'show_option_all' => "All topics",
        'depth' => 1,
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hierarchical' => 1,
    );
    
    wp_dropdown_categories($dropdown_args);

    $all_terms = get_terms( array(
        'taxonomy' => $filter
    ));

    
    $has_subtopics = false;

    foreach($all_terms as $term){
        if($term->parent > 0){
            $has_subtopics = true;
            break; 
        }
    }

    if($has_subtopics){
        $disabled_subtopics = 'disabled="disabled"';

        $selected_topic = get_query_var('cat');
        $selected_sub_topic = get_query_var('subtopic');
        $sub_topics = [];


        if (is_numeric($selected_topic)) {

            $sub_topics = get_terms(array(
                'taxonomy' => 'category',
                'parent' => $selected_topic
            ));

            if (is_array($sub_topics) && !empty($sub_topics)) {
                $disabled_subtopics = '';
            }
        }

        ?>
        <label class="govuk-label" for="news-archive-filter-subtopic">Sub-topic</label>
        <select name="subtopic" id="news-archive-filter-subtopic"
                class="govuk-select" <?php echo $disabled_subtopics; ?>>
            <option
                value="0" <?php if ($selected_sub_topic == 0) { ?> selected="selected" <?php } ?> >
                All Sub-topics
            </option>

            <?php if (is_array($sub_topics) && !empty($sub_topics)) {
                foreach ($sub_topics as $sub_topic) {
                    ?>
                    <option
                        value="<?php echo $sub_topic->term_id; ?>" <?php if ($selected_sub_topic == $sub_topic->term_id) { ?> selected="selected" <?php } ?> ><?php echo $sub_topic->name; ?></option>
                    <?php

                }
            }
            ?>
        </select>

    <?php }

}







