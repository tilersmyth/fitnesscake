 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");

switch_to_blog($_POST['blog_id']);


$exercise_id = $_POST['exercise_id'];
$routine_ary = $_POST['rtn_array'];

$max_array = count($routine_ary);

$current_array = $routine_ary[$exercise_id];

 	//stop next if at end of array
	if (($exercise_id + 1) < $max_array) {
	    $keyAfter = $exercise_id + 1;
	}



$meta_values = get_post_meta( $current_array['target'], '_full_meta1'); 

$routine_info = array();	
$routine_info['rtn_array'] = $routine_ary;
$routine_info['id'] = $exercise_id;
$routine_info['title'] = get_the_title($current_array['target']);
$routine_info['recommend'] = $current_array['date'] . ' sets x ' . $current_array['time'];
$routine_info['next'] = $keyAfter;
$routine_info['ytID'] = $meta_values[0]['vidID'];





echo json_encode($routine_info);

?>