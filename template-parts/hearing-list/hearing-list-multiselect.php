<?php
/**
 * Template part for displaying hearing list multiselect
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
<p>Search for multiple names or companies. 5 selections max</p>
<input type="hidden" id="hearing-witness-multiselect-hidden-input" name="hearing-witness" value="<?php echo $selected_terms_qry; ?>" />
   
<div class="multiselect-wrapper">
        <div id="hearing-witness-selected-options" class="multiselect-selected-options options-style-1">
            <?php if(!empty($selected_terms)){ 
                foreach($selected_terms as $term_id){
                    ?>
            
                <div id="selected-option-<?php echo $term_id; ?>" class="multiselect-selected-option">
                    <div class="multiselect-selected-option-name">
                        <?php echo get_term($term_id)->name; ?> 
                    </div>
                    <div data-termid="<?php echo $term_id; ?>" class="multiselect-selected-remove">
                        Remove
                    </div>
                </div>

            <?php   
                } 
            } ?>
        </div>
        <div id="hearing-witness-autocomplete-container">
                
        </div>
</div>
<?php } ?>