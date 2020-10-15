<?php

$show_banner = get_theme_mod('show_header_banner', 'no');
$banner_title = get_theme_mod('header_banner_title');
$show_banner_link = get_theme_mod('show_header_banner_link', 'no');
$banner_link_txt = get_theme_mod('header_banner_link_text');
$banner_link_url = get_theme_mod('header_banner_link_url');
$banner_link_style = get_theme_mod('banner_link_style', 'nhsuk-button');

if ($show_banner == 'yes' && is_front_page()) {
    ?>

    <div class="nhsuk-width-container nightingale-banner__container">
        <div class=" nhsuk-grid-row">

            <div class="nhsuk-grid-column-two-thirds">
                    <h1 class="nightingale-banner__title"><?php echo $banner_title; ?></h1>
            </div>
            <div class="nhsuk-grid__item nhsuk-grid-column-one-third">

                <?php if ($show_banner_link == 'yes') { ?>
                    <a class="wp-block-nhsblocks-nhsbutton nightingale-banner__link <?php echo $banner_link_style; ?>"
                       href="<?php echo $banner_link_url; ?>"><?php echo $banner_link_txt; ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
