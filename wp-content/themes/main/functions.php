<?php

add_filter('show_admin_bar', '__return_false');

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery-1.10.2.min.js', false, null);
   wp_enqueue_script('jquery');
}
/**
 * Enqueue scripts and styles. 
 */
function fitness_scripts() {
	//style
  wp_enqueue_style( 'fitness-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
  wp_enqueue_style( 'fitness-magister', get_template_directory_uri() . '/assets/css/magister.css' );
  wp_enqueue_style( 'fitness-style', get_stylesheet_uri() );

	//script
  wp_enqueue_script('jquery-bootstrap', get_template_directory_uri().'/assets/js/bootstrap.min.js', array('jquery') );
  wp_enqueue_script('jquery-magister', get_template_directory_uri().'/assets/js/magister.js', array('jquery') );
  wp_enqueue_script('jquery-modernizr', get_template_directory_uri().'/assets/js/modernizr.custom.72241.js', array('jquery') );


}

add_action( 'wp_enqueue_scripts', 'fitness_scripts' );
