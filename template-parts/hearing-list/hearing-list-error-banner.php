<?php

$validatedFilters = $args['filters'];

if (isset($validatedFilters['error_count']) && $validatedFilters['error_count'] > 0) {
    ?>

    <div class="govuk-error-summary" data-module="govuk-error-summary">
        <div role="alert">
            <h2 class="govuk-error-summary__title">
                <?php _e('There is a problem', 'hale'); ?>
            </h2>
            <div class="govuk-error-summary__body">
                <ul class="govuk-list govuk-error-summary__list">
                    <?php foreach ($validatedFilters as $filter) {
                        if (!empty($filter['errors']) && is_array($filter['errors'])) {
                            foreach ($filter['errors'] as $error) {
                                if (isset($error['link'], $error['message'])) { ?>
                                    <li>
                                        <a href="<?php echo esc_url($error['link']); ?>">
                                            <?php echo esc_html($error['message']); ?>
                                        </a>
                                    </li>
                                <?php }
                            }
                        }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
