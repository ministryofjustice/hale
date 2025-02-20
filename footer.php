<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */
$crown_copyright = get_theme_mod('crown_copyright', 'yes');

flush();
?>
</div>
</main>
</div>

<footer class="govuk-footer " role="contentinfo" id="footer">
  <div class="govuk-width-container">


    <?php if ( is_active_sidebar( 'footer-area-one' ) || is_active_sidebar( 'footer-area-two' ) ) : ?>

    <div class="govuk-grid-row hale-screen-only">
      <div class="govuk-grid-column-one-half">
          <div id="hale-footer-area-1" class="hale-footer__widgets">
          <?php dynamic_sidebar( 'footer-area-one' ); ?>
          </div>
      </div>

      <div class="govuk-grid-column-one-half">
          <div id="hale-footer-area-2" class="hale-footer__widgets">
          <?php dynamic_sidebar( 'footer-area-two' ); ?>
          </div>
      </div>
    </div>

    <?php endif; ?>


    <div class="govuk-footer__meta">
      <div class="govuk-footer__meta-item govuk-footer__meta-item--grow">
        <div class="hale-screen-only">
          <?php
            get_template_part( 'partials/footernav-secondary' );
            get_template_part( 'partials/footernav' );
          ?>
        </div>
        <?php
          get_template_part( 'partials/footer-licence' );

          if ('yes' != $crown_copyright) {
            get_template_part( 'partials/footer-copyright' );
          }
        ?>
      </div>
      <?php
        if ('yes' == $crown_copyright) {
          get_template_part( 'partials/footer-crown-copyright' );
        }
      ?>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
<script type="module">

  import { initAll } from '<?php echo get_stylesheet_directory_uri() ?>/dist/js/govuk-frontend.js'

  initAll()
</script>
</body>
</html>
