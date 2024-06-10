<?php
/**
 * Template part for displaying fleixble cpt of type simple
 */

 $post_type = get_post_type();
 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('flexible-post-type-single')); ?>>
    <header class="flexible-post-type-header">
        <?php

        the_title('<h1 class="flexible-post-type-title govuk-heading-xl">', '</h1>');

        ?>
    </header>
    <div class="flexible-post-type-details">
        <div class="flexible-post-type-detail">
            <div class="flexible-post-type-detail-label">Published: </div>
            <?php hale_posted_on(); ?>
        </div>
		<?php 
        
        $groups = acf_get_field_groups(array('post_type' => $post_type)); 
		
        if(is_array($groups) && count($groups) > 0){

            foreach($groups as $group) {

                $fields = acf_get_fields($group['key']);

                if(is_array($fields) && count($fields) > 0){

                    foreach($fields as $field){
                        
                        $field_value = get_field($field['name']);

                        if(!empty($field_value) && $field["single_view"]){
                            ?>
                                <div class="flexible-post-type-detail">
                                    <div class="flexible-post-type-detail-label"><?php echo $field['label']; ?>: </div>
                                    <?php echo $field_value; ?>
                                </div>
                            <?php
                        }
                    }
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
                        'label' => $tax_obj->label,
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

    <?php do_action('hale_before_single_content'); ?>

    <div class="flexible-post-type-content">
        <?php
        if (function_exists('hale_clean_bad_content')) {
            hale_clean_bad_content(true);
        }
        ?>
    </div><!-- .article-content -->
    <div class="govuk-clearfix"></div>

    <?php do_action('hale_after_single_content'); ?>

    <footer class="flexible-post-type-footer">
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
