<?php

if( function_exists('get_field') ) {

    $banner_type = get_field('banner_type', 'option');

    $banner_type_class = "emergency-banner";

    $banner_title = $banner_subtext = "";

    switch ($banner_type) {
        case "No banner":
            $active = false;
            break;
        case "National emergency":
            $active = true;
            $banner_type_class .= "--national-emergency";
            $banner_title = get_field('banner_national_emergency_title', 'option');
            $banner_subtext = get_field('banner_summary', 'option');
            if (is_null($banner_title) || trim($banner_title) == "" || strtoupper(trim($banner_title)) == strtoupper(__("National emergency")))  {
                if (is_null($banner_subtext) || trim($banner_subtext) == "" ) {
                    $active = false;
                    break;
                }
                $banner_title = __("National emergency");
            }
            break;
        case "Local emergency":
            $active = true;
            $banner_type_class .= "--local-emergency";
            $banner_title = get_field('banner_local_emergency_title', 'option');
            $banner_subtext = get_field('banner_summary', 'option');
            if (is_null($banner_title) || trim($banner_title) == "" || strtoupper(trim($banner_title)) == strtoupper(__("Local emergency"))) {
                if (is_null($banner_subtext) || trim($banner_subtext) == "" ) {
                    $active = false;
                    break;
                }
                $banner_title = __("Local emergency");
            }
            break;
        case "National mourning":
            $active = true;
            $banner_title = get_field('banner_mourning_name', 'option');
            if (is_null($banner_title) || trim($banner_title) == "" ) {
                $active = false;
                break;
            };
            $banner_type_class .= "--mourning";
            $year_birth = get_field('year_of_birth', 'option');
            $year_death = get_field('year_of_death', 'option');
            if (isset($year_birth) && trim($year_birth) != "") {
                $banner_subtext = $year_birth." &ndash; ".$year_death;
            } else {
                $banner_subtext = $year_death;
            }
            break;
        default:
            $active = false;
    }

    if($active) {
        ?>
        <div class="emergency-banner <?php echo $banner_type_class; ?>" >
            <div class="emergency-banner__width-restriction" >
                <div class="emergency-banner__title">
                    <?php echo $banner_title; ?>
                </div>
                <div class="emergency-banner__subtext govuk-!-font-size-24">
                    <?php echo $banner_subtext; ?>
                </div>
                <?php
                $moreinfolink = get_field('banner_link_destination', 'option');
                if (isset($moreinfolink) && trim($moreinfolink) != "") {
                    ?>
                    <p class="govuk-body">
                        <a
                            class="emergency-banner-link"
                            href=" <?php echo $moreinfolink; ?>"
                        >
                            <?php _e("More information","hale"); ?>
                        </a>
                    </p>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
