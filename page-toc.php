<?php

/**
 * Template Name: Table of contents
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

$is_cat_page = false;

get_header();

flush();

$post_meta = get_post_meta($post->ID);

$show_title_section = 'yes';

if(array_key_exists('hale_metabox_page_title_section', $post_meta) && is_array($post_meta['hale_metabox_page_title_section']) && count($post_meta['hale_metabox_page_title_section']) > 0){
    if (!empty($post_meta['hale_metabox_page_title_section'][0])) {
        $show_title_section = $post_meta['hale_metabox_page_title_section'][0];
    }
}

if(is_front_page() === false && $show_title_section == 'yes') {
?>

    <div class="govuk-grid-column-two-thirds">
        <div class="page-header-section">
        <?php

        /**
         * Category page list section
         * This loads the category list section if cat metabox is checked
         *
         * */


        include(locate_template('partials/category-list-section.php', false, false));

        // Header loads if category not selected on page
        if (empty($is_cat_page)) {
            ?>
            <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6"><?php the_title(); ?></h1>
        <?php
            }
        ?>
        </div>
    </div>
<?php  //close <div id="contentinner" class="govuk-grid-row"> ?> 
</div>
<?php } ?>
<div class="govuk-grid-row">
<?php

if (function_exists('hale_table_of_contents')) {

    global $post;

    $numbered_headings = false;

    if(array_key_exists('page_numbered_headings', $post_meta) && is_array($post_meta['page_numbered_headings']) && count($post_meta['page_numbered_headings']) > 0){
        $display_numbered_headings = $post_meta['page_numbered_headings'][0];

        if(!empty($display_numbered_headings)){
            $numbered_headings = $display_numbered_headings;
        }
    }

    $toc = hale_table_of_contents($numbered_headings);
    echo "<div id='toc' class='govuk-grid-column-one-third'>" . wp_kses_post($toc) . "</div>";
}

while (have_posts()) :
    the_post();

    ?>

<div id="primary" class="govuk-grid-column-two-thirds">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
   if (is_front_page()) {
        // If we are on a landing page, we need to check that an H1 is present.
        // If one is not present, we need to add in a hidden one.
        if (strpos(get_the_content(),"<h1") === false) {
            $hidden_title = get_bloginfo("name")." &ndash; ".__("Homepage","hale");
            echo "<h1 class='govuk-visually-hidden'>" . esc_html($hidden_title) . "</h1>";
        }
    }
    ?>
      <div class=" <?php echo hale_sidebar_location('sidebar-1'); ?>">

        <?php

        // Page title if category selected on page
        if (is_front_page() === false) {
            if (!empty($is_cat_page)) {

                // Add special heading CSS class depending on if category menu is activated
                $hale_heading_class = $is_cat_page ? ' govuk-heading-l' : '';

                echo '<h1 class="entry-title' . esc_attr($hale_heading_class) . '">' . esc_html(get_the_title()) . '</h1>';


            }
        }

        // Page excerpt
        if (has_excerpt()) {
            echo '<div class="intro">' . get_the_excerpt() . '</div>';
        }

        // Page body content
        get_template_part('template-parts/content', 'page');

        // Page previous/next tabs
        include(locate_template('partials/next-previous-tabs.php', false, false));
        ?>
        </div>

    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->
<?php endwhile;

flush();

get_footer();
