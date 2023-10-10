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

$mourning        = get_theme_mod( 'mourning', 'no' );
$mourning_name   = get_theme_mod( 'mourning_name', '' );
$mourning_link   = get_theme_mod( 'mourning_link', '' );
$mourning_dob    = get_theme_mod( 'mourning_dob', '' );
$mourning_date   = get_theme_mod( 'mourning_date', '' );
$banner = false;

if (
    $mourning == 'yes' && 
    !empty($mourning_name) && $mourning_name != '' &&
    !empty($mourning_date) && $mourning_date != ''
) {
    $banner = true;
}

if ($banner && !empty($mourning_link)){
    $banner_link = "<a class='govuk-link govuk-link--inverse' href='$mourning_link'>More information</a>";
} else {
    $banner_link = "";
}
if ($banner && !empty($mourning_dob) && $mourning_dob != ''){
    $banner_text = $mourning_dob . " to " . $mourning_date;
} else {
    $banner_text = $mourning_date;
}

if ($banner) {
    ?>
    <div
        class="emergency-banner"
        style="
		background-color: #0b0c0c;
		color: #fff;
		padding: 2rem 3rem 3rem;
		border-bottom: 2px solid #f1f2f3;
	">
        <div style="
			max-width:960px;
			margin:0 auto;"
        >
            <div style="
				font-weight: bold;
				font-size: 48px;
				padding-bottom: 2rem;
			">
                <?php
                echo $mourning_name;
                ?>
            </div>
            <div style="
				padding-bottom: 2rem;
			">
                <?php
                echo $banner_text;
                ?>
            </div>
            <?php
            if (isset($banner_link) && $banner_link != "") {
                ?>
                <div style="
				">
                    <?php echo $banner_link; ?>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
}
