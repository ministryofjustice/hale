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

	function get_prison_names($title) {
		$data = '[{"name":"HMP Wymott","town":"Leyland","lat":"53.6784954","lng":"-2.7522291","type":["Prison"],"name_variations":["HMP\/YOI Wymott","HMP & YOI Wymott","HMYOI Wymott"]},{"name":"HMP & YOI Wormwood Scrubs","town":"London","lat":"51.5169637","lng":"-0.2403418","type":["Prison"],"name_variations":["HMP Wormwood Scrubs","HMP\/YOI Wormwood Scrubs","HMYOI Wormwood Scrubs"]},{"name":"HMP\/YOI Woodhill","town":"Milton Keynes","lat":"52.0143898","lng":"-0.8083142","type":["Prison"],"name_variations":["HMP Woodhill","HMP & YOI Woodhill","HMYOI Woodhill"]},{"name":"HMP Winchester","town":"Winchester","lat":"51.0625986","lng":"-1.3279811","type":["Prison"],"name_variations":[]},{"name":"HMP Whitemoor","town":"Whitemoor","lat":"52.57534589999999","lng":"0.0811047","type":["Prison"],"name_variations":[]},{"name":"HMP Whatton","town":"Nottingham","lat":"52.9472902","lng":"-0.9116372","type":["Prison"],"name_variations":[]},{"name":"HMYOI Wetherby","town":"Wetherby","lat":"53.9356199","lng":"-1.3693436","type":["Youth Custody"],"name_variations":["HMP Wetherby","HMP\/YOI Wetherby","HMP & YOI Wetherby"]},{"name":"HMYOI Werrington","town":"Stoke-on-Trent","lat":"53.02273779999999","lng":"-2.0871984","type":["Youth Custody"],"name_variations":["HMP\/YOI Werrington","HMP & YOI Werrington","HMP Werrington"]},{"name":"HMP Wealstun","town":"Wetherby","lat":"53.9144768","lng":"-1.3303451","type":["Prison"],"name_variations":[]},{"name":"HMP Wayland","town":"Thetford","lat":"52.5538889","lng":"0.8580555999999999","type":["Prison"],"name_variations":[]},{"name":"HMP Warren Hill","town":"Woodbridge","lat":"52.0582553","lng":"1.4617513","type":["Prison"],"name_variations":["HMP\/YOI Warren Hill","HMP & YOI Warren Hill","HMYOI Warren Hill"]},{"name":"HMP Wandsworth","town":"London","lat":"51.4500051","lng":"-0.1775711","type":["Prison"],"name_variations":[]},{"name":"HMP Wakefield","town":"Wakefield","lat":"53.6820424","lng":"-1.5065964","type":["Prison"],"name_variations":[]},{"name":"HMP The Verne","town":"Moffat","lat":"50.5615548","lng":"-2.4357944","type":["Prison"],"name_variations":["The Verne","HMP Verne"]},{"name":"HMP Usk","town":"Usk","lat":"51.69941069999999","lng":"-2.9006404","type":["Prison"],"name_variations":["HMP Usk & HMP Prescoed"]},{"name":"HMP Thorn Cross","town":"Warrington","lat":"53.3490923","lng":"-2.5420153","type":["Prison"],"name_variations":["HMP\/YOI Thorn Cross","HMP & YOI Thorn Cross","HMYOI Thorn Cross"]},{"name":"HMP The Mount","town":"Bovingdon","lat":"51.72473859999999","lng":"-0.5410677","type":["Prison"],"name_variations":[]},{"name":"HMP Thameside","town":"London","lat":"51.4937188","lng":"0.0881097","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Swinfen Hall","town":"Lichfield","lat":"52.6525736","lng":"-1.8066018","type":["Prison"],"name_variations":[]},{"name":"HMP Swansea","town":"Swansea","lat":"51.61499999999999","lng":"-3.949","type":["Prison"],"name_variations":["HMP\/YOI Swansea","HMP & YOI Swansea","HMYOI Swansea"]},{"name":"HMP Swaleside","town":"Isle of Sheppey","lat":"51.3929227","lng":"0.8536864000000001","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Sudbury","town":"Ashbourne","lat":"52.8927231","lng":"-1.7665243","type":["Prison"],"name_variations":["HMP Sudbury","HMP & YOI Sudbury","HMYOI Sudbury"]},{"name":"HMP\/YOI Styal","town":"Wilmslow","lat":"53.3406335","lng":"-2.23928","type":["Prison"],"name_variations":["HMP Styal","HMP & YOI Styal","HMYOI Styal"]},{"name":"HMP\/YOI Stoke Heath","town":"Market Drayton","lat":"52.869477","lng":"-2.5234709","type":["Prison"],"name_variations":["HMP Stoke Heath","HMP & YOI Stoke Heath","HMYOI Stoke Heath"]},{"name":"HMP Stocken","town":"Oakham","lat":"52.7469327","lng":"-0.582162699999999","type":["Prison"],"name_variations":[]},{"name":"HMP Standford Hill","town":"Sheerness","lat":"51.3951083","lng":"0.8510106","type":["Prison"],"name_variations":[]},{"name":"HMP Stafford","town":"Stafford","lat":"52.8114139","lng":"-2.117706","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Send","town":"Woking","lat":"51.2738987","lng":"-0.4904337","type":["Prison"],"name_variations":["HMP Send","HMP & YOI Send","HMYOI Send"]},{"name":"HMP Rye Hill","town":"Rugby","lat":"52.3286127","lng":"-1.2425493","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Rochester","town":"Rochester","lat":"51.37","lng":"0.488611","type":["Prison"],"name_variations":["HMP Rochester","HMP\/YOI Rochester","HMYOI Rochester"]},{"name":"HMP Risley","town":"Warrington","lat":"53.4381494","lng":"-2.523771","type":["Prison"],"name_variations":[]},{"name":"HMP Ranby","town":"Retford","lat":"53.3200826","lng":"-0.9961172","type":["Prison"],"name_variations":[]},{"name":"Rainsbrook STC","town":"Willoughby","lat":"52.3260083","lng":"-1.2506373","type":["Prison"],"name_variations":["Rainsbrook Secure Training Centre"]},{"name":"HMP\/YOI Preston","town":"Preston","lat":"53.7618406","lng":"-2.6886838","type":["Prison"],"name_variations":["HMP Preston","HMYOI Preston","HMP & YOI Preston"]},{"name":"HMP Prescoed","town":"Usk","lat":"51.69941069999999","lng":"-2.9006404","type":["Prison"],"name_variations":[]},{"name":"HMP Portland","town":"Portland","lat":"50.5492107","lng":"-2.4216633","type":["Prison"],"name_variations":["HMP\/YOI Portland","HMP & YOI Portland","HMYOI Portland"]},{"name":"HMP\/YOI Peterborough","town":"Peterborough","lat":"52.5864085","lng":"-0.2601797","type":["Prison"],"name_variations":["HMP\/YOI Peterborough (F)","HMP & YOI Peterborough (F)","HMYOI Peterborough (F)","HMP\/YOI Peterborough","HMYOI Peterborough"]},{"name":"HMP Pentonville","town":"London","lat":"51.5449765","lng":"-0.1160526","type":["Prison"],"name_variations":["HMP\/YOI Pentonville","HMP & YOI Pentonville","HMYOI Pentonville"]},{"name":"HMP\/YOI Parc","town":"Bridgend","lat":"51.530964","lng":"-3.563143","type":["Prison"],"name_variations":["HMP Parc","HMP\/YOI Parc (YP)","HMP & YOI Parc (YP)","HMYOI Parc (YP)","HMP & YOI Parc","HMYOI Parc"]},{"name":"HMP Onley","town":"Rugby","lat":"52.3269943","lng":"-1.2465741","type":["Prison"],"name_variations":[]},{"name":"HMP Oakwood","town":"Featherstone","lat":"52.6479858","lng":"-2.1129241","type":["Prison"],"name_variations":[]},{"name":"Oakhill STC","town":"Milton Keynes","lat":"52.0158572","lng":"-0.8112400999999999","type":["Prison"],"name_variations":["Oakhill Secure Training Centre"]},{"name":"HMP\/YOI Nottingham","town":"Nottingham","lat":"52.98464689999999","lng":"-1.1553976","type":["Prison"],"name_variations":["HMP Nottingham","HMP & YOI Nottingham","HMYOI Nottingham"]},{"name":"HMP Norwich","town":"Norwich","lat":"52.6369762","lng":"1.3179051","type":["Prison"],"name_variations":["HMP\/YOI Norwich","HMP & YOI Norwich","HMYOI Norwich"]},{"name":"HMP Northumberland","town":"Morpeth","lat":"55.29629670000001","lng":"-1.6328499","type":["Prison"],"name_variations":[]},{"name":"HMP North Sea Camp","town":"Boston","lat":"52.9397471","lng":"0.06373329999999999","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI New Hall","town":"Wakefield","lat":"53.6357399","lng":"-1.6109232","type":["Prison"],"name_variations":["HMP New Hall","HMP\/YOI New Hall &","HMP & YOI New Hall &","HMYOI New Hall &"]},{"name":"IRC Morton Hall","town":"Lincoln","lat":"53.1679042","lng":"-0.6890860999999999","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Moorland","town":"Doncaster","lat":"53.5465555","lng":"-0.9714988000000001","type":["Prison"],"name_variations":["HMP Moorland","HMP & YOI Moorland","HMYOI Moorland"]},{"name":"Medway STC","town":"Rochester","lat":"51.3613387","lng":"0.4941801","type":["Youth Custody"],"name_variations":["Medway Secure Training Centre","Medway STC (Secure Training Centre)","STC Medway","Secure Training Centre Medway"]},{"name":"HMP Manchester","town":"Manchester","lat":"53.49195109999999","lng":"-2.2457898","type":["Prison"],"name_variations":["HMP\/YOI Manchester","HMP & YOI Manchester","HMYOI Manchester"]},{"name":"HMP Maidstone","town":"Maidstone","lat":"51.2793606","lng":"0.5237286","type":["Prison"],"name_variations":[]},{"name":"HMP Lowdham Grange","town":"Lowdham","lat":"53.01547069999999","lng":"-1.0377761","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Low Newton","town":"Durham","lat":"54.8052726","lng":"-1.556871","type":["Prison"],"name_variations":["HMP Low Newton","HMYOI Low Newton","HMP & YOI Low Newton"]},{"name":"HMP Long Lartin","town":"South Littleton","lat":"52.108459","lng":"-1.8540072","type":["Prison"],"name_variations":[]},{"name":"HMP Liverpool","town":"Liverpool","lat":"53.45657569999999","lng":"-2.9713511","type":["Prison"],"name_variations":[]},{"name":"HMP Littlehey","town":"Huntingdon","lat":"52.2816045","lng":"-0.3144711","type":["Prison"],"name_variations":[]},{"name":"HMP Lindholme","town":"Doncaster","lat":"53.5440121","lng":"-0.9703145999999999","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Lincoln","town":"Lincoln","lat":"53.2348132","lng":"-0.5172097","type":["Prison"],"name_variations":["HMP Lincoln","HMP & YOI Lincoln","HMYOI Lincoln"]},{"name":"HMP Leyhill","town":"Gloucester","lat":"51.62803419999999","lng":"-2.4367766","type":["Prison"],"name_variations":[]},{"name":"HMP Lewes","town":"Lewes","lat":"50.8726716","lng":"-0.0059188","type":["Prison"],"name_variations":["HMP\/YOI Lewes","HMP & YOI Lewes"]},{"name":"HMP Leicester","town":"Leicester","lat":"52.6274509","lng":"-1.131901","type":["Prison"],"name_variations":[]},{"name":"HMP Leeds","town":"Leeds","lat":"53.7957182","lng":"-1.5754095","type":["Prison"],"name_variations":[]},{"name":"HMP Lancaster Farms","town":"Lancaster","lat":"54.05352240000001","lng":"-2.7708222","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Kirklevington Grange","town":"Yarm","lat":"54.49503720000001","lng":"-1.3396233","type":["Prison"],"name_variations":["HMP\/YOI Kirklevington Grange","HMP Kirklevington Grange"]},{"name":"HMP Kirkham","town":"Preston","lat":"53.774924","lng":"-2.8731828","type":["Prison"],"name_variations":[]},{"name":"HMP Isle of Wight","town":"Newport","lat":"50.713196","lng":"-1.3076464","type":["Prison"],"name_variations":["HMP\/YOI Isle of Wight","HMP & YOI Isle of Wight"]},{"name":"HMP\/YOI Isis","town":"London","lat":"51.4978104","lng":"0.09673419999999999","type":["Prison"],"name_variations":["HMP Isis","HMP & YOI Isis","HMYOI Isis"]},{"name":"HMP Huntercombe","town":"Henley-on-Thames","lat":"51.5874","lng":"-1.0183","type":["Prison"],"name_variations":[]},{"name":"HMP Humber","town":"Everthorpe","lat":"53.7693399","lng":"-0.6410579","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Hull","town":"Leyland","lat":"53.7479503","lng":"-0.2967517","type":["Prison"],"name_variations":["HMP Hull","HMP\/YOI Hull","HMYOI Hull"]},{"name":"HMP Holme House","town":"Stockton-on-Tees","lat":"54.5766041","lng":"-1.2930591","type":["Prison"],"name_variations":[]},{"name":"HMP Hollesley Bay","town":"Woodbridge","lat":"52.051042","lng":"1.451328","type":["Prison"],"name_variations":["HMP\/YOI Hollesley Bay","HMP & YOI Hollesley Bay","HMYOI Hollesley Bay"]},{"name":"HMP\/YOI Hindley","town":"Wigan","lat":"53.5178648","lng":"-2.5769092","type":["Prison"],"name_variations":["HMP Hindley","HMP & YOI Hindley","HMYOI Hindley"]},{"name":"HMP Highpoint","town":"Newmarket","lat":"52.136974","lng":"0.510659","type":["Prison"],"name_variations":[]},{"name":"HMP High Down","town":"Sutton","lat":"51.3357233","lng":"-0.1890383","type":["Prison"],"name_variations":[]},{"name":"HMP Hewell","town":"Redditch","lat":"52.3246695","lng":"-1.9870964","type":["Prison"],"name_variations":[]},{"name":"HMP Haverigg","town":"Millom","lat":"54.2022592","lng":"-3.3125602","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Hatfield","town":"Doncaster","lat":"53.5866239","lng":"-0.9809106000000001","type":["Prison"],"name_variations":["HMP Hatfield","HMP\/YOI Hatfield","HMYOI Hatfield"]},{"name":"HMP Guys Marsh","town":"Shaftesbury","lat":"50.9847775","lng":"-2.2215698","type":["Prison"],"name_variations":[]},{"name":"HMP Grendon\/Springhill","town":"Aylesbury","lat":"51.8931365","lng":"-1.0072932","type":["Prison"],"name_variations":["HMP Grendon","HMP Springhill"]},{"name":"HMP Gartree","town":"Leicestershire","lat":"52.495993","lng":"-0.9608316","type":["Prison"],"name_variations":[]},{"name":"HMP Garth","town":"Leyland","lat":"53.6796006","lng":"-2.7561596","type":["Prison"],"name_variations":[]},{"name":"HMP Full Sutton","town":"York","lat":"53.98504450000001","lng":"-0.8694584","type":["Prison"],"name_variations":[]},{"name":"HMP Frankland","town":"Durham","lat":"54.8064867","lng":"-1.549427","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Foston Hall","town":"Derby","lat":"52.8822614","lng":"-1.7253463","type":["Prison"],"name_variations":["HMP Foston Hall","HMP\/YOI Foston Hall","HMYOI Foston Hall"]},{"name":"HMP\/YOI Forest Bank","town":"Manchester","lat":"53.5141255","lng":"-2.3018486","type":["Prison"],"name_variations":["HMP Forest Bank","HMP & YOI Forest Bank","HMYOI Forest Bank"]},{"name":"HMP Ford","town":"Arundel","lat":"50.8163776","lng":"-0.5797947","type":["Prison"],"name_variations":[]},{"name":"HMYOI Feltham","town":"Feltham","lat":"51.4415566","lng":"-0.4340565","type":["Prison","Youth Custody"],"name_variations":["HMP Feltham","HMP Feltham A","HMP Feltham B","HMP\/YOI Feltham","HMP\/YOI Feltham A","HMP\/YOI Feltham B","HMP & YOI Feltham","HMP & YOI Feltham A","HMP & YOI Feltham B","HMYOI Feltham A","HMYOI Feltham B"]},{"name":"HMP Featherstone","town":"Wolverhampton","lat":"52.647414","lng":"-2.109806","type":["Prison"],"name_variations":[]},{"name":"HMP Exeter","town":"Exeter","lat":"50.7281917","lng":"-3.5320495","type":["Prison"],"name_variations":["HMP\/YOI Exeter","HMP & YOI Exeter","HMYOI Exeter"]},{"name":"HMP Erlestoke","town":"Devizes","lat":"51.2833485","lng":"-2.0430271","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Elmley","town":"Eastchurch","lat":"51.3884","lng":"0.8499","type":["Prison"],"name_variations":["HMP Elmley","HMP & YOI Elmley","HMYOI Elmley"]},{"name":"HMP\/YOI Eastwood Park","town":"Wotton-under-Edge","lat":"51.63504709999999","lng":"-2.468383","type":["Prison"],"name_variations":["HMP Eastwood Park","HMP & YOI Eastwood Park","HMYOI Eastwood Park"]},{"name":"HMP\/YOI East Sutton Park","town":"Maidstone","lat":"51.2152872","lng":"0.6161008","type":["Prison"],"name_variations":["HMP East Sutton Park","HMP & YOI East Sutton Park","HMYOI East Sutton Park"]},{"name":"HMP Durham","town":"Durham","lat":"54.7729047","lng":"-1.5679581","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Drake Hall","town":"Stafford","lat":"52.87726","lng":"-2.2425361","type":["Prison"],"name_variations":["HMP Drake Hall","HMP & YOI Drake Hall","HMYOI Drake Hall"]},{"name":"HMP\/YOI Downview","town":"Sutton","lat":"51.3384631","lng":"-0.1880442","type":["Prison"],"name_variations":["HMP Downview","HMP & YOI Downview","HMYOI Downview"]},{"name":"HMP Dovegate","town":"Uttoxeter","lat":"52.8707594","lng":"-1.7822721","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Doncaster","town":"Doncaster","lat":"53.5246134","lng":"-1.1459719","type":["Prison"],"name_variations":["HMP Doncaster","HMP & YOI Doncaster","HMYOI Doncaster"]},{"name":"HMP\/YOI Deerbolt","town":"Barnard Castle","lat":"54.5432115","lng":"-1.9367631","type":["Prison"],"name_variations":["HMP & YOI Deerbolt","HMYOI Deerbolt"]},{"name":"HMP Dartmoor","town":"Yelverton","lat":"50.5495271","lng":"-3.9963275","type":["Prison"],"name_variations":[]},{"name":"HMYOI Cookham Wood","town":"Rochester","lat":"51.3647454","lng":"0.4945179","type":["Youth Custody"],"name_variations":["HMP Cookham Wood","HMP\/YOI Cookham Wood","HMP & YOI Cookham Wood"]},{"name":"HMP Coldingley","town":"Woking","lat":"51.3217467","lng":"-0.6432669","type":["Prison"],"name_variations":[]},{"name":"HMP Chelmsford","town":"Chelmsford","lat":"51.7361324","lng":"0.4860732999999999","type":["Prison"],"name_variations":[]},{"name":"HMP Channings Wood","town":"Newton Abbot","lat":"50.5104924","lng":"-3.6518204","type":["Prison"],"name_variations":[]},{"name":"HMP Cardiff","town":"Cardiff","lat":"51.4810689","lng":"-3.1683326","type":["Prison"],"name_variations":["HMP\/YOI Cardiff","HMP & YOI Cardiff","HMYOI Cardiff"]},{"name":"HMP Bure","town":"Norwich","lat":"52.759454","lng":"1.3458199","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Bullingdon","town":"Bicester","lat":"51.8491718","lng":"-1.0942866","type":["Prison"],"name_variations":["HMP Bullingdon","HMP\/YOI Bullingdon","HMYOI Bullingdon"]},{"name":"HMP Buckley Hall","town":"Rochdale","lat":"53.63372949999999","lng":"-2.1439747","type":["Prison"],"name_variations":[]},{"name":"HMP & YOI Bronzefield (F)","town":"Ashford","lat":"51.433082","lng":"-0.4832205","type":["Prison"],"name_variations":["HMP Bronzefield","HMP\/YOI Bronzefield (F)","HMYOI Bronzefield (F)"]},{"name":"HMP Brixton","town":"London","lat":"51.45184339999999","lng":"-0.1225619","type":["Prison"],"name_variations":[]},{"name":"HMP Bristol","town":"Bristol","lat":"51.4805314","lng":"-2.5906347","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Brinsford","town":"Wolverhampton","lat":"52.6505566","lng":"-2.1103004","type":["Prison"],"name_variations":["HMP Brinsford","HMP & YOI Brinsford","HMYOI Brinsford"]},{"name":"HMP Birmingham","town":"Birmingham","lat":"52.492599","lng":"-1.9384596","type":["Prison"],"name_variations":[]},{"name":"HMP Berwyn","town":"Wrexham","lat":"53.0371997","lng":"-2.9293691","type":["Prison"],"name_variations":[]},{"name":"HMP Belmarsh","town":"London","lat":"51.4961652","lng":"0.0932264","type":["Prison"],"name_variations":["HMP\/YOI Belmarsh","HMP & YOI Belmarsh","HMYOI Belmarsh"]},{"name":"HMP Bedford","town":"Bedford","lat":"52.1389661","lng":"-0.4696008999999999","type":["Prison"],"name_variations":["HMP\/YOI Bedford","HMP & YOI Bedford","HMYOI Bedford"]},{"name":"HMP & YOI Aylesbury","town":"Aylesbury","lat":"51.8225809","lng":"-0.8016525999999999","type":["Prison"],"name_variations":["HMYOI Aylesbury","HMP\/YOI Aylesbury"]},{"name":"HMP & YOI Askham Grange","town":"Askham Richard","lat":"53.92590879999999","lng":"-1.1841372","type":["Prison"],"name_variations":["HMP Askham Grange","HMP\/YOI Askham Grange","HMYOI Askham Grange"]},{"name":"HMP Ashfield","town":"Bristol","lat":"51.4826555","lng":"-2.4384163","type":["Prison"],"name_variations":[]},{"name":"HMP\/YOI Altcourse","town":"Liverpool","lat":"53.4609347","lng":"-2.9359817","type":["Prison"],"name_variations":["HMP Alcourse","HMP & YOI Altcourse","HMYOI Altcourse"]}]';
		$locations = json_decode($data, true);

		$list = [];
		foreach ($locations as $location) {
			if (strpos($title,$location["name"]) !== false) {
				$list[] = $location["name"];
			} else {
				foreach ($location["name_variations"] as $alias) {
					if (strpos($title,$alias) !== false) {
						$list[] = $location["name"];
					}
				}
			}
		}
		if (count($list) > 0) return 'data-location-id="'.implode(" ",$list).'"';
	}
