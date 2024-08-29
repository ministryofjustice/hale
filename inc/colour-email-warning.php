<?php

function emailWarning($unset_colours,$custom_colours_found,$max,$location,) {
	/**
	 * $unset_colours [array] colour IDs which weren't set
	 * $custom_colours_found [int] number of colours set
	 * $max [int] max number of colours possible to set
	 * $location [string] file which calls the function
	 */
	if (!empty($unset_colours)) {
		$email = "wordpress@digital.justice.gov.uk";
		$env = getenv('WP_ENVIRONMENT_TYPE');
		$customizer = is_customize_preview();
		$site№ = get_current_blog_id();
		$uri = $_SERVER['REQUEST_URI'];
		$message = "";
		if ($env == "prod" && !$custom_colours_found) {
			// Send condition 1: Production site has utterly failed to retrieve any colours
			$subject = "Warning: Production site № $site№ colours have failed";
		} elseif ($env == "prod") {
			// Send condition 2: A production site has some unset colours - but it isn't thought to be a major issue.
			$subject = "Notice: Undeclared colours on production site № $site№";
		} elseif (!$custom_colours_found) {
			// Send condition 3: Any other site has utterly failed to retrieve any colours
			$subject = "Notice: Site № $site№ colours have failed ($env)";
		}
		// We only send the email if one of the above send conditions is met
		if (isset($subject)) {
			$message .= "##Situation\r\n";
			if ($customizer) {
				$message .= "Someone is using the customizer for site № $site№ on $env.  They may or may not be changing colours.\r\n";
			} else {
				$message .= "The colour code has been triggered for site № $site№ on $env.  A new colour might have been added to the palette and this has been defaulted to the GDS colour.\r\n";
			}
			$message .= "## Problem\r\n";
			if ($custom_colours_found) {
				$message .= "Site $site№ on $env is set to use custom colours.  A total of $custom_colours_found colours set out of a possible $max.\r\n"; //uses the $i from the above loop
				$message .= "This is not necessarily a problem, but might indicate some unintended GDS colours appearing on the site\r\n";
				$message .= "## Unset colours\r\n";
				foreach($unset_colours as $unset_colour) {
					$message .= "- $unset_colour\r\n";
				}
			} else {
				$message .= "Site $site№ on $env is set to use custom colours but all have failed.\r\n";
				$message .= "This might mean that the site has reverted to default colours.\r\n";
			}
			$message .= "\r\n"; // blank line needed after the list
			$message .= "## Other info\r\n";
			$message .= "This message was triggered from `$location`.\r\n";
			$message .= "URI: `$uri`.\r\n";
			wp_mail($email, $subject, $message);
		}
	}
}