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


  /*
  function fleeFromPage(fleeMethod) {
    $("body").hide();
    window.open("http://bbc.co.uk/weather", "_newtab");
    window.location.replace("http://www.google.co.uk");   
  }

  $("a.govuk-exit-this-page__button").on("click", function(e) {
    e.preventDefault();
    e.stopPropagation();
    fleeFromPage("mouse click");
  });
  $(document).keyup(function(e) {
    if (e.keyCode == 27) { // 27 = escape key
      fleeFromPage("escape key");
    }
  });*/

  $(window).on('scroll resize', function() {
    var stickyDiv = $('.govuk-exit-this-page');
    var stickyButton = $('.govuk-exit-this-page a');

    if (stickyDiv.length) {

      var divMinHeight = stickyButton.outerHeight();
      var divMinWidth = stickyButton.outerWidth();

      if ($(".hale-header__mobile-controls--search").is(":visible")) {
        //divMinHeight = 'initial';
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

      if ($(".hale-header__mobile-controls--search").is(":visible")) {
        $('.govuk-exit-this-page a').css({
          "left": 0
        });
      }
    }
  });

});
