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
<div class="govuk-form-group">
<label for="hearing-witness-autocomplete" class="govuk-label">Witness</label>

<div id="hearing-witness-hint" class="govuk-hint">
    Select a name
</div>

<input
    type="hidden" id="hearing-witness-multiselect-hidden-input" name="hearing-witness"
    value="<?php echo $selected_terms_qry; ?>" aria-describedby="hearing-witness-hint"
/>
   
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
                        <button class="multiselect-selected-remove-button govuk-link" type="button" aria-label="Remove selected option">
                            Remove
                        </button>
                    </div>
                </div>

            <?php   
                } 
            } ?>
        </div>
        <div id="hearing-witness-autocomplete-container">
                
        </div>
</div>
<div id="hearing-witness-multiselect-warning" class="multiselect-warning" role="alert"></div>   
<?php } ?>
</div>