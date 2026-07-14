<?php
/**
 * Template part for displaying list item for flexible CPT
 */

$single_view = $args['single_view'];

$display_terms_taxonomies = $args['display-terms-taxonomies'];

$display_fields = $args['display-fields'];

$thumbnail_style = $args['thumbnail-style'];

$include_thumbnail = false;

if (has_post_thumbnail() && !empty($thumbnail_style) && $thumbnail_style != "none") $include_thumbnail = true;

?>

<div class="list-item">
    <?php
        if ($include_thumbnail) {
            // This floats to where the absolutely positioned thumbnail is to create the wrapping behaviour we need
            echo '<div class="list-item__thumb-spacer"></div>';
        }
    ?>
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
    if ($include_thumbnail) {

        // if there is a post thumbnail, and the listing page has it set to display, we echo it out here
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
        $thumb_class = "list-item__thumb list-item__thumb--$thumbnail_style";
        $alt_text = esc_attr__(get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ),"hale");

        echo "<img class='$thumb_class' src='$thumb_url' alt='' />";
    }

    if(!empty($display_terms_taxonomies)){

        $tax_details = hale_get_post_tax_details($display_terms_taxonomies);
        
        if(!empty($tax_details)){
            get_template_part( 'template-parts/flexible-cpts/term-list', false, array('tax-details' => $tax_details)); 
        }
    }
    
    
    ?>
    <?php if(!empty($display_fields)){

        foreach($display_fields as $field){

            $field_value = "";

            if($field['type'] == 'published-date'){
                $field_value =  '<time class="entry-date published-date" datetime="' . get_the_date( DATE_W3C ) . '">' . get_the_date() . '</time>';
            }
            else if($field['name'] == 'post_revision_date'){
               $revision_date = get_field('post_revision_date');

               if(!empty($revision_date)){
                    $field_value =  '<time class="entry-date release-date" datetime="' . date('c', $revision_date) . '">' . date('j F Y', $revision_date) . '</time>';
                }
            }
            else if($field['type'] == 'taxonomy'){
                $tax_terms = get_the_terms( get_the_ID(), $field['name'] );

                if(!empty($tax_terms)){

                    $term_names = [];
                    foreach ($tax_terms as $term) {
                        $term_names[] = $term->name;
                    }

                    if(!empty($term_names)){
                        $field_value = implode("; " , $term_names);
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
                                <?php echo __($field['label'],'hale'); ?>:
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
