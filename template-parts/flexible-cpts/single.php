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
		?>


	</div>

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
