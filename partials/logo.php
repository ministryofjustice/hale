<?php
/**
 * The logo for our theme
 *
 * This is the template that displays the logo
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version 2.0 February 2021
 */

$org_name_checkbox = get_theme_mod( 'org_name_checkbox', 'no' );
$org_name_field    = get_theme_mod( 'org_name_field' );

$print_logo = get_theme_mod( 'print_logo', '' );
$show_sitelogo = get_theme_mod( 'logo_configuration' ) == 'logo' || get_theme_mod( 'logo_configuration' ) == 'both' ? "yes" : "";
$show_sitename = get_theme_mod( 'logo_configuration' ) == 'name' || get_theme_mod( 'logo_configuration' ) == 'both' ? "yes" : "";
$logo_has_link = get_theme_mod( 'logo_has_link', 'yes' );
$logo_custom_link = get_theme_mod( 'logo_custom_link', '' );
$logo_aria_label = get_theme_mod( 'logo_aria_label', get_bloginfo( 'name' ) . " " . __("homepage","hale") );

if(!empty($logo_custom_link)){
    $logo_link = $logo_custom_link;
}
else {
    $logo_link = get_home_url();
}


/* Check if Organisation name should be different from the site name */

$logo_line_1 = 'no' === $org_name_checkbox ? get_bloginfo( 'name' ) : get_theme_mod( 'org_name_field' );
$logo_line_2 = 'no' === $org_name_checkbox ? get_bloginfo( 'description' ) : get_bloginfo( 'name' );

?>
<?php if ($print_logo != "") { ?>
<div class="govuk-header__logo hale-print-only hale-print-logo">
    <img src="<?php echo $print_logo; ?>" alt="<?php $logo_aria_label; ?>" />
</div>
<?php } ?>
<?php if ( $show_sitename === 'yes' || $show_sitelogo === 'yes' ) { ?>
<div class="govuk-header__logo">
<?php if ( $logo_has_link === 'yes' ) { ?>
    <a class="govuk-header__link govuk-header__link--homepage" href="<?php echo esc_url_raw( $logo_link ); ?>" aria-label="<?php echo $logo_aria_label; ?>">
<?php
    }
    if ( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $image = wp_get_attachment_image( $custom_logo_id , 'full' );
    }
?>
  <div class="govuk-header__logotype
    <?php
      if ( $show_sitelogo !== 'yes' ) {
    ?>
      hale-header__logotype--no-logo">
    <?php } else { ?>
      <?php
        if ( has_custom_logo() ) {
      ?>
        hale-header__logotype--custom">
        <div class="hale-header__logo--custom">
      <?php
          echo $image;
          echo "</div>";
        } else {
      ?>
        ">
        <svg role="presentation" focusable="false" class="moj-header__logotype-crest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 702.47 624.08" height="40" width="47">
          <?php include 'govuk-crest-svg-content.php'; ?>
          <image src="/assets/images/gov-crest-white.png" xlink:href="" class="govuk-header__logotype-crown-fallback-image" width="702.47" height="624.08"></image>
        </svg>
      <?php } //endif for custon logo = no ?>
    <?php } //endif for site logo = yes ?>
    <?php if ( $show_sitename === 'yes' ) { ?>
      <span class="govuk-header__logotype-text hale-header__logotype-text--custom">
        <?php echo esc_html( $logo_line_1 ); ?>
      </span>
    <?php } ?>
  </div>
<?php if ( $logo_has_link === 'yes' ) { ?>
  </a>
<?php } ?>
</div>
<?php } ?>
