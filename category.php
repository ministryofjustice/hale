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


$sidebar = hale_hierarchy();
$side_chapter_headings = false;
if (!$sidebar) {
    /**
     * Side menu section
     * This loads the category list section if cat metabox is checked
     * Will clash with other sidenav - so we revert to top nav if sidebar menu active
     * */
    include(locate_template('partials/side-nav-section.php', false, false));
}
if ($sidebar || $side_chapter_headings) {
    $primary_class = 'govuk-grid-column-three-quarters-from-desktop hale-content-with-side-nav';
} else {
    $primary_class = 'govuk-grid-column-full-from-desktop';

}
?>
    <div id="primary" class="<?php echo $primary_class;?>">
        <h1 class="govuk-heading-xl"><?php
            echo 'Topic: ' . single_cat_title('', false);
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
