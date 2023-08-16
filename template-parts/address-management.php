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
		$allCaps = ["HM","HMP","YOI","HMP/YOI","HMYOI","HMPYOI","NPS","NMS","RCJ","OPG","JCP","LAA","HMCTS","HMPPS","CTS"];
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
			"cum",
			"with", "of",
			"en-le", "de-la", "en-la",
			"en", "de", "le", "la"];
		$postcodePattern = '/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([AZa-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/';
		// Above pattern from https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/488478/Bulk_Data_Transfer_-_additional_validation_valid_from_12_November_2015.pdf
		$postcodeExtracted = preg_match($postcodePattern, $address, $matches, PREG_OFFSET_CAPTURE);
		$postcodeLocation = 0;
		foreach ($matches as $match){
			if ($match[1] > $postcodeLocation) $postcodeLocation = $match[1];
		}
		if ($postcodeLocation > -1) {
			$postcode = substr($address,$postcodeLocation);
		} else {
			$postcode = ""; //no postcode
		}
		$postcode = strtoupper($postcode);
		$postcode = str_replace(" ","&nbsp;",$postcode); //postcodes shouldn't be broken

		$addressWithoutPostcode = substr($address,0,$postcodeLocation);
		$addressBits = explode(" ",$addressWithoutPostcode);
		$sanitizedAddress = "";
		foreach($addressBits as $bit) {
			if (!in_array($bit,$allCaps) && !preg_match("/[0-9]/",$bit)) {
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
				$sanitizedAddress .= strtoupper($bit)." ";
			}
		}
		$sanitizedAddress .= $postcode;
		return $sanitizedAddress;
	}
	