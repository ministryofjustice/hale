<?php
/**
 * The copyright message for our theme
 * This is the template that displays the copyright in the footer
 *
 * @link      https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Hale
 * Theme Hale with GDS styles
 * ©Crown Copyright
 * Adapted from version from NHS Leadership Academy, Tony Blacker
 * @version   2.0 February 2021

 */

$organisation_name = get_theme_mod('org_name_field', '');

$copyright_img = get_theme_mod('copyright_img');
$copyright_additional_text = get_theme_mod('copyright_additional_text', '');

?>
<div class="hale-footer__copyright">

    <?php

    if (!empty($copyright_img)) {
        ?>
        <div class="hale-footer__copyright_img">
            <img src="<?php echo $copyright_img; ?>"/>
        </div>
    <?php } ?>
    <?php echo esc_html__('&copy; Copyright', 'hale'); ?>,
    <?php
    if ('' !== $organisation_name) {
        echo esc_html($organisation_name);
    } else {
        bloginfo('name');
    }
    ?>
    <?php echo esc_html(date_i18n(__('Y', 'hale'))); ?>.
    <?php  if (!empty($copyright_additional_text)) { echo $copyright_additional_text; }?>

</div>
