<?php

// Listing template results section

$flex_cpt_settings = [];
$listing_active_filters = [];
$tax_qry_ary = [];
$display_fields = [];

// Get post type and return if none found
$listing_post_type = get_post_meta(get_the_ID(), 'listing_post_type', true);

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

// Set Items Per Page
$items_per_page = get_post_meta(get_the_ID(), 'items_per_page', true);

if (!empty($items_per_page)) {
    $listing_args['posts_per_page'] = $items_per_page;
} 

//Search by text
if (!empty($listing_search_text)) {

    $listing_args['s'] = $listing_search_text;
    //Meta fields (such as summary) are searched using relevanssi
} else {
    //Items are sorted be relevance if text search is used. If not the default sort is used.
    $listing_sort = get_post_meta(get_the_ID(), 'listing_sort_order', true);

    if ($listing_sort == 'title') {
        $listing_args['orderby'] = 'title';
        $listing_args['order'] = 'ASC';
    } else {
        $listing_args['orderby'] = 'post_date';
        $listing_args['order'] = 'DESC';
    }
}

//Restrict
$restrict_taxonomies = get_field('listing_restrict');

// if(!empty($restrict_taxonomies) && is_array($restrict_taxonomies)) {

//     foreach($restrict_taxonomies as $tax){
//             $restrict_field = 'restrict_by_' . $tax;

//             $restict_terms = get_field($restrict_field);

//             if(!empty($restict_terms) && is_array($restict_terms)) {
//                 $tax_qry_ary[] = array(
//                     'taxonomy' => $tax,
//                     'field' => 'term_id',
//                     'terms' => $restict_terms
//                 );
//             }
//     }
// }

foreach ($listing_filters as $filter) {

    $id = 'listing-search-filter-' . $filter;

    // Create an array of what taxonomies have been selected in dropdown
    hale_add_filter_term_if_exists($filter, $listing_active_filters);

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

if (!empty($tax_qry_ary)) {
    $listing_args['tax_query'] = $tax_qry_ary;
}

$listing_query = new WP_Query($listing_args);
$post_type_obj = get_post_type_object( $listing_post_type );
$flex_cpt_name = $post_type_obj->labels->singular_name;
$flex_cpt_name_plural = $post_type_obj->labels->name;
$selected_display_fields = get_field('list_item_fields');

foreach($selected_display_fields as $field){

    if($field == 'published-date'){
        $display_fields[] = ["name" => "published-date", "label" => "Published", "type" => "published-date"];
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

$display_terms_taxonomies = get_field('display_terms_taxonomies');

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
            get_template_part('template-parts/flexible-cpts/list-item', false, array('display-fields' => $display_fields, 'display-terms-taxonomies' => $display_terms_taxonomies,'single_view' => $post_type_obj->publicly_queryable  ));
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
