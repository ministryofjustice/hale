//Overrides GOVUK exitPage function so it open in newtab
if (typeof ExitThisPage === 'function') { //check ExitThisPage Class Exists
  ExitThisPage.prototype.exitPage = function() {

    //Loading Overlay copied from govuk
    document.body.classList.add("govuk-exit-this-page-hide-content");
    this.$overlay = document.createElement("div");
    this.$overlay.className = "govuk-exit-this-page-overlay";
    this.$overlay.setAttribute("role", "alert");
    document.body.appendChild(this.$overlay);
    this.$overlay.textContent = this.i18n.t("activated");

    //Functionality to Open in new Tab
    window.open("http://bbc.co.uk/weather", "_newtab");
    window.location.replace("http://www.google.co.uk");  
  };
}