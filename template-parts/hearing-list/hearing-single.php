<?php
/**
 * Template part for displaying hearing single view.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('flexible-post-type-single')); ?>>
    <div class="flexible-post-type-header">
        <?php the_title('<h1 class="flexible-post-type-title govuk-heading-xl">', '</h1>'); ?>
    </div>

    <?php
    $show_published_date_on_single_view = hale_get_acf_field_status('show_published_date_on_single_view');
    $show_tax_on_single_view = hale_get_acf_field_status('show_tax_on_single_view');

    // Show published date
    if ($show_published_date_on_single_view) :
    ?>
        <div class="flexible-post-type-published-date-wrapper">
            <div class="flexible-post-type-published-date">
                <div class="flexible-post-type-published-date-label">Hearing date: </div>
                <?php hale_posted_on(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    /**
     * Show taxonomies
     *     
     * This loads the taxonomies in two styles depending on 
     * what is selected in the ACF post type settings.
     */

    $display_terms_taxonomies = array('hearing-witness');

    if ($show_tax_on_single_view && !empty($display_terms_taxonomies)) :
        $tax_details = hale_get_post_tax_details($display_terms_taxonomies);
        $single_view_tax_style = hale_get_post_type_setting('single_view_tax_style');

        if (!empty($tax_details) && trim($single_view_tax_style) === 'tags') :
            get_template_part(
                'template-parts/hearing-list/hearing-term-tag',
                false,
                array('tax-details' => $tax_details)
            );
        else :
            get_template_part(
                'template-parts/hearing-list/hearing-term-list',
                false,
                array('tax-details' => $tax_details)
            );
        endif;
    endif;

    // Show summary
    $post_summary_active = hale_get_acf_field_status('post_summary');
    $show_summary_on_single_view = hale_get_acf_field_status('show_summary_on_single_view');

    if ($post_summary_active && $show_summary_on_single_view) :
        $show_summary = get_field('show_post_summary');

        if (is_null($show_summary)) {
            $show_summary = true;
        }

        if ($show_summary) :
            $summary = get_field('post_summary');

            if (!empty($summary)) :
    ?>
                <div class="hearing-summary">
                    <div class="intro">
                        <?php echo wpautop($summary); ?>
                    </div>
                </div>
    <?php
            endif;
        endif;
    endif;
    ?>

    <?php do_action('hale_before_single_content'); ?>

    <div class="flexible-post-type-content">
        <?php

        // Show page content
        if (function_exists('hale_clean_bad_content')) {
            hale_clean_bad_content(true);
        }
        ?>
    </div><!-- .article-content -->
    <div class="govuk-clearfix"></div>

    <?php do_action('hale_after_single_content'); ?>

    <footer class="flexible-post-type-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
