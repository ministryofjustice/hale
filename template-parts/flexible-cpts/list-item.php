<?php
/**
 * Template part for displaying list item for flexible CPT
 */

 $single_view = $args['single_view'];

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
    <?php if(!empty($display_fields)){

        foreach($display_fields as $field){

            if($field['name'] == 'published-date'){
                $field_value =  '<time class="entry-date published-date" datetime="' . get_the_date( DATE_W3C ) . '">' . get_the_date() . '</time>';
            }
            else {
                $field_value = get_field($field['name']);
            }

            if(!empty($field_value)){

                if($field['wpautop']) {
                    $field_value = wpautop($field_value);
                }
                ?>
                    <div class="list-item-detail detail-<?php echo $field['name']; ?>">
                        <?php if(!empty($field['label'])){ ?>
                            <div class="list-item-detail-label">
                                <?php echo $field['label']; ?>:
                            </div>
                        <?php }?>
                        <?php echo $field_value; ?>
                    </div>
                <?php
            }
        }
        }
    ?>
</div>
<?php 
