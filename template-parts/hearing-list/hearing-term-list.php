<?php

 /**
  * Template part for displaying term list.
  */
 
 $tax_details = $args['tax-details'];
 
 if (!empty($tax_details)) :
     ?>
     <div class="flexible-post-type-terms-list-wrapper">
         <div class="flexible-post-type-terms-list-title">Witness:</div>
         <ul class="flexible-post-type-terms-list">
             <?php
             foreach ($tax_details as $tax) :
                 $last_term = end($tax['terms']);
                 foreach ($tax['terms'] as $term) : ?>
                    <li class="flexible-post-type-terms-list-term">
                        <?php echo esc_html(trim($term->name)); ?><?php if ($term !== $last_term) { echo ','; } ?>
                    </li>
                 <?php
                 endforeach;
             endforeach;
             ?>
         </ul>
     </div>
 <?php
 endif;
 