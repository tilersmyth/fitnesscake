<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

if ((!is_user_logged_in()) && ($_SERVER["HTTP_USER_AGENT"] !== "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)")) { wp_redirect( home_url() ); exit;}
global $current_user;
get_header('backend'); 


$post = $wp_query->post->post_type;

if ( 'exercises_single' == $post ) {

include(TEMPLATEPATH . '/single-exercise.php'); } 

elseif ( 'routines_single' == $post ) {

include(TEMPLATEPATH . '/single-routine.php'); } 

get_footer('backend');?>