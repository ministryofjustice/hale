<?php
/**
 * Template part for displaying document list item
 */
?>

<?php
    $expiry = $post -> job_closing_date;
    $now = time();

    if ($expiry > $now) {

        $title = get_the_title();
        $url = $post -> job_url;
        $salaryMin = $post -> job_salary_min;
        $salaryMax = $post -> job_salary_max;
        $salaryLdn = $post -> job_salary_london;
        $contractArray = get_the_terms( get_the_ID(), 'contract_type' );
        $addressObjectArray = get_the_terms( get_the_ID(), 'job_address' );
        $cityObjectArray = get_the_terms( get_the_ID(), 'job_city' );
        $regionObjectArray = get_the_terms( get_the_ID(), 'job_region' );

        // Format date
        $now = date("Y-m-d",$now);
        $today = new DateTime($now, new DateTimeZone('Europe/London'));
        $expiry = date("Y-m-d H:i:s",$expiry);
        $expiryDate = new DateTime("$expiry", new DateTimeZone('GMT'));
        $expiryDate->setTimezone(new DateTimeZone('Europe/London'));
        $dayDiff=date_diff($today,$expiryDate)->d;
        $monthDiff=date_diff($today,$expiryDate)->m;
        $yearDiff=date_diff($today,$expiryDate)->y;
        if ($yearDiff+$monthDiff == 0 && $dayDiff == 1) {
            $expiryDateField = "Tomorrow at ".date_format($expiryDate,"h:ia");
        } elseif ($yearDiff+$monthDiff+$dayDiff == 0) {
            $expiryDateField = "Today at ".date_format($expiryDate,"h:ia");
        } else {
            $expiryDateField = date_format($expiryDate,"h:ia") . " on " . date_format($expiryDate,"D j F ");
            if (date_format($expiryDate,"Y") > date_format($today,"Y")) {
                $expiryDateField .= date_format($expiryDate," Y");
            }
        }

        //Format salary
        $currencyFormat = numfmt_create( 'en_GB', NumberFormatter::CURRENCY );
        $currencyFormat -> setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        if (is_numeric($salaryMin)) {
            $min = numfmt_format_currency($currencyFormat, $salaryMin, "GBP");
            if (is_numeric($salaryMax) && $salaryMin != $salaryMax) {
                $max = numfmt_format_currency($currencyFormat, $salaryMax, "GBP");
                $salaryField = "$min to $max";
            } else {
                $salaryField = $min;
            }
            if (is_numeric($salaryLdn)) {
                $ldn = numfmt_format_currency($currencyFormat, $salaryLdn, "GBP");
                $salaryField .= " (plus $ldn London weighting allowance)";
            }
        } elseif ($salaryMin == "") {
            $salaryField = "TBC";
        } elseif ($salaryMin == $salaryMax) {
            $salaryField = $salaryMin;
        } else {
            $salaryField = $salaryMin . " " . $salaryMax;
        }

        //Contract type
        $contractField = "";
        foreach($contractArray as $contractObject) {
            $contractField .= $contractObject->name."<br />";
        }

        //Location handling
        $addressField = $cityField = $regionField = "";
        $cityArray = $regionArray = array();
        $showAddress = $showCity = true;

        foreach($addressObjectArray as $addressObject) {
            $addressField.=sanitizeAddress($addressObject -> name);
            $addressField.="<br />";
        }
        foreach($cityObjectArray as $cityObject) {
            $city=$cityObject -> name;
            array_push($cityArray,$city);
        }
        $cityArray = array_unique($cityArray);
        $cityField=join(" <br />",$cityArray);
        foreach($regionObjectArray as $regionObject) {
            $region=$regionObject -> name;
            array_push($regionArray,$region);
        }
        $regionArray = array_unique($regionArray);
        $regionField=join(" <br />",$regionArray);
        if (count($addressObjectArray) == 1) {
            if (strpos($addressField,$cityArray[0])) {
                // If there is only one address and it already contains the city, then we hide city field
                $showCity = false;
            }
        } elseif (count($addressObjectArray) > 1) {
            // If there are many addresses, we only shew cities
            $showAddress = false;
        }
        if (count($cityArray) > 4) {
            // We display up to this many cities before changing to "multiple locations"
            $cityField = "Multiple locations ";
        }
        if (str_contains(strtoupper($addressField.$cityField.$regionField),"NATIONAL")) {
            // If any field has "national" in it, we exclude all address information and just write "National"
            $showAddress = $showCity = false;
            $regionField = "National";
        }
    ?>


    <div class="job-list-item">
        <h2 class="job-list-item--title hale-heading-s">
            <a class="govuk-link" href="<?php printf($url);?>">
                <?php echo get_the_title(); ?>
            </a>
        </h2>
        <?php
            echo jobItemRowHTML("Salary",$salaryField);
            echo jobItemRowHTML("Contract type",$contractField);
            if ($showAddress) echo jobItemRowHTML("Address",$addressField);
            if ($showCity) echo jobItemRowHTML("Location",$cityField);
            echo jobItemRowHTML("Region",$regionField);
            echo jobItemRowHTML("Closing date",$expiryDateField);
        ?>
    </div>

    <?php
    }
