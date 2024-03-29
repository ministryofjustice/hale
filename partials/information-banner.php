<?php

if( function_exists('get_field') ) {

    $active = get_field('info_banner_display', 'option');

    if($active) {
        $banner_title = get_field('info_banner_title', 'option');
        $banner_summary = get_field('info_banner_summary', 'option');
        if (is_null($banner_summary) || trim($banner_summary) == "" ) {
            $banner_summary = "";
        } else {
            $banner_summary = "<div class='info-banner__summary'>$banner_summary</div>";
        }
        $moreinfolink = get_field('info_banner_more_info', 'option');
        if (isset($moreinfolink) && trim($moreinfolink) != "") {
            $banner_info_link = "<a class='govuk-link info-banner__link' href='$moreinfolink'>".__("Find out more","hale")."</a>";
        } else {
            $banner_info_link = "";
        }
        ?>
        <div class="info-banner" id="critical-info-banner">
            <div class="info-banner__width-restriction" >
                <div class="info-banner__content" id="critical-info-banner-content">
                    <?php echo "
                        <h2 class='info-banner__title'>
                            $banner_title
                        </h2>
                        $banner_summary
                        $banner_info_link
                        ";
                    ?>
                </div>
                <button id='critical-info-banner-close-button' class='govuk-link info-banner__close'>
                    <?php _e("Hide","hale"); ?>
                </button>
            </div>
        </div>
        <?php
    }
}
