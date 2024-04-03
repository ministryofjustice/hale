<?php
/**
 * Template part for displaying list item for flexible CPT
 */
 $flex_cpt_settings = $args['cpt-settings'];

 if(!empty($flex_cpt_settings)){ ?>


<div class="list-item type-<?php echo  $flex_cpt_settings['post_type_object_type'] ?>">
    <h2 class="list-item-title govuk-heading-m">
        <?php if($flex_cpt_settings['post_type_single_view'] !== false){ ?>
            <a href="<?php echo get_permalink(); ?>">
                <?php echo get_the_title(); ?>
            </a>
        <?php }
        else {
            echo get_the_title();   
        }
        ?>
    </h2>
    <div class="list-item-published-date">
        Published: <?php hale_posted_on(); ?>
    </div>

    <div class="list-item-excerpt">
        <?php
        $post_summary = get_post_meta( get_the_ID(), 'post_summary', true);
        if(!empty($post_summary)){
            echo wpautop($post_summary);
        }
        ?>
    </div>
</div>
<?php } 
