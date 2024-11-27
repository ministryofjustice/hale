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

  <div class="govuk-grid-row">
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

          $copyright_style = "padding-top:0; background-image:none;";
      ?>
        <div class="govuk-footer__meta-item">
          <a
            class="govuk-footer__link govuk-footer__copyright-logo"
            href="https://www.nationalarchives.gov.uk/information-management/re-using-public-sector-information/uk-government-licensing-framework/crown-copyright/"
            style="<?php echo $copyright_style; ?>"
          >
          <svg xmlns="http://www.w3.org/2000/svg" class="govuk-footer__gov-crest" id="footer-crest" viewBox="0 0 702.47 624.08">
            <?php
              include 'partials/govuk-crest-svg-content.php';
            ?>
            <image src="<?php echo get_template_directory_uri(); ?>/assets/images/govuk-crest-2x.webp" xlink:href="" class="govuk-footer__crest-fallback-image" width="702.47" height="624.08"></image>
          </svg>
          <?php
            echo esc_html__('&copy; Crown copyright', 'hale');
          ?>
          </a>
        </div>
      <?php
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
<script>
    window.MOJFrontend.initAll()
  /* var datePicker = window.MOJFrontend.DatePicker
var $datePicker = document.querySelector('[data-module="moj-date-picker"]')
if ($datePicker) {
  console.log($datePicker);
  MOJFrontend.DatePicker($datePicker, {});
}*/
  </script>
</body>
</html>
