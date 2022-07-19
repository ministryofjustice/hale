( function() {
	if (document.querySelector(".govuk-accordion") !== null) {

		//A bit of JS to ensure that all Accordion headings and content IDs are unique
		let haleAllAccordionHeadings = document.querySelectorAll("#accordion-default-heading-1");
		let haleAllAccordionContentArray = document.querySelectorAll("#accordion-default-content-1");

		//if the number of accordions and headings is greater than one and equal to the number of contents
		if (haleAllAccordionHeadings.length && haleAllAccordionHeadings.length == haleAllAccordionContentArray.length) {
			for (i=0;i<haleAllAccordionHeadings.length;i++) {
				// Set ID for heading to be unique
				haleAllAccordionHeadings[i].id = "hale-accordion-heading-" + (i+1);
				// Set ID for content to be unique
				haleAllAccordionContentArray[i].id = "hale-accordion-content-" + (i+1);
				// Set the Aria controls to be the same as the (new) content ID
				// This was the only thing being incremented by PHP, but was still insufficient for many accordions per page
				haleAllAccordionHeadings[i].closest(".govuk-accordion__section-button").setAttribute("aria-controls", "hale-accordion-content-" + (i+1));
				// Set the content Aria label to the (new) heading ID
				haleAllAccordionContentArray[i].setAttribute("aria-labelledby", "hale-accordion-heading-" + (i+1));
			}
		}

		// Now we open the accordion section if the section is linked to directly
		// Remember that accordions remember their state so this might result in two+ sections being open
		haleAccordionDirectID();
	}
})();

function haleAccordionDirectID() {
	if (window.location.href.split("#").length == 2) {
		
		// Split the string and get the ID
		const halePageRequestedID = window.location.href.split("#")[1];

		// Check for the requested ID within the accordion
		// We already know that an accordion exists on the page when this function is called
		if (document.querySelector(".govuk-accordion__section #" + halePageRequestedID) !== null) {

			const haleRequiredSection = document.getElementById(halePageRequestedID).closest(".govuk-accordion__section");
			haleRequiredSection.classList.add("govuk-accordion__section--expanded");

			// If the rest of the JS has (for some reason) already run, we need to do the things it would usually deal with
			// This probably won't be needed, but included as a catchall
			if (document.getElementById(halePageRequestedID).querySelector("button") !== null) {
				const haleAccordionButton = haleRequiredSection.querySelector("button");
				const haleAccordionChevron = haleRequiredSection.querySelector(".govuk-accordion-nav__chevron"); 
				const haleShowHideControl = haleRequiredSection.querySelector(".govuk-accordion__section-toggle-text");
				haleAccordionButton.setAttribute("aria-expanded", "true");
				haleAccordionChevron.classList.remove("govuk-accordion-nav__chevron--down");
				haleShowHideControl.innerHTML = haleShowHideControl.innerHTML.replace('Show', 'Hide');
			}
			haleRequiredSection.scrollIntoView();
		}
	}
}
