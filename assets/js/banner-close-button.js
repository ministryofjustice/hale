/**
 * File close-button.js.
 *
 * Adds close button functionality.
 * Hides info banner if cookie says it has been closed.
 */
(function() {
	const banner = document.getElementById("critical-info-banner");
	if (banner != null) {
		const closeButton = document.getElementById("critical-info-banner-close-button");
		closeButton.style.display = "inline";

		closeButton.onclick = function(e) {
			e.preventDefault()
			document.cookie = "info_banner_dismissed="+bannerText; //creates an essential cookie so the message isn't displayed again.  No expiry, will die when browser is closed.
			banner.style.display = "none";
		}

		const bannerText = document.getElementById("critical-info-banner-content").innerText.replace(/[^\w]/gi, '');
		let cookieString = decodeURIComponent(document.cookie);
		let bannerDismissed = false;
		if (cookieString.indexOf(bannerText) >= 0) bannerDismissed = true; // No match = banner not dismissed this time

		if (!bannerDismissed) {
			// No record of banner being dismissed, so we shew it
			banner.style.display = "block";
		}
	}
})();

var MOJFrontend = {};