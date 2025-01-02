<?php

$validated_filters = $args['filters'];

if($validated_filters['error_count'] > 0  ){
?>

    <div class="govuk-error-summary" data-module="govuk-error-summary">
        <div role="alert">
            <h2 class="govuk-error-summary__title">
                <?php _e('There is a problem', 'hale'); ?>
            </h2>
            <div class="govuk-error-summary__body">
                <ul class="govuk-list govuk-error-summary__list">
                    <?php foreach($validated_filters as $filter){ 
                        if(!empty($filter['errors'])){ 
                            
                            foreach($filter['errors'] as $error){ ?>
                                <li>
                                    <a href="<?php echo $error['link']; ?>"><?php echo $error['message']; ?></a>
                                </li>
                        <?php
                            } 
                        } 
                    } ?>
                </ul>
            </div>
        </div>
    </div>
<?php   }
?>