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
                    <li class="flexible-post-type-terms-list-item"><?php echo $term->name; ?></li>
                <?php 
                    }
                } ?>
        </ul>

    </div>
<?php 
 }

 
