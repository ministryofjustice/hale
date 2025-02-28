<?php
	/**
	 * The shaded full-width title that goes above the main page content area and tables of contents.
	 * Formed of three parts:
	 * - The type
	 * - The H1 - main page title
	 * - The published or modified date
	 */

	$post = get_queried_object();
	$post_type = get_post_type_object(get_post_type($post));
	$revision_date_set = false;
	if ($post_type) {
		$post_type_name = $post_type->labels->singular_name;
		if (isset($post_type->revision_date) && $post_type->revision_date == '1') {
			$revision_date = get_field('post_revision_date');
			if ($revision_date != "") $revision_date_set = true;
		}
	}
?>
<div class="govuk-grid-column-full hale-shaded-heading">
	<div class="govuk-grid-column-two-thirds hale-shaded-heading__container govuk-!-padding-top-3 govuk-!-padding-bottom-3">
		<?php
			if ($post_type) {
				echo "<span class='govuk-caption-l'>$post_type_name</span>";
			}
		?>
		<?php
			the_title('<h1 class="govuk-heading-xl govuk-!-margin-top-2 govuk-!-margin-bottom-2">', '</h1>');
		?>
		<span class="govuk-caption-m">
		<?php
			if ($revision_date_set) {
				echo __('Revision date:', 'hale' )." ";
				echo date(get_option( 'date_format' ), $revision_date);
			} elseif (get_the_date() == get_the_modified_date()) {
				echo __('Published:', 'hale' )." ";
				echo get_the_date();
			} else {
				echo __('Updated:', 'hale' )." ";
				echo get_the_modified_date();
			}
		?>
		</span>
	</div>
</div>
