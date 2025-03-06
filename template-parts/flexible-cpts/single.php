<?php
/**
 * Template part for displaying fleixble cpt of type simple
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('flexible-post-type-single')); ?>>
    <div class="flexible-post-type-header">
        <?php
            $full_width_heading = $args['full-width-heading'];
            if (!$full_width_heading) {
                the_title('<h1 class="flexible-post-type-title govuk-heading-xl">', '</h1>');
            }
        ?>
    </div>
    <?php
    $show_published_date_on_single_view = hale_get_acf_field_status('show_published_date_on_single_view');

    if($show_published_date_on_single_view) {
    ?>
        <div class="flexible-post-type-published-date">
                <div class="flexible-post-type-published-date-label">Published: </div>
                <?php hale_posted_on(); ?>
        </div>
    <?php } ?>
    <?php 
    
    get_template_part( 'template-parts/flexible-cpts/details'); 
    
    // Load feature image section
    get_template_part( 'template-parts/flexible-cpts/feature-image');
    ?>
    <?php

    $post_summary_active = hale_get_acf_field_status('post_summary');
    $show_summary_on_single_view = hale_get_acf_field_status('show_summary_on_single_view');

    if($post_summary_active  && $show_summary_on_single_view){

        $show_summary = get_field('show_post_summary');

        if(is_null($show_summary)){
            $show_summary = true;
        }

        if($show_summary){

            $summary = get_field('post_summary');

            if(!empty($summary)){ ?>
            <div class="intro">
                <?php echo wpautop($summary); ?>
            </div>
            <?php
            }
        }
    }
    ?>
    <?php do_action('hale_before_single_content'); ?>

    <div class="flexible-post-type-content">
        <?php
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
