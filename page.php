<?php

/**
 * Default template
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
    ?>

<div id="primary" class="govuk-grid-column-two-thirds">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    $show_title_section = get_post_meta($post->ID, 'hale_metabox_page_title_section', true);

    if (empty($show_title_section)) {
        $show_title_section = 'yes';
    }

    if(is_front_page() === false && $show_title_section == 'yes') { ?>

        <div class="page-header-section">

            <?php

        /**
         * Category page list section
         * This loads the category list section if cat metabox is checked
         *
         * */
        include(locate_template('partials/category-list-section.php', false, false));



         // Header loads if category not selected on page
                if (empty($is_cat_page)) { ?>
                 <h1 class="govuk-heading-l"><?php the_title(); ?></h1>
             <?php
                }

        ?>
        </div>
    <?php
    }
    ?>
      <div class=" <?php echo hale_sidebar_location('sidebar-1'); ?>">

        <?php

        // Page title if category selected on page
        if (is_front_page() === false) {
            if (!empty($is_cat_page)) {

            // Add special heading CSS class depending on if category menu is activated
            $hale_heading_class = $is_cat_page ? ' hale-heading-l' : null;

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
        </div>

    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->
<div class="govuk-grid-column-one-third">
    <?php
    /**
     * Load page sidebar
     *
     * */
    get_sidebar('page');

    ?>
</div>
<?php endwhile;

flush();

get_footer();
