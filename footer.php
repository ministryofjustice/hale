<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.1 21st August 2019
 */

flush();
?>
</div>
</main>
</div>

<footer>
	<div class="govuk-footer" id="footer">
		<div class="govuk-width-container">
			<?php if ( is_active_sidebar( 'footer-region' ) ) : ?>
				<div id="jotw-footer-widgets" class="jotw-footer__widgets" role="complementary">
					<?php dynamic_sidebar( 'footer-region' ); ?>
				</div>
				<?php
			endif;

			get_template_part( 'partials/footernav' );
			get_template_part( 'partials/footer-copyright' );
			?>

		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
