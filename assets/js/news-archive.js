jQuery( document ).ready(function( $ ) {

  $('#news-archive-filter-topic').on('change', function() {

    resetSubTopics();

    var selected_topic = this.value;

    if(this.value  > 0) {

      var found_subtopics = 0;

      $.each( news_archive_object.categories , function( key, category ) {

        if(category.parent == selected_topic) {
          $("#news-archive-filter-subtopic").append(new Option(category.name, category.term_id));
          found_subtopics++;
        }

        if(found_subtopics > 0){
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
