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
$crown_copyright = get_theme_mod('crown_copyright', 'Yes');

flush();
?>
</div>
</main>
</div>

<footer class="govuk-footer " role="contentinfo" id="footer">
  <div class="govuk-width-container">


  <?php if ( is_active_sidebar( 'footer-area-one' ) || is_active_sidebar( 'footer-area-two' ) ) : ?>

  <div class="govuk-grid-row">
    <div class="govuk-grid-column-one-half">
        <div id="hale-footer-widgets" class="hale-footer__widgets" role="complementary">
        <?php dynamic_sidebar( 'footer-area-one' ); ?>
        </div>
    </div>

    <div class="govuk-grid-column-one-half">
        <div id="hale-footer-widgets" class="hale-footer__widgets" role="complementary">
        <?php dynamic_sidebar( 'footer-area-two' ); ?>
        </div>
    </div>
  </div>

    <?php endif; ?>


    <div class="govuk-footer__meta">
      <div class="govuk-footer__meta-item govuk-footer__meta-item--grow">
        <?php
          get_template_part( 'partials/footernav-secondary' );
          get_template_part( 'partials/footernav' );
          get_template_part( 'partials/footer-licence' );

          if ('yes' != $crown_copyright) {
            get_template_part( 'partials/footer-copyright' );
          }
        ?>
      </div>
      <?php
        if ('yes' == $crown_copyright) {
      ?>
        <div class="govuk-footer__meta-item">
          <a class="govuk-footer__link govuk-footer__copyright-logo" href="https://www.nationalarchives.gov.uk/information-management/re-using-public-sector-information/uk-government-licensing-framework/crown-copyright/">© Crown copyright</a>
        </div>
      <?php
        }
      ?>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
  <script>
    window.GOVUKFrontend.initAll()
  </script>
</body>
</html>
