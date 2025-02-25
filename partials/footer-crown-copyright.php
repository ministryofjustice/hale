<?php
$copyright_style = "padding-top:0; background-image:none;";
?>
<div class="govuk-footer__meta-item">
	<a
		class="govuk-footer__link govuk-footer__copyright-logo"
		href="https://www.nationalarchives.gov.uk/information-management/re-using-public-sector-information/uk-government-licensing-framework/crown-copyright/"
		style="<?php echo $copyright_style; ?>"
	>
	<svg xmlns="http://www.w3.org/2000/svg" class="govuk-footer__gov-crest" id="footer-crest" viewBox="0 0 702.47 624.08">
	<?php
		get_template_part('partials/govuk-crest-svg-content');
	?>
	<image src="<?php echo get_template_directory_uri(); ?>/assets/images/govuk-crest-2x.webp" xlink:href="" class="govuk-footer__crest-fallback-image" width="702.47" height="624.08"></image>
	</svg>
	<?php
		echo esc_html__('&copy; Crown copyright', 'hale');
	?>
	</a>
</div>
