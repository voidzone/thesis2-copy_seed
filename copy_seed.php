<?php
/*

Name: copy_skin.php
Author: Tim Milligan
Description: Copies the seed data from one skin to another.  You can then generate a zip file for the new skin and distribute it normally.
Version: 1.0

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
	$query = $wpdb->prepare('SELECT option_value FROM %3$s WHERE option_name = \'%1$s_%2$s\'', $original_skin, $item, $wpdb->options);
	//echo $query . "<br />\n";
	$seed[$item] = $wpdb->get_var($query);

	//fix potential serialization issues
	if(is_serialized($seed[$item])) {
		$seed[$item] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $seed[$item]);
		
	}
	$query = $wpdb->prepare('REPLACE INTO %4$s (option_name, option_value) VALUES (\'%1$s_%2$s\', \'%3$s\')', $new_skin, $item, $seed[$item], $wpdb->options);
	//echo $query . "<br />\n";
	$wpdb->query($query);
}
echo "$new_skin seeded with $original_skin data.";
