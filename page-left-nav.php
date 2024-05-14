<?php

/**
 * Template Name: LHS Nav
 *
 * @package Hale
 * @copyright Ministry of Justice
 * @version 2.0
 */

$is_cat_page = false;

get_header();

flush();

while (have_posts()) :
    the_post();

    $show_title_section = get_post_meta($post->ID, 'hale_metabox_page_title_section', true);
if(is_front_page() === false && $show_title_section == 'yes') { ?>

<div class="govuk-grid-column-one-quarter-from-desktop hale-side-nav">
    <button type="button" id="side-nav-button" class="hale-side-nav__expand-control" aria-expanded="false" aria-label="Open and close chapter navigation"></button>

    <?php

    /**
     * Side menu section
     * This loads the category list section if cat metabox is checked
     *
     * */
    include(locate_template('partials/side-nav-section.php', false, false));
    ?>
</div>
<?php
}
?>
<div id="primary" class="govuk-grid-column-three-quarters-from-desktop hale-content-with-side-nav">
    <div id="overlay" class="overlay"></div>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    $show_title_section = get_post_meta($post->ID, 'hale_metabox_page_title_section', true);

    if (empty($show_title_section)) {
        $show_title_section = 'yes';
    }

    if(is_front_page() === false && $show_title_section == 'yes') { ?>


        <?php
        // Header loads if category not selected on page
        if (empty($is_cat_page)) { 
            ?>
            <div class="page-header-section">
            <h1 class="govuk-heading-xl govuk-!-static-margin-bottom-6"><?php the_title(); ?></h1>
            </div>
        <?php
            }
        ?>
    <?php
    }
    ?>
        <?php

        // Page title if category selected on page
        if (is_front_page() === false) {
            if (!empty($is_cat_page)) {

            // Add special heading CSS class depending on if category menu is activated
            $hale_heading_class = $is_cat_page ? ' govuk-heading-l' : '';

                echo '<h1 class="entry-title' . $hale_heading_class . '">' . get_the_title() . '</h1>';
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

    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->
<?php endwhile;

flush();

get_footer();
