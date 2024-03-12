<?php

if( function_exists('get_field') ) {

    $active = get_field('info_banner_display', 'option');

    if($active) {
        $banner_title = get_field('info_banner_title', 'option');
        $banner_summary = get_field('info_banner_summary', 'option');
        $moreinfolink = get_field('info_banner_more_info', 'option');
        if (isset($moreinfolink) && trim($moreinfolink) != "") {
            $banner_info_link = "<a class='govuk-link info-banner__link' href='$moreinfolink'>".__("More information","hale")."</a>";
        } else {
            $banner_info_link = "";
        }
        ?>
        <div class="info-banner" id="critical-info-banner">
            <div class="info-banner__width-restriction" >
                <?php echo "
                    <h2 class='info-banner__title'>
                        $banner_title
                    </h2>
                    <span class='info-banner__summary'>
                        $banner_summary
                    </span>
                    $banner_info_link
                    <a id='critical-info-banner-close-button' class='govuk-link info-banner__link info-banner__close' href='#'>Hide banner</a>
                    ";
                ?>
            </div>
        </div>
        <?php
    }
}
