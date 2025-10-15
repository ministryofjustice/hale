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

	$mobileSubMenuButton.insertBefore("#menu-menu-top-menu li.menu-item-has-children > ul.sub-menu");

	//Keyboard functionailty (main nav - arrow navigation)
	$(".menu-item>a,.menu-item--more>.menu-item__more").keydown(function(e) {

		let list = $(this).parents("ul");
		let listItem = $(this).parent();

		//Is this in the more menu
		let inMoreMenu = false;
		if ($(this).closest(".menu-item--more__content").length) inMoreMenu = true;

		//Is this first or last item?
		let isFirstItem = false;
		let isLastItem = false;
		if(listItem.is(list.children().first())) isFirstItem = true;
		if(listItem.is(list.children().last()) || $(this).hasClass("menu-item__more")) isLastItem = true;
		
		//Is this item or the previous item a dropdown?
		let dropdown = false;
		let prevDropdown = false;
		if (listItem.is(".menu-item-has-children")) dropdown = true;
		if (!isFirstItem && listItem.prev().is(".menu-item-has-children")) prevDropdown = true;
		if (isFirstItem && list.children().last().is(".menu-item-has-children")) prevDropdown = true;
		if (isFirstItem && list.children("menu-item--more").length > 0) prevDropdown = false; //the more button

		//Next items
		let next;
		if (dropdown) {
			next = $(this).next(); //go to the dropdown control
		} else if (isLastItem) {
			next = list.children().first().find("a"); //last in list: go to the main link of the first item
		} else {
			next = listItem.next().find("a"); //go to the main link of the next item
			if (next.length > 1) {
				// This will happen if the More button is displayed, hiding several links
				next = listItem.next().find(".menu-item__more"); //go to the more block
			}
		}
		//Previous items
		let prev;
		if (isFirstItem && prevDropdown) {
			prev = list.children().find(".menu-item__more"); //go to the more block
			if (prev.length == 0) {
				prev = list.children().last().find(".hale-header__dropdown-arrow"); //the dropdown control of the last item in the list
			}
		} else if (prevDropdown) {
			prev = listItem.prev().find(".hale-header__dropdown-arrow"); //the dropdown control of the previos item
		} else if (isFirstItem) {
			prev = list.children().find(".menu-item__more"); //go to the more block
			if (prev.length == 0) {
				prev = list.children().last().find("a"); //go to the main link of the last item in the list
			}
		} else {
			prev = listItem.prev().find("a"); //go to the main link of the previous item
		}

		let up = prev;
		let down = next;

		if (inMoreMenu) {
			let more_top = $(this).closest(".menu-item--more__content > li");
			let more_sub_menu = $(this).closest(".sub-menu");
			let more_parent = $(this).parent();
			let isLast = more_top.is(":nth-child(3n),:last-child");
			let isFirst = more_top.is(":nth-child(3n-2),:first-child");
console.log(more_top);
console.log(more_sub_menu);			
console.log(more_parent);		
console.log(isFirst);
console.log(isLast);			
			if (!more_sub_menu.length) {
				// top level
				prev = more_parent.prev().children("a");
				next = more_parent.next().children("a");
				if (isFirst) {
					prev = more_parent.next().next().children("a"); //last on same row
				} else if (isLast) {
					next = more_parent.prev().prev().children("a"); //last on same row
				}
				if (dropdown) {
					down = $(this).siblings(".sub-menu").children().first().find("a");
				} else {
					down = more_parent.next().next().next().children("a"); // next in column
					// down at bottom does nothing
				}
				if ($(this).is(":nth-child(-n+3)")) {
					up = $(".menu-item__more"); //top row, return to more button
				} else {
					up = more_parent.prev().prev().prev().find("a"); //go to 3 earlier - directly above
				}
			} else {
				// second level
				let more_sub_menu_position = more_parent.prevAll().length + 1;
				prev = more_top.prev().children(".sub-menu").find("a:nth-child("+more_sub_menu_position+")");
				next = more_top.next().children(".sub-menu").find("a:nth-child("+more_sub_menu_position+")");
console.log(more_top.prev().children(".sub-menu").children().eq(more_sub_menu_position).children("a"));
				if (isFirst) {
					prev = more_top.next().next().children(".sub-menu").children(":last-child").children("a"); //fallback in case next doesn't exist
					prev = more_top.next().next().children(".sub-menu").children().eq(more_sub_menu_position).children("a");
				}
				if (isLast) {
					next = more_top.prev().prev().children(".sub-menu").children(":last-child").children("a"); //fallback in case next doesn't exist
					next = more_top.prev().prev().children(".sub-menu").children().eq(more_sub_menu_position).children("a");
				}
				if (isLastItem) {
					down = more_sub_menu.closest("menu-item").next().next().next().children("a"); // top level directly below
				} else {
					down = more_parent.next().children("a");
				}
				if (isFirstItem) {
					up = more_sub_menu.siblings("a"); //first level parent
				} else {
					up = more_parent.prev().children("a");
				}
			}
		}

		if (e.keyCode == "39") { // right arrow - focus on dropdown control or next item
			e.preventDefault();
			next.focus();
		}
		if (e.keyCode == "40") { // down arrow - focus on dropdown control or next item or open more links
			e.preventDefault();
			if ($(this).parent().hasClass("menu-item--more")) {
				if ($(this).parent().hasClass("menu-item--more--open")) {
					// We focus on the 3rd top level element in the more menu which
					// should be directly below the more button itself, falling back to
					// the first and second
					$(".menu-item--more__content").children(":nth-child(1)").children("a").focus();
					$(".menu-item--more__content").children(":nth-child(2)").children("a").focus();
					$(".menu-item--more__content").children(":nth-child(3)").children("a").focus();
				} else {
					$(this).click(); //opens more menu
				}
			} else {
				down.focus();
			}
		}
		if (e.keyCode == "37") { // left/up arrow - focus on previous main link or dropdown control
			e.preventDefault();
			prev.focus();
		}
		if (e.keyCode == "38") { // left/up arrow - focus on previous main link or dropdown control
			e.preventDefault();
			if ($(this).parent().hasClass("menu-item--more") && $(this).parent().hasClass("menu-item--more--open")) {
				$(this).click(); //closes more menu
			} else {
				up.focus();
			}
		}
	});

	//Keyboard functionailty (requires mouse functionality)
	$(".hale-header__dropdown-arrow").keydown(function(e){

		let openCloseControl = $(this);

		if (openCloseControl.is(":visible")) {
			if (e.keyCode == "13") { // return
				openCloseControl.click();
			}
			if (e.keyCode == "40") { // down arrow
				if (!$(this).parent().hasClass('sub-menu-open')) {
					e.preventDefault();
					openCloseControl.click();
				} else {
					e.preventDefault();
					$(this).siblings(".sub-menu").find("li:first-child a").focus();
				}
			}
			if (e.keyCode == "38") { // up arrow
				if ($(this).parent().hasClass('sub-menu-open')) {
					e.preventDefault();
					openCloseControl.click();
				} else {
					$(this).prev().focus();
				}
			}
			if (e.keyCode == "37") { // left arrow - focus on main link
				$(this).prev().focus();
			}
			if (e.keyCode == "39") { // right arrow - focus on next main link or first item
				if ($(this).parents(".menu-item").is($(this).parents("ul").children().last())) {
					$(this).parents("ul").children().first().find("a").focus();
				} else {
					$(this).parent().next().find("a").focus();
				}
			}
		}
	});
	$(".hale-header__dropdown-arrow").next().find("a").keydown(function(e){
		// Keyboard functionality for when within the submenu.
		// Esc key closes menu (whist focussed) - separate code for when not focussed
		// Arrow keys navigate up and down menu
		let listItemLink = $(this);
		let listItem = $(this).parent();
		let list = $(this).parents(".sub-menu");
		let control = list.siblings(".hale-header__dropdown-arrow");
		let mainNavItem = list.parents(".menu-item");
		let mainNavFirstItem = list.parents("ul").children().first();
		let mainNavLastItem = list.parents("ul").children().last();

		if (listItemLink.is(":visible")) {
			if (e.keyCode == "27") { // escape key
				e.preventDefault();
				control.click(); //closes sub-menu
				control.focus(); //focuses on sub-menu control
			}
			if (e.keyCode == "39" || e.keyCode == "40") { // right or down arrow
				if (!list.children().last().is(listItem)) {
					e.preventDefault();
					listItem.next().find("a").focus();
				} else {
					e.preventDefault();
					control.click(); //closes sub-menu
					list.parent().next().find("a").focus(); //focuses on next main nav item
					if (mainNavItem.is(mainNavLastItem)) {
						mainNavFirstItem.find("a").focus();
					}
				}
			}
			if (e.keyCode == "37" || e.keyCode == "38") { // left or up arrow
				e.preventDefault();
				if (!list.children().first().is(listItem)) {
					listItem.prev().find("a").focus();
				} else {
					control.focus();
				}
			}

		}
	});
	// If escape key is pressed anywhere on the page and a submenu is open - it gets shut.
	$(document).keydown(function(e) {
		if (e.keyCode == "27") { // escape key
			$(".sub-menu-open").find(".hale-header__dropdown-arrow").click();
			$(".menu-item--more--open").find("button").click();
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

/**
 *
 * Table of contents "scrollspy", highlight current scroll location
 *
 */

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
	for (i=0; i+1<sectionHeadings.length; i++) {
		let nextPosition = sectionHeadings[i+1].getBoundingClientRect().top;
		if (nextPosition > 150) break; //we stop counting when the next one is above 150 as we are on the current item
	}

	// A small bit of code to ensure the last item is always "current" when at the very bottom of the page.
	const documentHeight = Math.max(
		document.body.scrollHeight,
		document.body.offsetHeight,
		document.documentElement.clientHeight,
		document.documentElement.scrollHeight,
		document.documentElement.offsetHeight
	);
	const windowHeight = window.innerHeight;
	const maxScroll = documentHeight - windowHeight;

	if (window.scrollY >= maxScroll) i = sectionHeadings.length - 1;

	// We set the "current" class as per the current location
	contents.forEach(item => {
		item.classList.remove("hale-table-of-contents__item--current");
	});
	contents[i].classList.add("hale-table-of-contents__item--current");
}
