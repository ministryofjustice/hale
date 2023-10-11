/**
 * File close-button.js.
 *
 * Adds a close button and its functionality.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	const banner = document.getElementById("critical-info-banner");
	if (banner != null) {
		const closeButton = document.createElement("a");
		const node = document.createTextNode("×");
		closeButton.appendChild(node);
		closeButton.setAttribute("class","hale-notification-banner__close govuk-link");
		closeButton.setAttribute("href","#");
		
		closeButton.onclick = function() {
			banner.style.display = "none";
		}

		banner.querySelector("#critical-info-banner-title").prepend(closeButton);
	}
})();
