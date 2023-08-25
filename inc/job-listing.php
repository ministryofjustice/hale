<?php
	/**
	 * Deals with address capitalization
	 *
	 * @package Hale
	 * Theme Hale
	 * ©Crown Copyright
	 * @version 1.0 August MMXXIII
	 **/

	function sanitizeAddress($address) {
		$allCaps = ["HM","HMP","YOI","HMP/YOI","HMYOI","HMPYOI","NPS","NMS","RCJ","OPG","JCP","LAA","HMCTS","HMPPS","CTS","LG,"];
		$specialCases = ["&amp;", "MoJ", "(MoJ)", "MacMillan"]; //instances where the capitalization isn't quite normal
		$commonSeparators = [
			// These are separators which are not capitalised at all
			"on", "on-the",
			"upon", "upon-the",
			"under", "under-the",
			"by", "by-the",
			"next", "next-the",
			"in", "in-the",
			"to", "to-the",
			"super",
			"cum", "and",
			"with", "of", "of-the",
			"en-le", "de-la", "en-la",
			"en", "de", "le", "la"];
		$postcodePattern = '/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([AZa-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/';
		// Above pattern from https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/488478/Bulk_Data_Transfer_-_additional_validation_valid_from_12_November_2015.pdf
		$postcodeExtracted = preg_match($postcodePattern, $address, $matches, PREG_OFFSET_CAPTURE);
		$postcodeLocation = 0;
		foreach ($matches as $match){
			if ($match[1] > $postcodeLocation) $postcodeLocation = $match[1];
		}
		if ($postcodeLocation > 0) {
			$postcode = substr($address,$postcodeLocation);
			$addressWithoutPostcode = substr($address,0,$postcodeLocation);
		} else {
			$postcode = ""; //no postcode
			$addressWithoutPostcode = $address;
		}
		$postcode = strtoupper($postcode);
		$postcode = str_replace(" ","&nbsp;",$postcode); //postcodes shouldn't be broken

		$addressBits = explode(" ",$addressWithoutPostcode);
		$sanitizedAddress = "";
		foreach($addressBits as $bit) {
			if (in_array(strtolower($bit), array_map('strtolower', $specialCases))) {
				// this ensures that special cases are capitalized correctly
				foreach($specialCases as $specialCase) {
					if (strtolower($bit) == strtolower($specialCase)) $sanitizedAddress .= $specialCase." ";
				}
			} elseif (preg_match("/[0-9][SNRTsnrt][TDHtdh]/",$bit)) {
				// this ensures items like 1st/2nd are lower case
				$sanitizedAddress .= strtolower($bit)." ";
			} elseif (in_array($bit,$allCaps)) {
				// this ensures all-caps items are capitalized
				$sanitizedAddress .= strtoupper($bit)." ";
			} elseif (!preg_match("/[0-9]/",$bit)) {
				// this is everything else if no numbers found in string
				$bit = mb_strtolower($bit);
				if (!in_array($bit,$commonSeparators)) {
					$bit = mb_convert_case($bit, MB_CASE_TITLE)." ";

					//The below deals with capitalization in places like "Wells-next-the-Sea" (hyphens)
					foreach ($commonSeparators as $separator) {
						// First, capitalize the "Sea" bit, which would have been missed before as it is not at the beginning of the "word"
						$disectedTownName = explode("-$separator-",$bit);
						if (count($disectedTownName) == 2) {
							$disectedTownName[1] = mb_convert_case($disectedTownName[1], MB_CASE_TITLE);
							$bit = join("-$separator-",$disectedTownName);
						}
					}
				}
				$sanitizedAddress .= "$bit "; //contruct the sanitized address

				foreach ($commonSeparators as $separator) {
					// Here, we decapitalize any separators
					$sanitizedAddress = str_ireplace("-$separator-","-$separator-",$sanitizedAddress); //hyphens
					$separator = str_replace("-"," ",$separator);
					$sanitizedAddress = str_ireplace(" $separator "," $separator ",$sanitizedAddress); //spaces
				}
			} else  {
				$sanitizedAddress .= $bit." ";
			}
		}
		$sanitizedAddress .= $postcode;
		return $sanitizedAddress;
	}
	


	function jobItemRowHTML($label,$details) {
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

	function hale_job_listings_add_query_vars_filter($vars)
	{
		$vars[] = "page_size";
		$vars[] = "min_salary";
		$vars[] = "max_salary";
		return $vars;
	}
	add_filter('query_vars', 'hale_job_listings_add_query_vars_filter');

	function salaryFilter($salary,$name,$id,$salaryErrorClass="",$zeroOption="£0") {
		$selected0 = $selected20000 = $selected30000 = $selected40000 = $selected50000 = $selected60000 = $selected70000 = $selected80000 = $selected90000 = $selected100000 = "";
		$salarySelected = "selected$salary";
		$$salarySelected = "selected";
		$output =
		"
		<select class='govuk-select $salaryErrorClass' name='$name' id='$id'>
			<option value='0' $selected0>$zeroOption</option>
			<option value='20000' $selected20000>£20,000</option>
			<option value='30000' $selected30000>£30,000</option>
			<option value='40000' $selected40000>£40,000</option>
			<option value='50000' $selected50000>£50,000</option>
			<option value='60000' $selected60000>£60,000</option>
			<option value='70000' $selected70000>£70,000</option>
			<option value='80000' $selected80000>£80,000</option>
			<option value='90000' $selected90000>£90,000</option>
			<option value='100000' $selected100000>£100,000</option>
		</select>
		";
		return $output;
	}
