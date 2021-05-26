<?php
/**
 * Template part for displaying posts
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="govuk-heading-xl">', '</h1>' );
		else :
			the_title( '<h2 class="govuk-heading-l"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="hale-review-date">
				<?php
				hale_posted_by();
				hale_posted_on();
				$readmorelink  = esc_url( get_permalink() );
				$readmoretitle = esc_html( get_the_title() );
				if ( strlen( $readmoretitle ) < 1 ) {
					$readmoretitle = esc_html__( 'this post', 'hale' );
					echo '<div class="hale-readmore">' . hale_read_more_posts( $readmoretitle, $readmorelink ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				</p>
			</div><!-- .article-meta -->
		<?php endif; ?>
	</header><!-- .article-header -->

	<?php
	if ( has_post_thumbnail() ) {
		$featured_img_display = get_theme_mod( 'featured_img_display', 'true' );
		if ( 'true' === $featured_img_display ) {
			$blog_fimage_display = get_theme_mod( 'blog_fimage_display', 'top' );
			echo '<span class="featured-' . $blog_fimage_display . '">';
			hale_post_thumbnail();
			echo '</span>';
		}
	}
	?>

	<?php do_action( 'hale_before_single_content' ); ?>

	<article>
		<?php
		if ( function_exists( 'hale_clean_bad_content' ) ) {
            hale_clean_bad_content( true );
		}

		$defaults = array(
			'before'           => '<p>' . __( 'Pages:', 'hale' ),
			'after'            => '</p>',
			'link_before'      => '',
			'link_after'       => '',
			'next_or_number'   => 'number',
			'separator'        => ' ',
			'nextpagelink'     => __( 'Next page', 'hale' ),
			'previouspagelink' => __( 'Previous page', 'hale' ),
			'pagelink'         => '%',
			'echo'             => 1,
		);

		wp_link_pages( $defaults );
		?>
	</article><!-- .article-content -->
	<div class="govuk-clearfix"></div>

	<?php do_action( 'hale_after_single_content' ); ?>

	<footer class="article-footer">

		<?php hale_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
