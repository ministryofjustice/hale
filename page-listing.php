<?php
/**
 * Template Name: Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

//Get Search text Value

$listing_search_text = '';
$listing_active_filters = [];
$search_text_HTML = ''; 

if (get_query_var('listing_search')) {

    $listing_search_text = sanitize_text_field(get_query_var('listing_search'));
    $search_text_HTML = esc_html($listing_search_text);
    $search_text_HTML = str_replace('\\', '', $search_text_HTML); // kill backslashes
}

while (have_posts()) :
    the_post();

    //Check if documents are restricted
    $restrict_documents = get_post_meta(get_the_ID(), 'restrict_documents', true);

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
                <div class="listing-search-section">
                    <div class="listing-search-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">
                            <label for="listing-search-field" class="govuk-visually-hidden">
                                <?php _e('Search', 'hale'); ?>
                            </label>
                            <input class="govuk-input" id="listing-search-field" name="listing_search"
                                   value="<?php echo $search_text_HTML; ?>" type="search"
                                   placeholder="<?php _e('Search', 'hale'); ?>">

                            <?php

                            $listing_filters = get_field('listing_filters');

                            if(!empty($listing_filters) && is_array($listing_filters)) { ?>

                                    <p>Filters</p>
                                    <?php
                                    foreach($listing_filters as $filter){

                                    $tax = get_taxonomy($filter);

                                    if(!empty($tax)){

                                        $selected_term_id = 0;

                                        $id = 'listing-search-filter-' . $filter;


                                        if (get_query_var($filter)) {

                                            $filter_term_id = get_query_var($filter);
                                            if (is_numeric($filter_term_id)) {
                                        
                                                $filter_term_id = intval($filter_term_id);
                                        
                                                if (term_exists($filter_term_id, $filter)) {
                                                    $selected_term_id = $filter_term_id;

                                                    $listing_active_filters[] = array (
                                                        'taxonomy' => $filter,
                                                        'value' =>  $filter_term_id
                                                    );
                                                }
                                            }
                                        }

                                        $dropdown_html = wp_dropdown_categories(
                                            array(
                                                'name' => $filter,
                                                'id' => $id,
                                                'class' => 'govuk-select',
                                                'taxonomy' => $filter,
                                                'show_option_all' => 'Select option',
                                                'orderby' => 'name',
                                                'echo' => 0,
                                                'hide_if_empty' => 1,
                                                'selected' => $selected_term_id

                                            )
                                        );

                                        if (!empty($dropdown_html)) { ?>

                                            <label class="govuk-label" for="<?php echo $id; ?>">
                                                <?php echo  $tax->labels->singular_name; ?>
                                            </label>
                                            <?php echo $dropdown_html; ?>

                                            <?php
                                        }
                                    }
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

                $flex_cpt_settings = [];

                // Set Post Type
                $listing_post_type = get_post_meta(get_the_ID(), 'listing_post_type', true);

                if(!empty($listing_post_type)){
                    $flex_cpt_settings = hale_get_flexible_post_type_settings($listing_post_type);
                }

                //if no settings found stop 
                if(!empty($flex_cpt_settings)){
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $listing_args = array(
                        'post_type' => $listing_post_type,
                        'posts_per_page' => 10,
                        'relevanssi' => true,
                        'paged' => $paged
                    );

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

                    $tax_qry_ary = [];

                    //Restrict
                    $restrict_taxonomies = get_field('listing_restrict');

                    if(!empty($restrict_taxonomies) && is_array($restrict_taxonomies)) {

                        foreach($restrict_taxonomies as $tax){
                                $restrict_field = 'restrict_by_' . $tax;

                                $restict_terms = get_field($restrict_field);

                                if(!empty($restict_terms) && is_array($restict_terms)) {
                                    $tax_qry_ary[] = array(
                                        'taxonomy' => $tax,
                                        'field' => 'term_id',
                                        'terms' => $restict_terms
                                    );
                                }
                        }
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

                    if (!empty($tax_qry_ary)) {
                        $listing_args['tax_query'] = $tax_qry_ary;

                    }

                    $listing_query = new WP_Query($listing_args);

                    $flex_cpt_name = $flex_cpt_settings['post_type_name'];
                    $flex_cpt_name_plural = $flex_cpt_settings['post_type_name_plural'];
        
                    $object_type = hale_get_flexible_post_type_object_type($listing_post_type);

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
                                get_template_part('template-parts/flexible-cpts/list-item', false, array('cpt-settings' => $flex_cpt_settings));
                            } ?>
                        </div>

                    <?php
                        hale_archive_pagination('archive', $listing_query);
                    } elseif (!empty($listing_search_text)) { ?>
                        <h2 class="govuk-heading-l">
                            <?php
                            echo sprintf(__('Your search for &ldquo;%s&rdquo; matched no ' . strtolower($flex_cpt_name_plural), 'hale' ), $search_text_HTML);
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
                }
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php
endwhile;

get_footer();



