<?php
/**
 * View: Day View Nav Template
 *
 * @package nightingale
 *
 * @var string $prev_url The URL to the previous page, if any, or an empty string.
 * @var string $next_url The URL to the next page, if any, or an empty string.
 * @var string $today_url The URL to the today page, if any, or an empty string.
 *
 * @version 4.9.4
 */

?>
<nav class="tribe-events-calendar-day-nav tribe-events-c-nav">
	<ul class="tribe-events-c-nav__list">
		<?php
		if ( ! empty( $prev_url ) ) {
			$this->template( 'day/nav/prev', [ 'link' => $prev_url ] );
		} else {
			$this->template( 'day/nav/prev-disabled' );
		}
		?>

		<?php
		if ( ! empty( $next_url ) ) {
			$this->template( 'day/nav/next', [ 'link' => $next_url ] );
		} else {
			$this->template( 'day/nav/next-disabled' );
		}
		?>
	</ul>
</nav>
