/**
 * File close-button.js.
 *
 * Adds a close button and its functionality.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	const banner = document.getElementById("critical-info-banner");
	const bannerText = banner.innerText;

	let cookieString = decodeURIComponent(document.cookie);
	let bannerDismissed = false;
	if (cookieString.indexOf(bannerText) !== false) bannerDismissed = true; //if the cookie is set and has the same text as the banner, we know this banner has been dismissed

	if (banner != null && !bannerDismissed) {
		banner.style.display = "block";
		const closeButton = banner.getElementById("critical-info-banner-close-button");
		
		closeButton.onclick = function(e) {
			e.preventDefault()
			document.cookie = "infobanner="+bannerText; //creates an essential cookie so the message isn't displayed again.  No expiry, will die when browser is closed.
			banner.style.display = "none";
		}
	}
})();
