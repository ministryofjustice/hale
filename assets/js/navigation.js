/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

( function() {

	const searchToggleButton = document.getElementById('toggle-search');
	const menuToggleButton = document.getElementById('toggle-menu');

	if (searchToggleButton != null) {
    searchToggleButton.onclick = function () {
      if (searchToggleButton.getAttribute("aria-expanded") === "false") {
        searchToggleButton.setAttribute("aria-label", "Close search");
      } else {
        searchToggleButton.setAttribute("aria-label", "Open search");
      }
    }
  }

  if (menuToggleButton != null) {
    menuToggleButton.onclick = function () {
      if (menuToggleButton.getAttribute("aria-expanded") === "false") {
        menuToggleButton.setAttribute("aria-label", "Close menu");
      } else {
        menuToggleButton.setAttribute("aria-label", "Open menu");
      }
    }
  }

	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );

} )();

/**
 * navBarOptimization
 * Creates the more button and puts any overflow items into it.
 * Called (below) when page loads and when page is resized (including when mobile rotated)
 */

function navBarOptimization() {

	const moreText = document.getElementById("header-navigation").getAttribute("data-more-text");
	if (moreText == "None") return;
	const moreTextWidth = moreText.length;
	const headerNav = document.getElementById("menu-menu-top-menu");
	if (!headerNav) return;
	const nav = document.querySelectorAll("#menu-menu-top-menu>li.menu-item");
	if (!nav || nav.length === 0) return;
	const navMaxWidth = headerNav.getBoundingClientRect()["width"];
	const navMaxWidthWithMore = navMaxWidth - (moreTextWidth * 16 + 25);
	// about 90px to allow space for the More button
	// Assume 1 letter ≈ 1em = 16px, so 4 letters ≈ 4em = 64px, add 25 to give 89px for "More"
	// For welsh "Mwy", 3em = 48px, add 25px gives 73px.

	let allMenuItemsWidth = 0;

	const isMoreButtonDisabled = window.getComputedStyle(document.querySelector(".govuk-header__menu-button")).display === "none";

	if (isMoreButtonDisabled) {
		// the menu button is hidden = not mobile view

		const existingMoreLink = document.getElementById("more-link");
		if (existingMoreLink) existingMoreLink.remove();

		for (var i = 0; i < nav.length; i++) {
			const thisMenuItemWidth = nav[i].getBoundingClientRect().width;
			allMenuItemsWidth += thisMenuItemWidth;

			if (
				allMenuItemsWidth > navMaxWidth ||
				( allMenuItemsWidth > navMaxWidthWithMore && i < nav.length - 1)
			) {
				const moreLink = document.createElement("li");
				moreLink.innerHTML = '<button>'+ moreText +'</button><ul class="menu-item--more__content"></ul>';
				moreLink.setAttribute("id","more-link");
				moreLink.classList.add("menu-item", "menu-item--more");

				const moreButton = moreLink.querySelector("button");
				moreButton.classList.add("menu-item__more");
				moreButton.setAttribute("aria-expanded","false");

				headerNav.insertBefore(moreLink,nav[i]);
				break; // Loop continues below
			}
		}

		var moreContainer = headerNav.querySelector("#more-link");
		if (moreContainer) {
			var moreButton = moreContainer.querySelector("button");
			var moreLinks = moreContainer.querySelector(".menu-item--more__content");
		}
		if (moreButton) {
			
			// Move all overflow elements inside the more button
			for (/* i value from above */;i<nav.length;i++) {
				// continued from above
				let clonedNode = nav[i].cloneNode(true);
				moreLinks.appendChild(clonedNode);
			}

			if (moreLinks.innerHTML.indexOf("current-menu-item") > 0) {
				// If the more links contains "current-menu-item" - style it to be an ancestor
				moreButton.classList.add("menu-item__more--contains-current");
			}

			// Add click functionality to the more button
			moreButton.addEventListener("click", (event) => {
				let parent = moreButton.parentElement;

				if (parent.classList.contains('menu-item--more--open')) {
					parent.classList.remove("menu-item--more--open");
					moreButton.setAttribute("aria-expanded","false");
				} else {
					// We close all open menus and remove the aria-expanded true value
					headerNav.querySelectorAll("#menu-menu-top-menu li.sub-menu-open").forEach(element => {
						element.classList.remove("sub-menu-open");
						element.querySelectorAll("button").forEach(e => {
							e.setAttribute("aria-expanded","false");
						});
					});
					parent.classList.add("menu-item--more--open");
					moreButton.setAttribute("aria-expanded","true");
				}
			});
		}
	} else {
		// If the width is less than desktop, we make sure we remove the more link should it have been created
		// This might happen with a mobile device being rotated
		if (document.getElementById("more-link") != null) document.getElementById("more-link").remove();
	}
}

