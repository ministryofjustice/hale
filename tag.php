<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

get_header();


?>

    <div id="primary" class="govuk-grid-column-full-from-desktop">
        <h1 class="govuk-heading-xl"><?php
            echo '#' . single_tag_title('', false);
            ?>
        </h1>
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-two-thirds">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        get_template_part( 'template-parts/content', 'news-list-item' );
                    }
                } else { ?>
                    <p><?php _e('No news articles found', 'hale'); ?></p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div><!-- #primary -->

<?php

get_footer();
