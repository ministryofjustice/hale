<?php
/**
 * Template Name: Document Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

//Get Search text Vale

$doc_search_text = '';

if (get_query_var('doc_search')) {

    $doc_search_text = sanitize_text_field(get_query_var('doc_search'));
}

//Get Search Filter Values
$selected_doc_type_id = 0;
$selected_doc_category_id = 0;
$selected_doc_location_id = 0;

if (get_query_var('doc_type')) {

    $doc_type_id = get_query_var('doc_type');
    if (is_numeric($doc_type_id)) {

        $doc_type_id = intval($doc_type_id);

        if (term_exists($doc_type_id, 'document_type')) {
            $selected_doc_type_id = $doc_type_id;
        }
    }
}

if (get_query_var('doc_category')) {

    $doc_cat_id = get_query_var('doc_category');
    if (is_numeric($doc_cat_id)) {

        $doc_cat_id = intval($doc_cat_id);

        if (term_exists($doc_cat_id, 'document_category')) {
            $selected_doc_category_id = $doc_cat_id;
        }
    }
}

if (get_query_var('document_location')) {

    $doc_loc_id = get_query_var('document_location');
    if (is_numeric($doc_loc_id)) {

        $doc_loc_id = intval($doc_loc_id);

        if (term_exists($doc_loc_id, 'document_location')) {
            $selected_doc_location_id = $doc_loc_id;
        }
    }
}

while (have_posts()) :
    the_post();
    ?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl">
            <?php echo get_the_title(); ?>
        </h1>
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-third">
                <div class="document-listing-search-section">
                    <div class="document-listing-search-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">

                            <input class="govuk-input" id="doc-search-field" name="doc_search"
                                   value="<?php echo $doc_search_text; ?>" type="search"
                                   placeholder="Search">

                            <?php

                            $show_doc_type_filter = false;

                            $tax_document_type_activated = get_theme_mod('tax_document_type_activated', 0);
                            $document_type_filter_activated = get_post_meta( get_the_ID(), 'document_type_filter_activated', true);

                            if ($tax_document_type_activated && $document_type_filter_activated) {
                                $show_doc_type_filter = true;
                            }

                            $show_doc_category_filter = false;

                            $tax_document_category_activated = get_theme_mod('tax_document_category_activated', 0);
                            $document_category_filter_activated = get_post_meta(get_the_ID(), 'document_category_filter_activated', true);

                            if ($tax_document_category_activated && $document_category_filter_activated) {
                                $show_doc_category_filter = true;
                            }

                            $show_doc_location_filter = false;

                            $tax_document_location_activated = get_theme_mod('tax_document_location_activated', 0);
                            $document_location_filter_activated = get_post_meta( get_the_ID(), 'document_location_filter_activated', true);

                            if ($tax_document_location_activated && $document_location_filter_activated) {
                                $show_doc_location_filter = true;
                            }


                            if($show_doc_type_filter || $show_doc_category_filter || $show_doc_location_filter) {
                                ?>
                                <p>Filters</p>
                                <?php
                            }

                            //Taxonomy Document Type Search Filter

                            if ($show_doc_type_filter) {

                                $doc_types = get_terms('document_type', array('hide_empty' => true));

                                if (is_array($doc_types) && !empty($doc_types)) {
                                    ?>
                                    <label class="govuk-label" for="document-search-filter-type">Type</label>
                                    <select name="doc_type" id="document-search-filter-type" class="govuk-select">
                                        <option value="0"
                                                <?php if ($selected_doc_type_id == 0) { ?>selected="selected"<?php } ?>>
                                            Select option
                                        </option>
                                        <?php foreach ($doc_types as $doc_type) { ?>
                                            <option
                                                value="<?php echo $doc_type->term_id; ?>"
                                                <?php if ($selected_doc_type_id == $doc_type->term_id) { ?>selected="selected"<?php } ?>><?php echo $doc_type->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php

                                }
                            }

                            //Taxonomy Document Category Search Filter

                            if ($show_doc_category_filter) {
                                $doc_categories = get_terms('document_category', array('hide_empty' => true));

                                if (!empty($doc_categories)) {
                                    ?>
                                    <label class="govuk-label" for="document-search-filter-category">Category</label>
                                    <select name="doc_category" id="document-search-filter-category"
                                            class="govuk-select">
                                        <option value="0"
                                                <?php if ($selected_doc_category_id == 0) { ?>selected="selected"<?php } ?>>
                                            Select option
                                        </option>
                                        <?php foreach ($doc_categories as $doc_category) { ?>
                                            <option
                                                value="<?php echo $doc_category->term_id; ?>"
                                                <?php if ($selected_doc_category_id == $doc_category->term_id) { ?>selected="selected"<?php } ?>><?php echo $doc_category->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php

                                }
                            }


                            //Taxonomy Document Location Search Filter

                            if ($show_doc_location_filter) {

                                $doc_locations = get_terms('document_location', array('hide_empty' => true));

                                if (!empty($doc_locations)) {
                                    ?>
                                    <label class="govuk-label" for="document-search-option-location">Location</label>
                                    <select name="doc_location" id="document-search-filter-location"
                                            class="govuk-select">
                                        <option value="0"
                                                <?php if ($selected_doc_location_id == 0) { ?>selected="selected"<?php } ?>>
                                            Select option
                                        </option>
                                        <?php foreach ($doc_locations as $doc_location) { ?>
                                            <option
                                                value="<?php echo $doc_location->term_id; ?>"
                                                <?php if ($selected_doc_location_id == $doc_location->term_id) { ?>selected="selected"<?php } ?>><?php echo $doc_location->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php

                                }
                            }
                            ?>

                            <button class="govuk-button">Search</button>
                        </form>

                    </div>

                </div>
            </div>
            <div class="govuk-grid-column-two-thirds">

                <?php

                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                $doc_args = array(
                    'post_type' => 'document',
                    'posts_per_page' => 10,
                    'relevanssi' => true,
                    'paged' => $paged,
                    'orderby' => 'post_date',
                    'order' => 'DESC'
                );

                $tax_qry_ary = [];

                if (!empty($doc_search_text)) {

                   $doc_args['s'] = $doc_search_text;
                   //Meta fields (such as summary) are searched using relevanssi
                }

                if (!empty($selected_doc_type_id)) {

                    $tax_qry_ary[] = array(
                        'taxonomy' => 'document_type',
                        'field' => 'term_id',
                        'terms' => $selected_doc_type_id
                    );

                }

                if (!empty($selected_doc_category_id)) {

                    $tax_qry_ary[] = array(
                        'taxonomy' => 'document_category',
                        'field' => 'term_id',
                        'terms' => $selected_doc_category_id
                    );

                }

                if (!empty($selected_doc_location_id)) {

                    $tax_qry_ary[] = array(
                        'taxonomy' => 'document_location',
                        'field' => 'term_id',
                        'terms' => $selected_doc_location_id
                    );

                }

                if (!empty($tax_qry_ary)) {

                    $doc_args['tax_query'] = $tax_qry_ary;

                }

                $doc_query = new WP_Query($doc_args);

                if ($doc_query->have_posts()) {

                    if ($doc_query->found_posts > 1) {
                        $doc_count_text = $doc_query->found_posts . ' documents';
                    } elseif ($doc_query->found_posts == 1) {
                        $doc_count_text = '1 document';
                    }
                    ?>
                    <div class="document-count">
                        <?php echo $doc_count_text; ?>
                    </div>
                    <div class="document-list">
                        <?php
                        while ($doc_query->have_posts()) {
                            $doc_query->the_post();
                            get_template_part('template-parts/content', 'document-list-item');
                        } ?>
                    </div>
                    <?php
                    hale_archive_pagination('archive', $doc_query);
                } else { ?>
                    <p><?php _e('No Documents found', 'hale'); ?></p>
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



