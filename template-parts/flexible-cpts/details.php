<?php
/**
 * Template part for displaying fleixble details. Displays custom fields and taxonomeis as list or tags.
 */

 $post_type = get_post_type();
 
?>

<div class="flexible-post-type-details">
    <?php 
    
    $groups = acf_get_field_groups(array('post_type' => $post_type)); 

    if(is_array($groups) && count($groups) > 0){

        foreach($groups as $group) {

            $fields = acf_get_fields($group['key']);

            if (empty($fields)) {
                continue;
            }

            foreach($fields as $field){
                
                $field_value = get_field($field['name']);

                if(empty($field_value) || !array_key_exists('single_view',  $field) || !$field["single_view"]){
                    continue;
                }
                ?>
                    <div class="flexible-post-type-detail">
                        <div class="flexible-post-type-detail-label"><?php echo $field['label']; ?>: </div>
                        <?php echo esc_html($field_value); ?>
                    </div>
                <?php
                
            }
            
        }
    }

    $show_tax_on_single_view = hale_get_acf_field_status('show_tax_on_single_view');

    $single_view_tax_style = hale_get_post_type_setting('single_view_tax_style'); 

    if($show_tax_on_single_view){

        $current_post_type = get_post_type();

        $taxonomies = get_object_taxonomies($current_post_type);

        $tax_details = [];

        foreach($taxonomies as $tax){


            $tax_obj = get_taxonomy( $tax );
            $tax_terms = get_the_terms( get_the_ID(), $tax);

            if(!empty($tax_terms)){

                $tax_details[] = [
                    'slug' => $tax,
                    'label' => $tax_obj->labels->singular_name,
                    'terms' => $tax_terms
                ];
            }

        }

        if($single_view_tax_style == 'list' && !empty($tax_details)){

            foreach($tax_details as $tax){

                $term_names = [];
                foreach ($tax['terms'] as $term) {
                    $term_names[] = $term->name;
                }

                if(empty($term_names)){
                    continue;
                }

                ?>
                <div class="flexible-post-type-detail">
                    <div class="flexible-post-type-detail-label"><?php echo $tax['label'];?>: </div>
                    <?php echo implode("," , $term_names); ?>
                </div>
                <?php
            }
        }

    }
    ?>


</div>

<?php
//Tags Section

if($show_tax_on_single_view && $single_view_tax_style == 'tags' && !empty($tax_details)){

?>
    <div class="flexible-post-type-tags">
        <ul class="flexible-post-type-tags-list"> 
            <?php
            foreach($tax_details as $tax){
                foreach ($tax['terms'] as $term) { ?>
                <li class="flexible-post-type-tags-list-item">
                    <a href="<?php echo get_term_link($term); ?>"
                        class="flexible-post-type-tags-link">
                        <?php echo $term->name; ?>
                    </a>
                </li>
            <?php 
                }
            } ?>
        </ul>

    </div>
<?php } ?>

 
