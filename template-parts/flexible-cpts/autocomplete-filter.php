<?php
/**
 * Template part for displaying list autocomplete
 */

$all_terms = get_terms(array(
   'taxonomy' => 'learning_types',
));

$selected_terms = [];
$selected_terms_qry = get_query_var('learning_types');

if (!empty($selected_terms_qry)) {
    $selected_terms = explode(",", $selected_terms_qry);
}

if (!empty($all_terms)) {

    ?>
<div class="govuk-form-group">
    <label for="hearing-witness-autocomplete" class="govuk-label">Title</label>
    <div id="hearing-witness-hint" class="govuk-hint">

    <input
        type="hidden" id="hearing-witness-multiselect-hidden-input" name="hearing-witness"
        value="<?php echo $selected_terms_qry; ?>" aria-describedby="hearing-witness-hint"
    />

    </div>

    <div id="listing-template-autocomplete-container"></div>
</div>
    <?php } ?> 
