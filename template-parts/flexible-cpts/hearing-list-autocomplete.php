<?php
/**
 * Template part for displaying term list. 
 */


 $all_terms = get_terms(array(
    'taxonomy' => 'hearing-witness',
));

$selected_terms = [];
$selected_terms_qry = get_query_var('hearing-witness');

if(!empty($selected_terms_qry)){
    $selected_terms = explode(",", $selected_terms_qry);
}

if(!empty($all_terms)){

?>
<label for="hearing-witness-autocomplete" class="govuk-label">Name</label>
<p>Search for multiple names or companies. X selections max</p>
<input type="hidden" id="hearing-witness" name="hearing-witness" value="<?php echo $selected_terms_qry; ?>" />
   
<div class="multiselect-wrapper">
        <div id="hearing-witness-selected-options" class="multiselect-selected-options options-style-1">
            <?php if(!empty($selected_terms)){ 
                foreach($selected_terms as $term_id){
                    ?>
            
                <div id="selected-option-<?php echo $term_id; ?>" class="multiselect-selected-option">
                    <?php echo get_term($term_id)->name; ?> 
                    <div data-termid="<?php echo $term_id; ?>" class="multiselect-selected-remove2">
                    <svg class="hale-icon hale-icon--cross" xmlns="http://www.w3.org/2000/svg" viewBox="-2 2 29 20" aria-hidden="true" focusable="false">
                        <path d="m13.41 12 5.3-5.29a1 1 0 1 0-1.42-1.42L12 10.59l-5.29-5.3a1 1 0 0 0-1.42 1.42l5.3 5.29-5.3 5.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l5.29-5.3 5.29 5.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path>
                    </svg>
                    </div>
                    <div data-termid="<?php echo $term_id; ?>" class="multiselect-selected-remove">
                        remove
                    </div>
                </div>

            <?php   
                } 
            } ?>
        </div>
        <div id="listing-search-autocomplete-container">
                
        </div>
</div>
 
<script>

    $confirmed = false;
    const terms = [
        <?php foreach($all_terms as $term) { ?>
            { id: <?php echo $term->term_id; ?>, name: "<?php echo $term->name; ?>" },
        <?php } ?>
    ];

    var selected_term_ids = [
        <?php foreach($selected_terms as $term_id) {  ?>
             <?php echo $term_id; ?>,
        <?php } ?>
    ];

    var term_names = [
                <?php foreach($all_terms as $term) { 
                    if(in_array($term->term_id, $selected_terms)){
                        continue;
                    }
                    ?>
                    '<?php echo $term->name; ?>',
                <?php } ?>
             ];
            
         document.addEventListener("DOMContentLoaded", function() {
    
             accessibleAutocomplete({
                 element: document.querySelector('#listing-search-autocomplete-container'),
                 id: 'hearing-witness-autocomplete', // Matches the hidden input
                 name: 'hearing-witness-autocomplete', // Matches the hidden input
                 placeholder: 'Search for a name',
                 //source: term_names,
                   source: function (query, populateResults) {
                        const results = term_names.filter(term => term.toLowerCase().includes(query.toLowerCase()));
                        populateResults(results);
                    },
                 showAllValues: true,
                 dropdownArrow: function (config) {
                     return '<svg class="' + config.className + '" style="top: 8px;" viewBox="0 0 512 512" ><path d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9  c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3  z"/></svg>'
                 },
                 onConfirm: (value) => {

                    confirmMultiSelectOption(value);
                    updateMultiSelectOptions();
                 }
             });

         });

         setInterval(() => {
            if($confirmed){
                document.getElementById('hearing-witness-autocomplete').value = '';
                $confirmed = false;
            }
        }, 100); 

        function updateMultiSelectOptions() {
            term_names = [];
            terms.forEach((term) => {
                if(!selected_term_ids.includes(term.id)){
                    term_names.push(term.name);
                }
            });
        }
        //Confirms selected option
         function confirmMultiSelectOption(value) {


            const foundTerm = terms.find(item => item.name === value);

            if (foundTerm) {
           
                if(selected_term_ids.includes(foundTerm.id)){
                    return;
                }

                $confirmed = true;

                selected_term_ids.push(foundTerm.id);
                //document.getElementById('hearing-witness').value = foundTerm.id;
                document.getElementById('hearing-witness').value = selected_term_ids.toString();

                const newDiv = document.createElement('div');

                newDiv.id = 'selected-option-'+foundTerm.id; 
                newDiv.textContent = foundTerm.name;
                newDiv.className = 'multiselect-selected-option';

                const removeDiv = document.createElement('div');

                removeDiv.textContent = 'remove';
                removeDiv.className = 'multiselect-selected-remove';
                removeDiv.setAttribute('data-termid', foundTerm.id);

                newDiv.appendChild(removeDiv);

                const removeDiv2 = document.createElement('div');

                removeDiv2.innerHTML = '<svg class="hale-icon hale-icon--cross" xmlns="http://www.w3.org/2000/svg" viewBox="-2 2 29 20" aria-hidden="true" focusable="false"> <path d="m13.41 12 5.3-5.29a1 1 0 1 0-1.42-1.42L12 10.59l-5.29-5.3a1 1 0 0 0-1.42 1.42l5.3 5.29-5.3 5.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l5.29-5.3 5.29 5.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path></svg>';
                removeDiv2.className = 'multiselect-selected-remove2';
                removeDiv2.setAttribute('data-termid', foundTerm.id);

                newDiv.appendChild(removeDiv2);

                document.getElementById('hearing-witness-selected-options').appendChild(newDiv);

                removeDiv.addEventListener('click', () => {
        
                    var termId = Number(removeDiv.getAttribute('data-termid'));
                    removeMultiSelectOption(termId);

                });

                removeDiv2.addEventListener('click', () => {
        
                    var termId = Number(removeDiv.getAttribute('data-termid'));
                    removeMultiSelectOption(termId);

                });

            }
            
         }

         //Removes option from selected options
         function removeMultiSelectOption(value) {
            selected_term_ids = selected_term_ids.filter(num => num !== value);
            document.getElementById('hearing-witness').value = selected_term_ids.toString();
            document.getElementById('selected-option-'+value).remove();
            updateMultiSelectOptions();
         }

         //Adds event listener to remove option - first option
         const removeOptions = document.querySelectorAll('div.multiselect-selected-remove');

         removeOptions.forEach(option => {
            option.addEventListener('click', () => {
        
                var termId = Number(option.getAttribute('data-termid'));
                removeMultiSelectOption(termId);
       
            });
        });

        //Adds event listener to remove option - second option
        const removeOptions2 = document.querySelectorAll('div.multiselect-selected-remove2');

        removeOptions2.forEach(option => {
        option.addEventListener('click', () => {

            var termId = Number(option.getAttribute('data-termid'));
            removeMultiSelectOption(termId);

        });
        });

     </script>
 
<?php } ?>