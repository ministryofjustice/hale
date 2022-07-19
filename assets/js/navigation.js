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

jQuery( document ).ready(function( $ ) {
	// We use JS to add a span that is used to tap on (mobile only) to shew the sub-menu, and is hidden by CSS on Desktop.

	$( "#menu-menu-top-menu li.menu-item-has-children > a" ).append(
		"<span tabindex='0' class='hale-header__dropdown-arrow'></span>"
	);

	//Keyboard functionailty (requires mouse functionality)
	$("#menu-menu-top-menu li.menu-item-has-children > a").keydown(function(e){

		let openCloseControl = $(this).find(".hale-header__dropdown-arrow");

		if (openCloseControl.is(":visible")) {
			if (e.keyCode == "32") {
				e.preventDefault();
				openCloseControl.click();
			}
			if (e.keyCode == "40") {
				if (!$(this).parent().hasClass('sub-menu-open')) {
					e.preventDefault();
					openCloseControl.click();
				}
			}
			if (e.keyCode == "38") {
				if ($(this).parent().hasClass('sub-menu-open')) {
					e.preventDefault();
					openCloseControl.click();
				}
			}
		}
	});

	//Mouse functionality
	$( "#menu-menu-top-menu li.menu-item-has-children > a > .hale-header__dropdown-arrow" ).click(function( event ) {

		event.preventDefault();

		let menuItem = $(this).parent().parent();

		$(".hale-header__dropdown-arrow").css("height","");

		if (menuItem.hasClass('sub-menu-open')) {
			menuItem.removeClass("sub-menu-open");
		} else {
			$("#menu-menu-top-menu li.menu-item-has-children").removeClass("sub-menu-open");
			menuItem.addClass("sub-menu-open");
			let numberOfMenuItems = menuItem.find(".sub-menu > li").length + 1; // gets the number of menu options including the main link
			$(this).height("calc("+numberOfMenuItems+" * (100% + 5px) )");
		}
	}).keydown(function(e){
		if (e.keyCode == "13") $(this).click();
	});
});
