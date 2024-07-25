<?php

foreach($listing_filters as $filter){

    $tax = get_taxonomy($filter);



    if(!empty($tax)){

        $selected_term_id = 0;

        $id = 'listing-search-filter-' . $filter;


        if (get_query_var($filter)) {

            $filter_term_id = get_query_var($filter);
            if (is_numeric($filter_term_id)) {

                $filter_term_id = intval($filter_term_id);

                if (term_exists($filter_term_id, $filter)) {
                    $selected_term_id = $filter_term_id;

                    $listing_active_filters[] = array (
                        'taxonomy' => $filter,
                        'value' =>  $filter_term_id
                    );
                }
            }
        }

        $dropdown_exclude = [];
        $included_terms = [];

        $restrict_field = 'restrict_by_' . $filter;

        $restict_terms = get_field($restrict_field);

        if(!empty($restict_terms) && is_array($restict_terms)) {
            $included_terms = $restict_terms;

            // bring back list of terms that are  not included
            $exclude_terms = get_terms(
                array(
                    'taxonomy' => $filter,
                    'exclude' => $included_terms
                )
            );

            if(!empty($exclude_terms)) {
                foreach($exclude_terms as $term){
                    $dropdown_exclude[] = $term->term_id;
                }
            }
        }





      

        // Fetch all categories
        $all_categories = get_categories(
            array(
                'taxonomy' => $filter,
                'hide_empty' => false,
                'exclude' => $dropdown_exclude,
            )
        );

        // Filter out parent categories and check for children
        $parent_categories = [];
        $categories_with_children = [];

        foreach ($all_categories as $cat) {
            if ($cat->parent == 0) {
                $parent_categories[] = $cat;
                // Check if the category has children
                $child_categories = get_term_children($cat->term_id, $filter);

                if (!empty($child_categories)) {
                    $categories_with_children[$cat->term_id] = get_categories(array('include' => $child_categories, 'taxonomy' => $filter, 'hide_empty' => false));
                }
            }
        }

        // Generate initial dropdown HTML for parent categories
        $parent_category_ids = array_map(function($cat) {
            return $cat->term_id;
        }, $parent_categories);

        $dropdown_html = wp_dropdown_categories(
            array(
                'name' => $filter,
                'id' => $id,
                'class' => 'govuk-select parent-category',
                'taxonomy' => $filter,
                'show_option_all' => 'Select option',
                'orderby' => 'name',
                'echo' => 0,
                'hide_if_empty' => 1,
                'selected' => $selected_term_id,
                'include' => $parent_category_ids // Include only parent categories
            )
        );

        // Output the dropdown HTML
        echo '<label for="' . $id . '">Select Parent Category</label>';
        echo $dropdown_html;


        // Fetch all categories
        $categories = get_terms(array(
            'taxonomy' => $filter,
            'hide_empty' => false,
        ));

        // Prepare categories for JavaScript
        $categories_with_children = array();
        foreach ($categories as $cat) {
            if ($cat->parent > 0) {
                $categories_with_children[$cat->parent][] = array(
                    'term_id' => $cat->term_id,
                    'name' => $cat->name
                );
            }
        }

        // Convert to JSON for JavaScript use
        $categories_json = json_encode($categories_with_children);
        ?>
        
        <input type="hidden" id="categories-with-children" value='<?php echo $categories_json; ?>' />

        <script>
            var categoriesWithChildren = JSON.parse(document.getElementById('categories-with-children').value);
        </script>
        
        
        <div class="news-archive-filter-form">
            <form method="GET">
                <?php for ($i = 1; $i <= 2; $i++) { // Adjust the number of pairs as needed ?>
                    <div class="category-pair">
                        <label class="govuk-label" for="news-archive-filter-topic-<?php echo $i; ?>">Topic <?php echo $i; ?></label>
                        <select id="news-archive-filter-topic-<?php echo $i; ?>" class="govuk-select parent-category">
                            <option value="">Select Topic</option>
                            <?php foreach ($categories as $category) {
                                if ($category->parent == 0) { // Only show parent categories
                                    ?>
                                    <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                                <?php }
                            } ?>
                        </select>
        
                        <label class="govuk-label" for="news-archive-filter-subtopic-<?php echo $i; ?>">Sub-topic <?php echo $i; ?></label>
                        <select name="subtopic_<?php echo $i; ?>" id="news-archive-filter-subtopic-<?php echo $i; ?>" class="govuk-select child-category" disabled="disabled">
                            <option value="0">All Sub-topics</option>
                        </select>
                    </div>
                <?php } ?>
                <button class="govuk-button">Filter</button>
            </form>
        </div>

       

        <script>
document.addEventListener('DOMContentLoaded', function() {
var parentDropdowns = document.querySelectorAll('.parent-category');

parentDropdowns.forEach(function(parentDropdown, index) {
// Generate unique keys for localStorage based on index
var parentKey = `selectedParentCategory_${index}`;
var childKey = `selectedChildCategory_${index}`;

// Load saved parent and child category selections if available
var savedParentCategoryId = localStorage.getItem(parentKey);
var savedChildCategoryId = localStorage.getItem(childKey);

if (savedParentCategoryId) {
parentDropdown.value = savedParentCategoryId;
}

parentDropdown.addEventListener('change', function() {
var selectedCategoryId = this.value;

// Save the selected parent category in localStorage
localStorage.setItem(parentKey, selectedCategoryId);

// Remove any existing child dropdown
var existingChildDropdown = parentDropdown.parentNode.querySelector('.child-category');
if (existingChildDropdown) {
existingChildDropdown.remove();
}

// Remove saved child category in localStorage if parent category changes
localStorage.removeItem(childKey);

// Check if the selected category has children
if (categoriesWithChildren[selectedCategoryId]) {
// Create a new dropdown for child categories
var childDropdown = document.createElement('select');
childDropdown.name = `child_${index}`;
childDropdown.className = 'govuk-select child-category';

// Add an option for selecting a child category
var defaultOption = document.createElement('option');
defaultOption.value = '';
defaultOption.text = 'Select option';
childDropdown.appendChild(defaultOption);

// Add child category options
categoriesWithChildren[selectedCategoryId].forEach(function(childCat) {
var option = document.createElement('option');
option.value = childCat.term_id;
option.text = childCat.name;
childDropdown.appendChild(option);
});

// Append the child dropdown to the form
parentDropdown.parentNode.appendChild(childDropdown);

// Add event listener to save child selection
childDropdown.addEventListener('change', function() {
var selectedChildCategoryId = this.value;
localStorage.setItem(childKey, selectedChildCategoryId);
});

// If a child category was saved, set it as selected
if (savedChildCategoryId) {
childDropdown.value = savedChildCategoryId;
}
}
});

// Trigger change event to load the child dropdown if parent selection was saved
if (savedParentCategoryId) {
var event = new Event('change');
parentDropdown.dispatchEvent(event);
}
});
});



        </script>




<?php








       
    }
}