document.addEventListener('click', function(e) {
	// Function to close the More menu if user clicks outside of it.
	let target = e.target;
	if (target.closest(".menu-item--more--open") == null && document.querySelector(".menu-item--more--open") != null) {
		document.querySelector(".menu-item__more").click();
	}
}, false);

document.addEventListener('mouseover', function(e) {
	// Function to close the More menu if user hovers over another menu item.
	let target = e.target;
	if (target.closest(".menu-item-has-children") != null && target.closest(".menu-item--more") == null && document.querySelector(".menu-item--more--open") != null) {
		document.querySelector(".menu-item__more").click();
	}
}, false);

jQuery("#menu-menu-top-menu").ready(function( $ ) {
	navBarOptimization();
	$(window).resize(function() {
		navBarOptimization();
	});
});

jQuery("#menu-menu-top-menu li.menu-item-has-children > ul.sub-menu").ready(function( $ ) {
	// We use JS to add a span that is used to tap on (mobile only) to shew the sub-menu, and is hidden by CSS on Desktop.

	const $mobileSubMenuButton = $('<button class="hale-header__dropdown-arrow" aria-expanded="false"><span class="govuk-visually-hidden">Show submenu</span></button>');
	const $desktopSubMenuButton = $('<button class="hale-header__dropdown-arrow hale-header__dropdown-arrow--desktop" aria-expanded="false"><span class="govuk-visually-hidden">Show submenu</span></button>');

	$mobileSubMenuButton.insertBefore("#menu-menu-top-menu li.menu-item-has-children > ul.sub-menu");
	$desktopSubMenuButton.insertBefore("#menu-menu-top-menu li.menu-item-has-children > a");

	//Keyboard functionailty (requires mouse functionality)
	$(".hale-header__dropdown-arrow").keydown(function(e){

		let openCloseControl = $(this);

		if (openCloseControl.is(":visible")) {
			if (e.keyCode == "32") { // space
				e.preventDefault();
				openCloseControl.click();
			}
			if (e.keyCode == "13") { // return
				openCloseControl.click();
			}
			if (e.keyCode == "40") { // down arrow
				if (!$(this).parent().hasClass('sub-menu-open')) {
					openCloseControl.click();
				}
			}
			if (e.keyCode == "38") { // up arrow
				if ($(this).parent().hasClass('sub-menu-open')) {
					openCloseControl.click();
				}
			}
		}
	});

	//Mouse functionality
	$( ".hale-header__dropdown-arrow" ).click(function( event ) {

		event.preventDefault();

		let menuItem = $(this).parent();

		$(".hale-header__dropdown-arrow").css("height","");

		if (menuItem.hasClass('sub-menu-open')) {
			menuItem.removeClass("sub-menu-open");
			menuItem.find(".hale-header__dropdown-arrow").attr("aria-expanded","false");
		} else {
			$("#menu-menu-top-menu li.menu-item-has-children").removeClass("sub-menu-open");
			menuItem.addClass("sub-menu-open");
			menuItem.find(".hale-header__dropdown-arrow").attr("aria-expanded","true");
		}
	}).keydown(function(e){
		if (e.keyCode == "13") $(this).click();
	});
});

( function() {
	indicateCurrentLocation();
})();

document.addEventListener('scroll', function() {
	indicateCurrentLocation();
}, false);

function indicateCurrentLocation(){
	if (!document.querySelector("#toc")) return;
	let toc = document.querySelector("#table-of-contents");
	let sectionHeadings = document.querySelectorAll(".hale-toc-item");
	let contents = toc.querySelectorAll("li");
	for (i=0; i<=sectionHeadings.length; i++) { // <= because if we are last, we don't need to test
		let position = sectionHeadings[i].getBoundingClientRect().top; // TEST THIS!!!
		if (position > 0) break; //we stop counting when one is above zero as that is in the future.
	}
	contents.forEach(item => {
		item.classList.remove("hale-table-of-contents__current-item");
	});
	contents[i].classList.add("hale-table-of-contents__current-item");
}
