<?php

function hearing_list_footer_scripts(){ 
	
	if ( is_page_template('page-hearing-list.php') || is_page_template('page-listing.php')  ) {
	?>

		<script type="module">
			window.MOJFrontend.initAll();
		</script>

<?php 
	}
} 

add_action('wp_footer', 'hearing_list_footer_scripts'); ?>