<?php

if( function_exists('get_field') ) {


$active = get_field('banner_active', 'option');

if($active) {
    ?>
    <div
        class="emergency-banner"
        style="
		background-color: #0b0c0c;
		color: #fff;
		padding: 2rem 3rem 3rem;
		border-bottom: 2px solid #f1f2f3;
	">
        <div style="
			max-width:960px;
			margin:0 auto;"
        >
            <div style="
				font-weight: bold;
				font-size: 48px;
				padding-bottom: 2rem;
			">
                <?php
                echo get_field('banner_title', 'option');
                ?>
            </div>
            <div style="
				padding-bottom: 2rem;
			">
                <?php
                echo get_field('banner_subtext', 'option');
                ?>
            </div>
            <?php
            $moreinfolink = get_field('banner_link_destination', 'option');
            if (isset($moreinfolink) && $moreinfolink != "") {
                ?>
                <div style="
				">
                    <a class="govuk-header__link emergency-banner-link" style="
						color:#fff;
						text-decoration:underline;
					"
                       href="
						<?php
                       echo get_field('banner_link_destination', 'option');
                       ?>
					">
                        More information
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}

} ?>
