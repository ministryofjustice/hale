<?php
/**
 * Template Name: Document Listing
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

get_header();

//Get Search text Value

$doc_search_text = '';

if (get_query_var('doc_search')) {

    $doc_search_text = sanitize_text_field(get_query_var('doc_search'));
    $search_text_HTML = htmlspecialchars($doc_search_text, ENT_QUOTES);
    $search_text_HTML = str_replace('\\', '', $search_text_HTML); // kill backslashes
    $search_text_HTML = str_replace('%', '&percnt;', $search_text_HTML); // deal with percentages
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

if (get_query_var('doc_location')) {

    $doc_loc_id = get_query_var('doc_location');
    if (is_numeric($doc_loc_id)) {

        $doc_loc_id = intval($doc_loc_id);

        if (term_exists($doc_loc_id, 'document_location')) {
            $selected_doc_location_id = $doc_loc_id;
        }
    }
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
                <div class="document-listing-search-section">
                    <div class="document-listing-search-form">
                        <form action="<?php echo get_permalink(); ?>" method="GET">
                            <label for="doc-search-field" class="govuk-visually-hidden">Search</label>
                            <input class="govuk-input" id="doc-search-field" name="doc_search"
                                   value="<?php echo $search_text_HTML; ?>" type="search"
                                   placeholder="Search">

                            <?php

                            $show_doc_type_filter = false;

                            $tax_document_type_activated = get_theme_mod('tax_document_type_activated', 0);
                            $document_type_filter_activated = get_post_meta(get_the_ID(), 'document_type_filter_activated', true);

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
                            $document_location_filter_activated = get_post_meta(get_the_ID(), 'document_location_filter_activated', true);

                            if ($tax_document_location_activated && $document_location_filter_activated) {
                                $show_doc_location_filter = true;
                            }


                            if ($show_doc_type_filter || $show_doc_category_filter || $show_doc_location_filter) {
                                ?>
                                <p>Filters</p>
                                <?php
                            }

                            //Taxonomy Document Type Search Filter

                            if ($show_doc_type_filter && $restrict_documents != "document_type") {

                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'doc_type',
                                        'id' => 'document-search-filter-type',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'document_type',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_doc_type_id

                                    )
                                );

                                if (!empty($dropdown_html)) { ?>

                                    <label class="govuk-label" for="document-search-filter-type">Type</label>
                                    <?php echo $dropdown_html; ?>

                                    <?php
                                }
                            }

                            //Taxonomy Document Category Search Filter

                            if ($show_doc_category_filter && $restrict_documents != "document_category") {

                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'doc_category',
                                        'id' => 'document-search-filter-category',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'document_category',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_doc_category_id

                                    )
                                );

                                if (!empty($dropdown_html)) { ?>

                                    <label class="govuk-label" for="document-search-filter-category">Category</label>
                                    <?php echo $dropdown_html; ?>

                                    <?php
                                }
                            }


                            //Taxonomy Document Location Search Filter

                            if ($show_doc_location_filter && $restrict_documents != "document_location") {

                                ?>
                                <?php

                                $dropdown_html = wp_dropdown_categories(
                                    array(
                                        'name' => 'doc_location',
                                        'id' => 'document-search-filter-location',
                                        'class' => 'govuk-select',
                                        'taxonomy' => 'document_location',
                                        'show_option_all' => 'Select option',
                                        'orderby' => 'name',
                                        'echo' => 0,
                                        'hide_if_empty' => 1,
                                        'selected' => $selected_doc_location_id

                                    )
                                );

                                if (!empty($dropdown_html)) { ?>

                                    <label class="govuk-label" for="document-search-filter-location">Location</label>
                                    <?php echo $dropdown_html; ?>

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

                $show_document_summaries = get_post_meta(get_the_ID(), 'show_document_summaries', true);

                $restrict_by_type = get_post_meta(get_the_ID(), 'restrict_by_type', true);

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $doc_args = array(
                    'post_type' => 'document',
                    'posts_per_page' => 10,
                    'relevanssi' => true,
                    'paged' => $paged
                );

                //Set Number of Documents to be displayed per page
                $documents_per_page = get_post_meta(get_the_ID(), 'documents_per_page', true);

                if (!empty($documents_per_page)) {
                    $doc_args['posts_per_page'] = $documents_per_page;
                } else {
                    $doc_args['posts_per_page'] = 10;
                }

                //Search by text
                if (!empty($doc_search_text)) {

                    $doc_args['s'] = $doc_search_text;
                    //Meta fields (such as summary) are searched using relevanssi
                } else {
                    //Documents are sorted be relevance if text search is used. If not the default sort is used.
                    $document_listing_sort = get_post_meta(get_the_ID(), 'document_listing_default_sort', true);

                    if ($document_listing_sort == 'title') {
                        $doc_args['orderby'] = 'title';
                        $doc_args['order'] = 'ASC';
                    } else {
                        $doc_args['orderby'] = 'post_date';
                        $doc_args['order'] = 'DESC';
                    }
                }

                // Construct Taxonomy query depending on filters and restrictions
                $tax_qry_ary = [];

                //Add Document Restriction
                if (!empty($restrict_documents) && $restrict_documents != 'no') {

                    if (taxonomy_exists($restrict_documents)) {

                        //Documents will only display with the given term ids - from a set taxonomy
                        $restrict_term_ids = get_post_meta(get_the_ID(), 'restrict_documents_by_' . $restrict_documents, true);

                        if (!empty($restrict_term_ids)) {
                            $tax_qry_ary[] = array(
                                'taxonomy' => $restrict_documents,
                                'field' => 'term_id',
                                'terms' => $restrict_term_ids
                            );
                        }
                    }
                }

                //Document Type Filter
                if ($restrict_documents != "document_type") {

                    if (!empty($selected_doc_type_id)) {

                        $tax_qry_ary[] = array(
                            'taxonomy' => 'document_type',
                            'field' => 'term_id',
                            'terms' => $selected_doc_type_id
                        );

                    }
                }

                //Document Category Filter
                if ($restrict_documents != "document_category") {

                    if (!empty($selected_doc_category_id)) {

                        $tax_qry_ary[] = array(
                            'taxonomy' => 'document_category',
                            'field' => 'term_id',
                            'terms' => $selected_doc_category_id
                        );

                    }
                }

                //Document Location Filter
                if ($restrict_documents != "document_location") {

                    if (!empty($selected_doc_location_id)) {

                        $tax_qry_ary[] = array(
                            'taxonomy' => 'document_location',
                            'field' => 'term_id',
                            'terms' => $selected_doc_location_id
                        );

                    }
                }

                if (!empty($tax_qry_ary)) {

                    $doc_args['tax_query'] = $tax_qry_ary;

                }

                $doc_query = new WP_Query($doc_args);
                $document_type_filter_activated = get_post_meta(get_the_ID(), 'document_type_filter_activated', true);
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
                            get_template_part('template-parts/content', 'document-list-item', array('show_document_summaries' => $show_document_summaries));
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



