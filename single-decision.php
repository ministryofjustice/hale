<?php
/**
 * The template for displaying all single decisions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    $primary_class = 'govuk-grid-column-two-thirds';

}
?>

	<div id="primary" class="<?php echo $primary_class;?>">
		<div class="single">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
				hale_get_prev_next();
			endwhile; // End of the loop.
			?>

		</div>

	</div><!-- #primary -->

<?php
get_footer();
