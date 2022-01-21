<?php
/**
 * Template part for displaying documents
 */


$file = get_field('document_file');
if ($file) {
	$link_uri = $file['url'];
	$link = "<a class='govuk-link' href='$link_uri'>".$file['title']."</a>";
	$size = size_format($file['filesize'],1);
	$filenameArray = explode(".",$file['filename']);
	$metadata = strtoupper($filenameArray[count($filenameArray)-1]);
	
	$image = wp_get_attachment_image($file['id'],"medium",true,array('alt'=>"Open document"));

	$icon_image = true;
	if ($metadata == "PDF" ) {
		$icon_image = false;
	}
	if ($metadata == "DOC" || $metadata == "DOCX" ) {
		$image = '
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" fill="#FFF" stroke-miterlimit="10" stroke-width="2">
		<path stroke="#979593" d="M67.1716,7H27c-1.1046,0-2,0.8954-2,2v78 c0,1.1046,0.8954,2,2,2h58c1.1046,0,2-0.8954,2-2V26.8284c0-0.5304-0.2107-1.0391-0.5858-1.4142L68.5858,7.5858 C68.2107,7.2107,67.702,7,67.1716,7z"/>
		<path fill="none" stroke="#979593" d="M67,7v18c0,1.1046,0.8954,2,2,2h18"/>
		<path fill="#C8C6C4" d="M79 61H48v-2h31c.5523 0 1 .4477 1 1l0 0C80 60.5523 79.5523 61 79 61zM79 55H48v-2h31c.5523 0 1 .4477 1 1l0 0C80 54.5523 79.5523 55 79 55zM79 49H48v-2h31c.5523 0 1 .4477 1 1l0 0C80 48.5523 79.5523 49 79 49zM79 43H48v-2h31c.5523 0 1 .4477 1 1l0 0C80 42.5523 79.5523 43 79 43zM79 67H48v-2h31c.5523 0 1 .4477 1 1l0 0C80 66.5523 79.5523 67 79 67z"/>
		<path fill="#185ABD" d="M12,74h32c2.2091,0,4-1.7909,4-4V38c0-2.2091-1.7909-4-4-4H12c-2.2091,0-4,1.7909-4,4v32 C8,72.2091,9.7909,74,12,74z"/>
		<path d="M21.6245,60.6455c0.0661,0.522,0.109,0.9769,0.1296,1.3657h0.0762 c0.0306-0.3685,0.0889-0.8129,0.1751-1.3349c0.0862-0.5211,0.1703-0.961,0.2517-1.319L25.7911,44h4.5702l3.6562,15.1272 c0.183,0.7468,0.3353,1.6973,0.457,2.8532h0.0608c0.0508-0.7979,0.1777-1.7184,0.3809-2.7615L37.8413,44H42l-5.1183,22h-4.86 l-3.4885-14.5744c-0.1016-0.4197-0.2158-0.9663-0.3428-1.6417c-0.127-0.6745-0.2057-1.1656-0.236-1.4724h-0.0608 c-0.0407,0.358-0.1195,0.8896-0.2364,1.595c-0.1169,0.7062-0.211,1.2273-0.2819,1.565L24.1,66h-4.9357L14,44h4.2349 l3.1843,15.3882C21.4901,59.7047,21.5584,60.1244,21.6245,60.6455z"/>
		</svg>';
	}
	if ($metadata == "XLS" || $metadata == "XLSX" ) {
		$image = '
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" fill="#FFF" stroke-miterlimit="10" stroke-width="2">
		<path stroke="#979593" d="M67.1716,7H27c-1.1046,0-2,0.8954-2,2v78 c0,1.1046,0.8954,2,2,2h58c1.1046,0,2-0.8954,2-2V26.8284c0-0.5304-0.2107-1.0391-0.5858-1.4142L68.5858,7.5858 C68.2107,7.2107,67.702,7,67.1716,7z"/>
		<path fill="none" stroke="#979593" d="M67,7v18c0,1.1046,0.8954,2,2,2h18"/>
		<path fill="#C8C6C4" d="M51 61H41v-2h10c.5523 0 1 .4477 1 1l0 0C52 60.5523 51.5523 61 51 61zM51 55H41v-2h10c.5523 0 1 .4477 1 1l0 0C52 54.5523 51.5523 55 51 55zM51 49H41v-2h10c.5523 0 1 .4477 1 1l0 0C52 48.5523 51.5523 49 51 49zM51 43H41v-2h10c.5523 0 1 .4477 1 1l0 0C52 42.5523 51.5523 43 51 43zM51 67H41v-2h10c.5523 0 1 .4477 1 1l0 0C52 66.5523 51.5523 67 51 67zM79 61H69c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C80 60.5523 79.5523 61 79 61zM79 67H69c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C80 66.5523 79.5523 67 79 67zM79 55H69c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C80 54.5523 79.5523 55 79 55zM79 49H69c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C80 48.5523 79.5523 49 79 49zM79 43H69c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C80 42.5523 79.5523 43 79 43zM65 61H55c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C66 60.5523 65.5523 61 65 61zM65 67H55c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C66 66.5523 65.5523 67 65 67zM65 55H55c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C66 54.5523 65.5523 55 65 55zM65 49H55c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C66 48.5523 65.5523 49 65 49zM65 43H55c-.5523 0-1-.4477-1-1l0 0c0-.5523.4477-1 1-1h10c.5523 0 1 .4477 1 1l0 0C66 42.5523 65.5523 43 65 43z"/>
		<path fill="#107C41" d="M12,74h32c2.2091,0,4-1.7909,4-4V38c0-2.2091-1.7909-4-4-4H12c-2.2091,0-4,1.7909-4,4v32 C8,72.2091,9.7909,74,12,74z"/>
		<path d="M16.9492,66l7.8848-12.0337L17.6123,42h5.8115l3.9424,7.6486c0.3623,0.7252,0.6113,1.2668,0.7471,1.6236 h0.0508c0.2617-0.58,0.5332-1.1436,0.8164-1.69L33.1943,42h5.335l-7.4082,11.9L38.7168,66H33.041l-4.5537-8.4017 c-0.1924-0.3116-0.374-0.6858-0.5439-1.1215H27.876c-0.0791,0.2684-0.2549,0.631-0.5264,1.0878L22.6592,66H16.9492z"/>
		</svg>';
	}
	//catch for no image set - simple SVG for file icon
	if (!$image) {
		$image = '
		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 		viewBox="0 0 317.001 317.001" style="enable-background:new 0 0 317.001 317.001;" xml:space="preserve">
			<path d="M270.825,70.55L212.17,3.66C210.13,1.334,207.187,0,204.093,0H55.941C49.076,0,43.51,5.566,43.51,12.431V304.57
				c0,6.866,5.566,12.431,12.431,12.431h205.118c6.866,0,12.432-5.566,12.432-12.432V77.633
				C273.491,75.027,272.544,72.51,270.825,70.55z M55.941,305.073V12.432H199.94v63.601c0,3.431,2.78,6.216,6.216,6.216h54.903
				l0.006,222.824H55.941z"/>
		</svg>';
	}

	if (isset($size) && $size) $metadata .= ", ".$size;
	
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		the_title( '<h1 class="document-title govuk-heading-xl">', '</h1>' );
	?>
	<div class="document-summary">
		<?php if (!$icon_image) { ?>
		<div class="document-summary__image">
			<?php
				echo "<a class='govuk-link' href='$link_uri'>$image</a>";
			?>
		</div>
		<?php } ?>
		<div class="document-summary__link">
			<p class="govuk-body">
			<?php
				if ($icon_image) {
					echo "<span class='document-summary__icon'>$image</span>";
				}
				echo "<b>$link</b> ($metadata)";
			?>
			</p>
		</div>
	</div>
	
    <?php do_action( 'hale_before_single_content' ); ?>

	<div class="document-content">
		<?php
		if ( function_exists( 'hale_clean_bad_content' ) ) {
			hale_clean_bad_content( true );
		}
		?>
	</div><!-- .article-content -->
	<div class="govuk-clearfix"></div>
	<?php do_action( 'hale_after_single_content' ); ?>

	<footer class="document-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
