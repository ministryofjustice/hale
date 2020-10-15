<?php
/**
 * View: Events Bar
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/events-bar.php
 *
 * See more documentation about our views templating system.
 *
 * @package Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version 1.0 18th February 2020
 *
 * @var bool $display_events_bar Boolean on whether to display the events bar.
 * @var bool $disable_event_search Boolean on whether to disable the event search.
 */

if ( empty( $display_events_bar ) ) {
	return;
}
/* translators: %s: Menu. */
$heading = $disable_event_search ? __( 'Views Navigation', 'nightingale' ) : sprintf( __( '%s Search and Views Navigation', 'nightingale' ), tribe_get_event_label_plural() );

$classes = [ 'tribe-events-header__events-bar', 'tribe-events-c-events-bar' ];
if ( empty( $disable_event_search ) ) {
	$classes[] = 'tribe-events-c-events-bar--border';
}
?>
<div
	<?php tribe_classes( $classes ); ?>
		data-js="tribe-events-events-bar"
>

	<h2 class="tribe-common-a11y-visual-hide">
		<?php echo esc_html( $heading ); ?>
	</h2>

	<?php if ( empty( $disable_event_search ) ) : ?>
		<?php $this->template( 'components/events-bar/search-button' ); ?>

		<div
				class="tribe-events-c-events-bar__search-filters-container"
				id="tribe-events-search-filters-container"
				data-js="tribe-events-search-filters-container"
		>
			<?php $this->template( 'components/events-bar/tabs' ); ?>

			<?php $this->template( 'components/events-bar/search' ); ?>

			<?php $this->template( 'components/events-bar/filters' ); ?>
		</div>
	<?php endif; ?>

</div>
