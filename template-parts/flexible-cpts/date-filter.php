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

?>

<div class="moj-datepicker" data-module="moj-date-picker">
    <div class="govuk-form-group govuk-!-margin-bottom-2">
        <label class="govuk-label" for="<?php echo $from_date_name; ?>">
            <?php echo esc_html($from_date_label); ?>
        </label>
        <div id="from-date-hint" class="govuk-hint">
            For example, 13/2/2024.
        </div>
        <input 
            class="govuk-input moj-js-datepicker-input" 
            id="<?php echo $from_date_name; ?>" 
            name="<?php echo $from_date_name; ?>" 
            type="text" 
            aria-describedby="from-date-hint" 
            autocomplete="off" 
            value="<?php echo esc_attr($from_date); ?>"
        >
    </div>
</div>

<div class="moj-datepicker" data-module="moj-date-picker">
    <div class="govuk-form-group govuk-!-margin-bottom-2">
        <label class="govuk-label" for="<?php echo $to_date_name; ?>">
            <?php echo esc_html($to_date_label); ?>
        </label>
        <div id="to-date-hint" class="govuk-hint">
            For example, 13/2/2024.
        </div>
        <input 
            class="govuk-input moj-js-datepicker-input" 
            id="<?php echo $to_date_name; ?>" 
            name="<?php echo $to_date_name; ?>" 
            type="text" 
            aria-describedby="to-date-hint" 
            autocomplete="true" 
            value="<?php echo esc_attr($to_date); ?>"
        >
    </div>
</div>