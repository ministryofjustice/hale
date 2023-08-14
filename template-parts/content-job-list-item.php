<?php
/**
 * Template part for displaying document list item
 */
?>

<?php
    $expiry = $post -> job_closing_date;

    if ($expiry > $now) {

        $title = get_the_title();
        $url = $post -> job_url;
        $salaryMin = $post -> job_salary_min;
        $salaryMax = $post -> job_salary_max;
        $salaryLdn = $post -> job_salary_london;
        $contractType = get_the_taxonomies()["contract_type"];
        $address = get_the_taxonomies()["job_address"];
        $city = get_the_taxonomies()["job_city"];
        $region = get_the_taxonomies()["job_region"];

        // Format date
        $today = (new DateTime())->setTime(0,0);
        $date = new DateTimeImmutable();
        $expiryDate = $date->setTimestamp($expiry);
        $diff=date_diff($today,$expiryDate)->d;
        if ($diff == 1) {
            $expiryDateField = "Tomorrow";
        } elseif ($diff == 0) {
            $expiryDateField = "Today";
        } else {
            $expiryDateField = date_format($expiryDate,"j F Y") . " at " . date_format($expiryDate,"h:ia");
        }

        //Format salary
        $currencyFormat = numfmt_create( 'en_GB', NumberFormatter::CURRENCY );
        $currencyFormat -> setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        $min = numfmt_format_currency($currencyFormat, $salaryMin, "GBP");
        if (is_numeric($salaryMax) && $salaryMin != $salaryMax) {
            $max = numfmt_format_currency($currencyFormat, $salaryMax, "GBP");
            $salaryField = "$min &ndash; $max";
        } else {
            $salaryField = $min;
        }
        if (is_numeric($salaryLdn)) {
            $ldn = numfmt_format_currency($currencyFormat, $salaryLdn, "GBP");
            $salaryField .= " (plus $ldn London weighting allowance)";
        }
?>


<div class="job-list-item">
    <h2 class="job-list-item-title hale-heading-s">
        <a href="">
            <?php echo get_the_title(); ?>
        </a>
    </h2>
    <p>
        <strong>Expiry:</strong> <?php echo $expiryDateField; ?>
    </p>
    <p>
        <strong>Salary:</strong> <?php echo $salaryField; ?>
    </p>
    <p>
        <strong>Contract Type:</strong> <?php echo $contractType; ?>
    </p>
    <p>
        <strong>Address:</strong> <?php echo $address; ?>
    </p>
    <p>
        <strong>Town/city:</strong> <?php echo $city; ?>
    </p>
    <p>
        <strong>Region:</strong> <?php echo $region; ?>
    </p>
</div>

<?php
    }
?>
