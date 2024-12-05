<?php

// Disable saving ACF field groups to JSON to stop sync.
add_filter('acf/settings/save_json', '__return_false');
add_filter('acf/settings/load_json', '__return_false');