<?php
/**
 * View: Month Calendar Event
 *
 * @package nightingale
 *
 * @since 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$classes = tribe_get_post_class( [ 'tribe-events-calendar-month__calendar-event' ], $event->ID );

if ( ! empty( $event->featured ) ) {
	$classes[] = 'tribe-events-calendar-month__calendar-event--featured';
}
?>

<article <?php tribe_classes( $classes ); ?>>

	<?php $this->template( 'month/calendar-body/day/calendar-events/calendar-event/featured-image', [ 'event' => $event ] ); ?>

	<div class="tribe-events-calendar-month__calendar-event-details">

		<?php $this->template( 'month/calendar-body/day/calendar-events/calendar-event/date', [ 'event' => $event ] ); ?>
		<?php $this->template( 'month/calendar-body/day/calendar-events/calendar-event/title', [ 'event' => $event ] ); ?>

		<?php $this->template( 'month/calendar-body/day/calendar-events/calendar-event/tooltip', [ 'event' => $event ] ); ?>

	</div>

</article>
