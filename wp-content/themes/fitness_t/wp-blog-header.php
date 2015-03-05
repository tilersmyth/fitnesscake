<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */

if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	include '../../../wp-load.php';
	
	wp();

	include '../../../wp-includes/template-loader.php';

}
