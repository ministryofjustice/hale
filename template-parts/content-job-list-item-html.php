<?php

function jobListingHTML($label,$details) {
	return "
	<div class='job-list-item--section'>
		<div class='job-list-item--section--label'>
			<p class='govuk-body govuk-!-font-weight-bold'>
				$label
			</p>
		</div>
		<div class='job-list-item--section--detail'>
			<p class='govuk-body'>
				$details
			</p>
		</div>
	</div>
	";
}