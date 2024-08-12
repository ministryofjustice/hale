jQuery(document).ready(function ($) {

  const taxonomies = listing_page_object.taxonomies;

  // Function to handle changes in the parent topic dropdown
  function handleTopicChange(parentClass, childClass, selected_topic) {
    if (selected_topic > 0) {
      const termsWithParents = getTermsWithMatchingParents(selected_topic);

      // Update based on whether any matching subtopics were found
      if (termsWithParents.length > 0) {
        populateSubTopics(childClass, termsWithParents);
        $(childClass).prop('disabled', false);
      } else {
        resetSubTopics(childClass);
      }
    } else {
      resetSubTopics(childClass);
    }

    // Function to find terms with parents matching the selected topic
    function getTermsWithMatchingParents(selected_topic) {
      const termsWithParents = [];

      // Loop through each taxonomy and its terms
      Object.keys(taxonomies).forEach(taxonomy => {
        taxonomies[taxonomy].forEach(termData => {
          if (termData.parent && termData.parent == selected_topic) {
            termsWithParents.push(termData);
          }
        });
      });

      return termsWithParents;
    }

    // Populate subtopics dropdown with matching terms
    function populateSubTopics(childClass, termsWithParents) {
      resetSubTopics(childClass);

      termsWithParents.forEach(term => {
        $(childClass).append(new Option(term.name, term.term_id));
      });
    }

    // Reset the subtopics dropdown
    function resetSubTopics(childClass) {
      $(childClass).empty();
      $(childClass).append(new Option("All subtopics", ""));
      $(childClass).prop('disabled', 'disabled'); // Disable the dropdown by default
    }

    // Attach change event listeners to each parent topic dropdown
    Object.keys(taxonomies).forEach(taxonomy => {
      const parentClass = `#${taxonomy}-filter-topic`;
      const childClass = `#${taxonomy}-filter-subtopic`;

      $(parentClass).on('change', function () {
        const selected_topic = this.value;
        handleTopicChange(parentClass, childClass, selected_topic);
      });
    });
  }
});
