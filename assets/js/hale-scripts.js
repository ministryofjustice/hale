/*
	hale script v1.0.0
*/

/*
	Search button in header - show-hide the search field
*/
if( document.getElementById("search-show-hide") != null) {
  document.getElementById("search-show-hide").addEventListener('click',
    function () {
      var ariaExpandedStatus = this.getAttribute("aria-expanded");
      ariaExpandedStatus = ariaExpandedStatus == "true" ? "false" : "true";
      this.setAttribute("aria-expanded", ariaExpandedStatus);
    }
  );
}

jQuery( document ).ready(function( $ ) {

  //Keeps the Quick Exit Button at top of page once scrolled past the buttons original position in header
  $(window).on('scroll resize', function() {
    var stickyDiv = $('.govuk-exit-this-page');
    var stickyButton = $('.govuk-exit-this-page a');

    if (stickyDiv.length) {

      //Keeps the surrounding Div the same width and height even when the button is fixed position. As this is used to work out the buttons left pos.
      var divMinHeight = stickyButton.outerHeight();
      var divMinWidth = stickyButton.outerWidth();

      if ($(".hale-header__mobile-controls--search").is(":visible")) {
        divMinWidth = 0
      }

      stickyDiv.css({
        "min-height": divMinHeight,
        "min-width": divMinWidth
       });

      var stickyDivTop = stickyDiv.offset().top;
      var stickyDivLeft = stickyDiv.offset().left;

      if ($(window).scrollTop() >= stickyDivTop) {
        stickyDiv.addClass('sticky');

        $('.govuk-exit-this-page a').css({
            "left": stickyDivLeft
        });

      } else {
        stickyDiv.removeClass('sticky');
      
        $('.govuk-exit-this-page a').css({
            "left": 'initial'
        });
      }

      //If on mobile the sticky button should be full screen and to the left
      if ($(".hale-header__mobile-controls--search").is(":visible")) {
        $('.govuk-exit-this-page a').css({
          "left": 0
        });
      }
    }
  });

});
