<?php
/**
 * The critical informaiton banner for our theme
 *
 * This is the template that displays the critical information banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 */

$critical_info            = get_theme_mod( 'critical_info', 'no' );
$critical_info_expiry     = get_theme_mod( 'critical_info_expiry_date', '' );
$critical_info_headline   = get_theme_mod( 'critical_info_headline' );
$critical_info_subtext    = get_theme_mod( 'critical_info_subtext' );
$critical_info_link       = get_theme_mod( 'critical_info_link' );
$banner = false;

if (
    $critical_info == 'yes' && 
    !empty($critical_info_headline) && 
    $critical_info_headline != '' &&
    strtotime($critical_info_expiry) > time()-86400 // 86400 = 1 day
) {
    $banner = true;
}

if ($banner && !empty($critical_info_link)){
    $banner_link = "<a class='govuk-link' href='$critical_info_link'>More information</a>";
} else {
    $banner_link = "";
}
if ($banner && !empty($critical_info_subtext)){
    $banner_text = $critical_info_subtext;
} else {
    $banner_text = "";
}

if ($banner) {
    ?>
    <div class="govuk-grid-column-two-thirds-from-desktop">
        <div
            class="govuk-notification-banner hale-notification-banner hale-notification-banner--black"
            id="critical-info-banner"
            role="region"
            aria-labelledby="govuk-notification-banner-title"
            data-module="govuk-notification-banner"
        >
            <div class="govuk-notification-banner__header" id="critical-info-banner-title">
                <h2 class="govuk-notification-banner__title" id="govuk-notification-banner-title">
                    Important
                </h2>
            </div>
            <div class="govuk-notification-banner__content">
                <p class="govuk-notification-banner__heading">
                    <?php echo $critical_info_headline; ?>
                </p>
                <?php
                if ($banner_text != "") {
                    echo "<p class='govuk-body'>$banner_text</p>";
                }
                if ($banner_link != "") {
                    echo "<p class='govuk-body'>$banner_link</p>";
                }
                ?>
                </p>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<div style='display:none;'>Expires: $critical_info_expiry; Title: $critical_info_headline; Ticked: $critical_info;</div>";
}
