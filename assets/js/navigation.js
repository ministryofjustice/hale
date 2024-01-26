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
 * Function to make a megamenu with clickable titles that expand blocks underneath. Its pretty awesome.
 * @param id - the name of the div to display on clicking the link.
 */
function guideNavClick(id) {
	var others, i;
	others = document.getElementsByClassName( "guides-nav__contents" );
	event.preventDefault();
	for (i = 0; i < others.length; i++) {
		others[i].style.display = "none";
	}
	var currentState = document.getElementById(id).style.display;
	if ( currentState == "block" ) {
		document.getElementById(id).style.display = "none";
	} else {
		document.getElementById(id).style.display = "block";
	}
}

function navBarOptimization() {

	const headerNav = document.getElementById("menu-menu-top-menu");
	const nav = document.querySelectorAll("#menu-menu-top-menu>li.menu-item");
	const navMaxWidth = headerNav.getBoundingClientRect()["width"] - 90; //90px to allow space for the More button
	let allMenuItemsWidth = 0;
	
	if (window.getComputedStyle(document.querySelector(".govuk-header__menu-button")).display == "none") {
		// the menu button is hidden = not mobile view
		if (document.getElementById("more-link") != null) document.getElementById("more-link").remove();
		for (i=0;i<nav.length;i++) {
			let thisMenuItemWidth = nav[i].getBoundingClientRect()["width"];
			allMenuItemsWidth += thisMenuItemWidth;
			if (allMenuItemsWidth > navMaxWidth) {
				let moreLink = document.createElement("li");
				moreLink.innerHTML = '<button>More</button><ul class="menu-item--more__content"></ul>';
				moreLink.setAttribute("id","more-link");
				moreLink.classList.add("menu-item");
				moreLink.classList.add("menu-item--more");
				moreLink.querySelector("button").classList.add("menu-item__more");
				moreLink.querySelector("button").setAttribute("aria-expanded","false");
				headerNav.insertBefore(moreLink,nav[i]);
				break; // Loop continues below
			}
		}
		
		const moreContainer = headerNav.querySelector("#more-link");
		const moreButton = moreContainer.querySelector("button");
		const moreLinks = moreContainer.querySelector(".menu-item--more__content");
		if (moreButton) {
			
			// Move all overflow elements inside the more button
			for (;i<nav.length;i++) {
				// continued from above
				let clonedNode = nav[i].cloneNode(true);
				moreLinks.appendChild(clonedNode);
			//	clonedNode.querySelector("sub-menu").classList.replace("sub-menu","menu-item__sub-menu");
			}
			
			
			// Add click functionality to the more button
			moreButton.addEventListener("click", (event) => {
				console.log("Clicked");
				let parent = moreButton.parentElement;
				console.log(parent);

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
		} else {
			console.log("xxx");
		}

	}
	/*

	***	Method 1 - adjusting the widths to deal with wrapped menu items

	if(nav[0].getBoundingClientRect()["height"] > 50 && window.getComputedStyle(document.querySelector(".govuk-header__menu-button")).display == "none") {
		// The text in the menu has wrapped, so we perform a little jiggery-pokery with the widths

		// Convert to array and sort (so longest option is first to be broken)
		var navArray = Array.prototype.slice.call(nav, 0);
		navArray.sort(function(b, a){return a.innerText.length - b.innerText.length});

		for (i=0;i<navArray.length;i++) {
			if(navArray[i].innerText.split(" ").length == 1) navArray.splice(i, 1);
		}
		for (i=0;i<navArray.length;i++) {
			console.log(navArray[i].innerText);
		}
		for (i=0;i<navArray.length;i++) {
			navArray[i].style.width = null;
			let textWidth = Math.ceil(navArray[i].querySelector("span").getBoundingClientRect()["width"]);
			let itemLeftPadding = window.getComputedStyle(navArray[i]).getPropertyValue('padding-left');
			let itemRightPadding = window.getComputedStyle(navArray[i]).getPropertyValue('padding-right');
			navArray[i].style.width = "calc(" + itemLeftPadding + " + " + itemRightPadding + " + " + textWidth + "px)";
		}
	} else {
		for (i=0;i<nav.length;i++) {
			nav[i].style.width = null;
		}
	}
	*/
}

jQuery("#menu-menu-top-menu").ready(function( $ ) {
	navBarOptimization();
	$(window).resize(function() {
		navBarOptimization();
	});
});

jQuery("#menu-menu-top-menu li.menu-item-has-children > ul.sub-menu").ready(function( $ ) {
	// We use JS to add a span that is used to tap on (mobile only) to shew the sub-menu, and is hidden by CSS on Desktop.
	$(
		"<button class='hale-header__dropdown-arrow' aria-expanded='false'><span class='govuk-visually-hidden'>Show submenu</span></button>"
	).insertBefore("#menu-menu-top-menu li.menu-item-has-children > ul.sub-menu");
	$(
		"<button class='hale-header__dropdown-arrow hale-header__dropdown-arrow--desktop' aria-expanded='false'><span class='govuk-visually-hidden'>Show submenu</span></button>"
	).insertBefore("#menu-menu-top-menu li.menu-item-has-children > a");

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
