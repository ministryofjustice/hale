<?php
/**
 * Template part for displaying term list. 
 */

 $tax_details = $args['tax-details'];

 if(!empty($tax_details)){
?>
    <div class="flexible-post-type-terms-list-wrapper">
        <ul class="flexible-post-type-terms-list"> 
            <?php
                foreach($tax_details as $tax){
                    foreach ($tax['terms'] as $term) { ?>
                    <li class="flexible-post-type-terms-list-item">
                        <a href="<?php echo get_term_link($term); ?>"
                            class="flexible-post-type-terms-link">
                            <?php echo $term->name; ?>
                        </a>
                    </li>
                <?php 
                    }
                } ?>
        </ul>

    </div>
<?php 
 }

 
