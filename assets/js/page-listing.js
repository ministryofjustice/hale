jQuery(document).ready(function ($) {

  $('#news-archive-filter-topic').on('change', function () {

    resetSubTopics();

    var selected_topic = this.value;

    if (this.value > 0) {

      var found_subtopics = 0;

      listing_page_object.taxonomies.genre.forEach(function (tax) {
        if (tax.parent == selected_topic) {
          $("#news-archive-filter-subtopic").append(new Option(tax.name, tax.term_id));
          found_subtopics++;
        }

        if (found_subtopics > 0) {
          $('#news-archive-filter-subtopic').prop('disabled', false);
        }
        else {
          $('#news-archive-filter-subtopic').prop('disabled', 'disabled');
        }
      });
    }
    else {
      $('#news-archive-filter-subtopic').prop('disabled', 'disabled');
    }

  });

  function resetSubTopics() {
    $('#news-archive-filter-subtopic').empty();
    $("#news-archive-filter-subtopic").append(new Option("All Sub-topics", "0"));
  }
});
