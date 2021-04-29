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
