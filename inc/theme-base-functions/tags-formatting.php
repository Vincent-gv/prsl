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

/* Tags formatting
=============================================*/
if ( ! function_exists( 'proradio_custom_tag_cloud_widget' ) ) {
	add_filter( 'widget_tag_cloud_args', 'proradio_custom_tag_cloud_widget' );
	add_filter( 'widget_tag_cloud_args', 'proradio_custom_tag_cloud_widget' );
	function proradio_custom_tag_cloud_widget($args) {
		$args['number'] = '26'; //adding a 0 will display all tags
		$args['largest'] = '12'; //largest tag
		$args['smallest'] = '12'; //smallest tag
		$args['unit'] = 'px'; //tag font unit
		return $args;
	}
}

