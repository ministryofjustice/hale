<?php
/**
 * Template part for displaying list item for flexible CPT
 */

 $single_view = true;

 $display_fields = $args['display-fields'];
?>

<div class="list-item">
    <h2 class="list-item-title govuk-heading-m">
        <?php if($single_view !== false){ ?>
            <a href="<?php echo get_permalink(); ?>">
                <?php echo get_the_title(); ?>
            </a>
        <?php }
        else {
            echo get_the_title();   
        }
        ?>
    </h2>
    <div class="list-item-detail">
        <div class="list-item-detail-label">Published: </div>
        <?php hale_posted_on(); ?>
    </div>
    <?php if(!empty($display_fields)){

        foreach($display_fields as $field){
            $field_value = get_field($field['name']);

            if(!empty($field_value)){
                ?>
                    <div class="list-item-detail">
                        <div class="list-item-detail-label">
                            <?php echo $field['label']; ?>
                        </div>
                        <?php echo $field_value; ?>
                    </div>
                <?php
            }
        }
        }
    ?>
</div>
<?php 
