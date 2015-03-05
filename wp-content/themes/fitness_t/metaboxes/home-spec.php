<?php
$exercises = new WPAlchemy_MetaBox(array
(
	'id' => '_full_meta1',
	'title' => 'Exercise Info',
	'types' => array('exercises_single'), 
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high',
	'template' => get_stylesheet_directory() . '/metaboxes/exercise_meta_value.php'
));


$routines = new WPAlchemy_MetaBox(array
(
	'id' => '_full_meta2',
	'title' => 'Routine Info',
	'types' => array('routines_single'), 
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high',
	'template' => get_stylesheet_directory() . '/metaboxes/routine_meta_value.php'
));

$routine_intended = new WPAlchemy_MetaBox(array
(
	'id' => '_full_meta3',
	'title' => 'Intended Client(s)',
	'types' => array('routines_single'), 
	'context' => 'side', // same as above, defaults to "normal"
	'priority' => 'low',
	'template' => get_stylesheet_directory() . '/metaboxes/routine_intended_meta_value.php'
));




/* eof */