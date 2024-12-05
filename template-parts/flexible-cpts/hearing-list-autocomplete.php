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
    <input type="hidden" id="hearing-witness" name="hearing-witness" value="" />
   
        <div id="hearing-witness-selected-options" class="multiselect-selected-options">
            <?php if(!empty($selected_terms)){ 
                foreach($selected_terms as $term_id){
                    ?>
            
                <div id="selected-option-<?php echo $term_id; ?>" class="multiselect-selected-option">
                    <?php echo get_term($term_id)->name; ?>
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
 
<script>

    $confirmed = false;
    const terms = [
        <?php foreach($all_terms as $term) { ?>
            { id: <?php echo $term->term_id; ?>, name: "<?php echo $term->name; ?>" },
        <?php } ?>
    ];

    var selected_term_ids = [
        <?php foreach($selected_terms as $term_id) { ?>
             <?php echo $term_id; ?>,
        <?php } ?>
    ]
         document.addEventListener("DOMContentLoaded", function() {
             const term_names = [
                <?php foreach($all_terms as $term) { ?>
                    '<?php echo $term->name; ?>',
                <?php } ?>
             ];
            
             accessibleAutocomplete({
                 element: document.querySelector('#listing-search-autocomplete-container'),
                 id: 'hearing-witness-autocomplete', // Matches the hidden input
                 name: 'hearing-witness-autocomplete', // Matches the hidden input
                 source: term_names,
                 showAllValues: true,
                 dropdownArrow: function (config) {
                     return '<svg class="' + config.className + '" style="top: 8px;" viewBox="0 0 512 512" ><path d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9  c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3  z"/></svg>'
                 },
                 onConfirm: (value) => {

                    confirmMultiSelectOption(value);
                    $confirmed = true;
            
                 }
             });

         });

         setInterval(() => {
            if($confirmed){
                document.getElementById('hearing-witness-autocomplete').value = '';
                $confirmed = false;
            }
        }, 100); 

         function confirmMultiSelectOption(value) {


            const foundTerm = terms.find(item => item.name === value);

            if (foundTerm) {
           
                if(selected_term_ids.includes(foundTerm.id)){
                    return;
                }

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

                document.getElementById('hearing-witness-selected-options').appendChild(newDiv);

                removeDiv.addEventListener('click', () => {
        
                    var termId = Number(removeDiv.getAttribute('data-termid'));
                    selected_term_ids = selected_term_ids.filter(num => num !== termId);
                    document.getElementById('selected-option-'+termId).remove();

                });

            }
            
         }

         const removeOptions = document.querySelectorAll('div.multiselect-selected-remove');

         removeOptions.forEach(option => {
            option.addEventListener('click', () => {
        
                var termId = Number(option.getAttribute('data-termid'));
                selected_term_ids = selected_term_ids.filter(num => num !== termId);
                document.getElementById('selected-option-'+termId).remove();
       
            });
        });


         /*
         jQuery( document ).ready(function( $ ) {

         $(".multiselect-selected-remove").on('click', function(event){
               const termId = $(this).data('termid');
               selected_term_ids = selected_term_ids.filter(num => num !== termId);
               document.getElementById('selected-option-'+termId).remove();
            });

        });*/
     </script>
 
<?php } ?>