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

// Page-specific banner
$enable_banner_on_single_view = hale_get_acf_field_status('enable_banner_on_single_view');
$show_banner = get_field('show_post_banner');

if ($enable_banner_on_single_view && $show_banner) {
    $banner_content = "";
    // Main text
    $banner_text = get_field('post_banner_text');
    if ($banner_text && $banner_text != "") {
        $banner_content .= "<p class='govuk-body page-banner__text'>$banner_text</p>";
    }

    // Get max number of links
    $number_of_banner_links = hale_get_post_type_setting('single_view_banner_max_links');

    if (!$number_of_banner_links) $number_of_banner_links = 4;

    // Create links
    for ($i=1; $i<=$number_of_banner_links; $i++) {
        $link_text = "banner_link_txt_$i";
        $link_url = "banner_link_url_$i";
        $$link_text = get_field("post_banner_link_txt_$i");
        $$link_url = get_field("post_banner_link_url_$i");

        if ($$link_text && $$link_url && $$link_text != "" && $$link_url != "") {
            //Only create a link if both text and url are not missing
            $banner_content .= '<a class="page-banner__link govuk-link" href="'.$$link_url.'">'.$$link_text.'</a> ';
        }
    }

    if ($banner_content != "") echo "<div class='page-banner'><div class='page-banner__wrapper'>$banner_content</div></div>";
}
