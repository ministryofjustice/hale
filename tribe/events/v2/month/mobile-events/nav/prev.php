<?php
/**
 * View: Month View Nav Previous Button
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/month/mobile-events/nav/prev.php
 *
 * See more documentation about our views templating system.
 *
 * @package nightingale
 *
 * @var string $link The URL to the previous page, if any, or an empty string.
 * @var string $label The label for the previous link.
 *
 * @version 5.0.1
 */

?>
<li class="tribe-events-c-nav__list-item tribe-events-c-nav__list-item--prev">
	<a
		href="<?php echo esc_url( $link ); ?>"
		rel="prev"
		class="tribe-events-c-nav__prev tribe-common-b2"
		data-js="tribe-events-view-link"
		aria-label="
		<?php
		echo esc_attr(
			sprintf(
				/* translators: %s: Name of previous month */
				__(
					'Previous month,
					%1$s',
					'nightingale'
				),
				$label
			)
		);
		?>
		"
		title="
		<?php
		echo esc_attr(
			sprintf(
				/* translators: %s: Name of previous month */
				__(
					'Previous month,
					%1$s',
					'nightingale'
				),
				$label
			)
		);
		?>
		">
		<?php echo esc_html( $label ); ?>
	</a>
</li>
