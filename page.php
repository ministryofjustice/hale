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
 * @version 1.0
 */

get_header();

flush();

while (have_posts()) :
    the_post();
    ?>

<div id="primary">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    /**
    * Category page list section
    * This loads the category list section if cat metabox is checked
    *
    * */
    include(locate_template('partials/category-list-section.php', false, false));

    // Page title
    if (is_front_page() === false) {

        // Header loads if category not selected on page
        if (empty($is_cat_page)) { ?>
            <header class="entry-header page-header" style="">
                <div class="govuk-width-container">
                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-two-thirds">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }
    }
    ?>
    <div class="govuk-grid-row">
        <div class="govuk-grid-column-two-thirds page

        <?php

        // Get sidebar value, is it set to display or not
        $show_sidebar = get_post_meta($post->ID, 'hale_metabox_page_sidebar', true);

        // If it's a new page, set sidebar to "on" by default
        if (empty($show_sidebar)) {
            $show_sidebar = 'yes';
        }

        // Apply CSS class depending on sidebar status
        $full_column_class = ( $show_sidebar != 'yes' ) ? 'govuk-grid-column-full' : null;

        echo nightingale_sidebar_location('sidebar-1'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo ' ' . $full_column_class; ?>">

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

        <div class="nhsuk-grid__item govuk-grid-column-one-third">
        <?php
            /**
             * Load page sidebar
             *
             * */
        if ($show_sidebar === 'yes') {
            get_sidebar('page');
        }
        ?>
        </div>
    </div>

    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #primary -->

<?php endwhile;

flush();

get_footer();
