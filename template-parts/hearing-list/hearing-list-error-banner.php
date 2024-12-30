<?php

$validated_filters = $args['validated_filters'];

if(count($validated_filters['errors']) > 0  ){
?>

    <div class="govuk-error-summary" data-module="govuk-error-summary">
        <div role="alert">
            <h2 class="govuk-error-summary__title">
                <?php _e('There is a problem', 'hale'); ?>
            </h2>
            <div class="govuk-error-summary__body">
                <ul class="govuk-list govuk-error-summary__list">
                    <?php foreach($validated_filters['errors'] as $error){ ?>
                        <li>
                            <a href="<?php echo $error['link']; ?>"><?php echo $error['message']; ?></a>
                        </li>   
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php   }
?>