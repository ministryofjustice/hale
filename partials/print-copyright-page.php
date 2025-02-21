<?php
/**
 * Creates the copyright page for print only
 * If OLG or Crown Copyright, this is a whole page
 * Else it is a line on the same page as the table of contents
 */

	$crown_copyright = get_theme_mod('crown_copyright', 'yes');
	$include_licence = get_theme_mod('include_licence', 'yes');
	$small_copyright = "";
	$big_copyright = "";

	if ($crown_copyright != 'yes') {
		$organisation_name = get_theme_mod('org_name_field', '');
		$copyright_img = get_theme_mod('copyright_img');

		$small_copyright = esc_html__('&copy; Copyright', 'hale').", ";
		if ('' !== $organisation_name) {
			$small_copyright .=  esc_html($organisation_name);
		} else {
			bloginfo('name');
		}
		$small_copyright .=  esc_html(date_i18n(__(' Y', 'hale'))).".";

		if (!empty($copyright_img)) {
			$big_copyright = "
			<img class='hale-print-arms__crest' src='$copyright_img'/>
			<p class='govuk-body hale-print-arms__copyright'>$small_copyright</p>
			";
		}
	} else {
		$big_copyright = '<svg xmlns="http://www.w3.org/2000/svg" class="hale-print-arms__crest" id="footer-crest" viewBox="0 0 702.47 624.08">';
		ob_start();
		get_template_part( 'partials/govuk-crest-svg-content' );
		$big_copyright .= ob_get_clean();
		$big_copyright .=  "</svg><p class='govuk-body hale-print-arms__copyright'>".esc_html__('&copy; Crown copyright', 'hale')."</p>";
	}

?>
<?php
	if ($include_licence == 'yes' || $crown_copyright == 'yes') {
?>
<div class="page-break hale-print-only"></div>
<div class="page-break hale-print-only">
	<?php 
		if ($include_licence == 'yes') {?>
			<svg aria-hidden="true" focusable="false" class="govuk-!-margin-bottom-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 483.2 195.7" height="30">
				<path fill="#000A" d="M421.5 142.8V.1l-50.7 32.3v161.1h112.4v-50.7zm-122.3-9.6A47.12 47.12 0 0 1 221 97.8c0-26 21.1-47.1 47.1-47.1 16.7 0 31.4 8.7 39.7 21.8l42.7-27.2A97.63 97.63 0 0 0 268.1 0c-36.5 0-68.3 20.1-85.1 49.7A98 98 0 0 0 97.8 0C43.9 0 0 43.9 0 97.8s43.9 97.8 97.8 97.8c36.5 0 68.3-20.1 85.1-49.7a97.76 97.76 0 0 0 149.6 25.4l19.4 22.2h3v-87.8h-80l24.3 27.5zM97.8 145c-26 0-47.1-21.1-47.1-47.1s21.1-47.1 47.1-47.1 47.2 21 47.2 47S123.8 145 97.8 145" />
			</svg>
					
			<p class="govuk-body govuk-!-margin-bottom-4">
				All content is available under the Open Government Licence v3.0, except where otherwise stated.
			</p>
			<p class="govuk-body">	
				To view this licence, visit:<br /><u>https://nationalarchives.gov.uk/doc/open-government-licence/version/3</u>
			</p>
			<p class="govuk-body">
				or write to:<br />
				Information Policy Team, <br />
				The National Archives, <br />
				Kew, <br />
				London TW9 4DU
			</p>
			<p class="govuk-body">
				or email: <u>psi@nationalarchives.gov.uk</u>.
			</p>
			</p>
			<p class="govuk-body govuk-!-margin-bottom-4">
				<?php
				$home_URL = esc_attr( get_home_url() );
				echo "This publication is available at: <br /><u>$home_URL</u>.";
				?>
			</p>
	<?php 
		}
		if ($big_copyright != "") {
			echo "<div class='hale-print-arms govuk-!-text-align-centre'>$big_copyright</div>";
		} else {
			echo "<p class='govuk-body'>$small_copyright</p>";
		}
	?>
</div>
<?php
	} else {
?>
		<div class="page-break hale-print-only"><?php echo $small_copyright;?></div>
<?php
	}
