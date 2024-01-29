( function() {
	markDarkBackground();
})();

function markDarkBackground(){
	let customBackgroundElements = document.querySelectorAll(".has-background"); // gets all the elements with a set background
	for (let i = 0; i<customBackgroundElements.length; i++) {
		let colourValue = getComputedStyle(customBackgroundElements[i]).backgroundColor.replace("rgb(", "").replace(")", "");; // should return an RGB value
		let array = colourValue.split(", ");
		if (array.length != 3) continue; // if for whatever reason we don't have an array length of 3 then we don't have an RGB value
		luma = 0.2126 * array[0] + 0.7152 * array[1] + 0.0722 * array[2]; // per ITU-R BT.709 apparently - I just found this online
		if (luma < 128) {
			customBackgroundElements[i].classList.add("hale-dark-background");
		} else {
			customBackgroundElements[i].classList.add("hale-light-background");
		}
	}

}
