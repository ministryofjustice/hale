<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

$show_title = get_post_meta(get_the_ID(), 'display-page-title', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if($show_title != 'no' && is_front_page() == false){ ?>
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title hale-heading-l">', '</h1>' ); ?>
        </header><!-- .entry-header -->
    <?php } ?>

	<?php do_action( 'nightingale_before_single_content' ); ?>

	<div class="entry-content">
		<?php
		if ( function_exists( 'nightingale_clean_bad_content' ) ) {
			nightingale_clean_bad_content( true );
		}
		?>

		<?php do_action( 'page_after_content' ); ?>
	</div><!-- .entry-content -->
	<div class="nhsuk-content__clearfix"></div>

	<?php do_action( 'nightingale_after_single_content' ); ?>

	<?php if ( get_edit_post_link() ) : ?>

	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
