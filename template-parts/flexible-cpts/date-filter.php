<?php

$filter_name = $args['name'];
$filter_label = $args['label'];

if(!empty($filter_label)){
    $from_date_label = $filter_label . " (from)";
    $to_date_label = $filter_label . " (to)";
}
else {
    $from_date_label = "Date from";
    $to_date_label = "Date to";
}

$from_date_name = $args['name'] . "_from_date";
$to_date_name = $args['name'] . "_to_date";

$from_date = get_query_var($from_date_name);
$to_date = get_query_var($to_date_name);

$error_date_from = false;
$error_date_to = false;

/*if (!empty($filter['errors'])) {
    foreach ($filter['errors'] as $error) {
        if (isset($error['link']) && $error['link'] === '#from-date') {
            $error_date_from = true;
        }
        if (isset($error['link']) && $error['link'] === '#to-date') {
            $error_date_to = true;
        }
    }
*/

?>

<div class="moj-datepicker" data-module="moj-date-picker">
    <div class="govuk-form-group <?php if ($error_date_from) { echo 'govuk-form-group--error'; } ?>">
        <label class="govuk-label" for="date">
            <?php echo $from_date_label; ?>
        </label>
        <div id="from-date-hint" class="govuk-hint">
            For example, 13/2/2024.
        </div>
        <?php if ($error_date_from) { ?>
            <p id="hearing-filter-date-from-error" class="govuk-error-message">
                <span class="govuk-visually-hidden">
                    <?php _e('Error:', 'hale'); ?>
                </span>
                <?php _e('Date from must be a real date including a day, month, and year', 'hale'); ?>
            </p>
        <?php } ?>
        <input 
            class="govuk-input moj-js-datepicker-input" 
            id="from-date" 
            name="<?php echo $from_date_name; ?>" 
            type="text" 
            aria-describedby="from-date-hint" 
            autocomplete="off" 
            value="<?php echo esc_attr($from_date); ?>"
        >
    </div>
</div>

<div class="moj-datepicker" data-module="moj-date-picker">
    <div class="govuk-form-group <?php if ($error_date_to) { echo 'govuk-form-group--error'; } ?>">
        <label class="govuk-label" for="date">
            <?php echo $to_date_label; ?>
        </label>
        <div id="to-date-hint" class="govuk-hint">
            For example, 13/2/2024.
        </div>
        <?php if ($error_date_to) { ?>
            <p id="hearing-filter-date-to-error" class="govuk-error-message">
                <span class="govuk-visually-hidden">
                    <?php _e('Error:', 'hale'); ?>
                </span>
                <?php _e('Date to must be a real date including a day, month, and year', 'hale'); ?>
            </p>
        <?php } ?>
        <input 
            class="govuk-input moj-js-datepicker-input" 
            id="to-date" 
            name="<?php echo $to_date_name; ?>" 
            type="text" 
            aria-describedby="to-date-hint" 
            autocomplete="true" 
            value="<?php echo esc_attr($to_date); ?>"
        >
    </div>
</div>