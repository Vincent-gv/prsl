<?php
/**
 * @package WordPress
 * @subpackage proradio
 * @version 1.0.0
*/
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

/* Creates a custom excerpt of titles
============================================= */
if(!function_exists('proradio_shorten')){
function proradio_shorten($string, $your_desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);
  $length = 0;
  $last_part = 0;
  $ellipsis = '';
  for (; $last_part < $parts_count; ++$last_part) {
	$length += strlen($parts[$last_part]);
	if ($length > $your_desired_width) {   $ellipsis = '...'; break; }
  }
  return implode(array_slice($parts, 0, $last_part)).$ellipsis;;
}}