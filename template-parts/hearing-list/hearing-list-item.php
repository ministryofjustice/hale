<?php
/**
 * Template part for displaying list item for hearing list items
 */

 $single_view = $args['single_view'];

 $display_terms_taxonomies = $args['display-terms-taxonomies'];

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
    <?php 
    
    if(!empty($display_terms_taxonomies)){

        $tax_details = hale_get_post_tax_details($display_terms_taxonomies);
        
        if(!empty($tax_details)){
            get_template_part( 'template-parts/hearing-list/hearing-term-list', false, array('tax-details' => $tax_details)); 
        }
    }
    
    ?>
    <?php if(!empty($display_fields)){

        foreach($display_fields as $field){

            $field_value = "";

            if($field['type'] == 'published-date'){
                $field_value =  '<time class="entry-date published-date" datetime="' . get_the_date( DATE_W3C ) . '">' . get_the_date() . '</time>';
            }
            else if($field['type'] == 'taxonomy'){
                $tax_terms = get_the_terms( get_the_ID(), $field['name'] );

                if(!empty($tax_terms)){

                    $term_names = [];
                    foreach ($tax_terms as $term) {
                        $term_names[] = $term->name;
                    }

                    if(!empty($term_names)){
                        $field_value = implode(", " , $term_names);
                    }
                }
            }
            else {
                $field_value = get_field($field['name']);
            }

            if(!empty($field_value)){
                if (isset($field['wpautop']) && $field['wpautop']) {
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
