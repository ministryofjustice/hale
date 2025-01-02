<?php

$flex_cpt_settings = [];
$listing_active_filters = [];
$tax_qry_ary = [];
$display_fields = [];

// Get post type and return if none found
$listing_post_type = 'hearing';

if(empty($listing_post_type)) {
    return;
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$listing_args = [
    'post_type' => $listing_post_type,
    'posts_per_page' => 10,
    'relevanssi' => true,
    'paged' => $paged
];

$listing_args['orderby'] = 'post_date';
$listing_args['order'] = 'DESC';

$listing_filters = hale_get_hearing_list_filters();

if (!empty($listing_filters) && is_array($listing_filters)) {
    foreach ($listing_filters as $filter) {

        if($filter['filter_type'] == "multiselect-taxonomy"){ 
             // Create an array of what taxonomies have been selected in dropdown
             hale_add_filter_term_if_exists($filter['taxonomy_key'], $listing_active_filters, true);
        }
        else if ($filter['filter_type'] == "select-taxonomy") {

            // Create an array of what taxonomies have been selected in dropdown
            hale_add_filter_term_if_exists($filter['taxonomy_key'], $listing_active_filters);
        }
        else {
            continue;
        }

        //Filters
        if(!empty($listing_active_filters)){

            foreach($listing_active_filters as $active_filter){
                $tax_qry_ary[] = array(
                    'taxonomy' => $active_filter['taxonomy'],
                    'field' => 'term_id',
                    'terms' => $active_filter['value']
                );
            }
        }
    }
}

if (!empty($tax_qry_ary)) {
    $listing_args['tax_query'] = $tax_qry_ary;
}

$from_date = get_query_var('from_date');
$to_date = get_query_var('to_date');

if(!empty($from_date)){
    $dateObject = DateTime::createFromFormat('d/m/Y', $from_date);
    $start_date = $dateObject->format('Y-m-d');
}

if(!empty($to_date)){
    $dateObject = DateTime::createFromFormat('d/m/Y', $to_date);
    $end_date = $dateObject->format('Y-m-d');
}

if(!empty($start_date) || !empty($end_date)){
    
    $date_query = array(
        'inclusive' => true, // Include the boundaries
    );
    if(!empty($start_date)){
        $date_query['after'] = $start_date;
    }

    if(!empty($end_date)){
        $date_query['before'] = $end_date;
    }
    
    $listing_args['date_query'] = $date_query;
}

$listing_query = new WP_Query($listing_args);
$post_type_obj = get_post_type_object( $listing_post_type );
$flex_cpt_name = $post_type_obj->labels->singular_name;
$flex_cpt_name_plural = $post_type_obj->labels->name;

$selected_display_fields = array (
    'published-date',
    'hearing-witness',
    'hearing_summary',
);



if (!empty($selected_display_fields) && is_array($selected_display_fields)) {
    foreach($selected_display_fields as $field){
        if($field == 'published-date'){
            $display_fields[] = ["name" => "published-date", "label" => "Hearing date", "type" => "published-date"];
            continue;
        }

        if(taxonomy_exists($field)){
            $tax = get_taxonomy($field);
            $display_fields[] = ["name" =>  $field, "label" =>  $tax->labels->singular_name, "type" => "taxonomy"];
            continue;
        }

        $field_object = get_field_object($field);

        if(!empty($field_object)){
            $field_object['wpautop'] = false;

            if($field_object['name'] == 'post_summary'){
                $field_object['label'] = '';
                $field_object['wpautop'] = true;
            }

            $display_fields[] = [ "name" => $field_object['name'], "label" => $field_object['label'], "type" => "post_meta"];
        }
    }
}

$display_terms_taxonomies = array(
    'hearing-type',
    'witness-category'
);

if ($listing_query->have_posts()) { 
    
    if ($listing_query->found_posts > 1) {
        $item_count_text = $listing_query->found_posts . ' ' . strtolower($flex_cpt_name_plural);
    } elseif ($listing_query->found_posts == 1) {
        $item_count_text = '1 ' . $flex_cpt_name;
    }
    ?>
    <div class="listing-item-count">
        <?php echo $item_count_text; ?>
    </div>
    
    <div class="flexible-post-type-list">
        <?php
        while ($listing_query->have_posts()) {
            $listing_query->the_post();
            get_template_part('template-parts/hearing-list/hearing-list-item', false, array('display-fields' => $display_fields, 'display-terms-taxonomies' => $display_terms_taxonomies,'single_view' => $post_type_obj->publicly_queryable  ));
        } ?>
    </div>

<?php
    hale_archive_pagination('archive', $listing_query);
} elseif (!empty($listing_search_text)) { ?>
    <h2 class="govuk-heading-l">
        <?php
            echo sprintf(__('Your search for &ldquo;%s&rdquo; matched no ' . strtolower($flex_cpt_name_plural), 'hale' ), $listing_search_text);
        ?>
    </h2>
    <p class="govuk-body">
        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
    </p>
    <?php
} else { ?>
    <h2 class="govuk-heading-l">
        <?php _e('Your search matched no ' . strtolower($flex_cpt_name_plural), 'hale'); ?>
    </h2>
    <p class="govuk-body">
        <?php _e('Try searching again with expanded criteria.', 'hale'); ?>
    </p>
    <?php
}
wp_reset_postdata();
