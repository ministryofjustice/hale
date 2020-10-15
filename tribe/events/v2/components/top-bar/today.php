<?php
/**
 * View: Top Bar - Today
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/top-bar/today.php
 *
 * See more documentation about our views templating system.
 *
 * @var string $today_url The URL to the today page.
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.0 18th February 2020
 */

?>
<a
		href="
	<?php
		echo esc_url( $today_url );
	?>
"
		class="tribe-common-c-btn-border tribe-events-c-top-bar__today-button tribe-common-a11y-hidden nhsuk-button"
		data-js="tribe-events-view-link"
>
	<?php
	esc_html_e( 'Show all events', 'nightingale' );
	?>
</a>
