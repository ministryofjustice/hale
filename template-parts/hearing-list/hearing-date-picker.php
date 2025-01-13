<?php
/**
 * Hearing date picker component
 * Used by hearing-list-filters.php
 */

$filter = $args['filters'];

$from_date = isset($filter['value']['from_date']) ? sanitize_text_field($filter['value']['from_date']) : '';
$to_date = isset($filter['value']['to_date']) ? sanitize_text_field($filter['value']['to_date']) : '';

$error_date_from = false;
$error_date_to = false;

if (!empty($filter['errors'])) {
    foreach ($filter['errors'] as $error) {
        if (isset($error['link']) && $error['link'] === '#from-date') {
            $error_date_from = true;
        }
        if (isset($error['link']) && $error['link'] === '#to-date') {
            $error_date_to = true;
        }
    }
}

?>

<div class="moj-datepicker" data-module="moj-date-picker">
    <div class="govuk-form-group <?php if ($error_date_from) { echo 'govuk-form-group--error'; } ?>">
        <label class="govuk-label" for="date">
            Date from
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
            name="from_date" 
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
            Date to
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
            name="to_date" 
            type="text" 
            aria-describedby="to-date-hint" 
            autocomplete="true" 
            value="<?php echo esc_attr($to_date); ?>"
        >
    </div>
</div>
