<?php
/*
Name: copy_skin.php
Author: Tim Milligan
Description: Copies the seed data from one skin to another.  You can then generate a zip file for the new skin and distribute it normally.
Version: 2.0
*/

// Thesis 2 skin you're trying to generate the seed for:
$original_skin = 'thesis_classic';
$new_skin = 'test';

// Initialize arrays
$seed = array();
$items = array('boxes', 'templates', 'packages', 'snippets', 'vars', 'css', 'css_custom');

// Connect to WP
define('WP_USE_THEMES', false);
define('WP_DEBUG', false);
require('wp-blog-header.php');

foreach ($items as $item) {
	$seed[$item] = get_option(sprintf('%s_%s', $original_skin, $item), '');
	update_option(sprintf('%s_%s', $new_skin, $item), $seed[$item]);
}
echo "[$new_skin] seeded with [$original_skin] data.";