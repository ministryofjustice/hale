/**
 * File side-nav.js.
 *
 * Handles toggling the side-nav menu for small screens
 */

jQuery("#side-nav-button").ready(function() {
	const sideNavToggleButton = document.getElementById('side-nav-button');
	const overlay = document.getElementById('overlay');
	if (sideNavToggleButton != null) {
		sideNavToggleButton.onclick = function () {
			if (sideNavToggleButton.getAttribute("aria-expanded") === "false") {
				sideNavToggleButton.setAttribute( 'aria-expanded', 'true' );
				sideNavToggleButton.setAttribute("aria-label", "Close chapter navigation");
				overlay.classList.add("overlay--active");
			} else {
				sideNavToggleButton.setAttribute( 'aria-expanded', 'false' );
				sideNavToggleButton.setAttribute("aria-label", "Open chapter navigation");
				overlay.classList.remove("overlay--active");
			}
		}
	}
});
