<?php
/**
 * The logo for our theme
 *
 * This is the template that displays the logo
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.0 13th January 2020
 */

$nhs_logo          = get_theme_mod( 'nhs_logo', 'no' );
$header_layout     = get_theme_mod( 'logo_type', 'transactional' );
$org_name_checkbox = get_theme_mod( 'org_name_checkbox', 'no' );
$org_name_field    = get_theme_mod( 'org_name_field' );

$show_sitename = get_theme_mod( 'show_sitename', 'yes' );
$logo_has_link = get_theme_mod( 'logo_has_link', 'yes' );
$logo_custom_link = get_theme_mod( 'logo_custom_link', '' );

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
<a href="<?php echo esc_url_raw( get_home_url() ); ?>" aria-label="<?php bloginfo( 'name' ); ?> homepage">
<?php
if ( has_custom_logo() ) {

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image( $custom_logo_id , 'full' );
	?>
	<div class="nhsuk-header__logo">
        <?php if ( $logo_has_link === 'yes' ) { ?>
            <a class="nhsuk-header__logo--link" href="<?php echo esc_url_raw( $logo_link ); ?>">
        <?php
            }
        ?>
            <div class="custom-logo">
                <?php echo $image; ?>
            </div>
            <?php if ( $show_sitename === 'yes' ) { ?>
                <div class="nhsuk-header__transactional-service-name">
                    <?php echo esc_html( $logo_line_1 ); ?>
                </div>
                <?php
            }
            ?>
        <?php if ( $logo_has_link === 'yes' ) { ?>
            </a>
        <?php
        }
        ?>
	</div>
	<?php
}
else {
	?>
	<div class="nhsuk-header__logo">
        <?php if ( $logo_has_link === 'yes' ) { ?>
            <a class="nhsuk-header__link" href="<?php echo esc_url_raw( $logo_link ); ?>" aria-label="<?php bloginfo( 'name' ); ?> homepage">
        <?php
            }
        ?>
            <?php if ( $show_sitename === 'yes' ) { ?>
                <span class="nhsuk-organisation-name"><?php echo esc_html( $logo_line_1 ); ?></span>
            <?php } ?>
			<span class="nhsuk-organisation-descriptor"><?php echo esc_html( $logo_line_2 ); ?></span>
        <?php if ( $logo_has_link === 'yes' ) { ?>
		    </a>
        <?php
        }
        ?>
	</div>
	<?php
}
?>
</a>
