 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_detail_meta = get_user_meta($current_user->ID, 'user_details');

$user_details = array();

$user_details["situation"] = $_POST['situation'];
$user_details["goal"] = $_POST['goal'];
$user_details["time_frame"] = $_POST['time_frame'];
$skype = $_POST['skype'] ? 'yes' : 'no';
$user_details["exercise_alert"] = $_POST['exercise_alert'];
$user_details["routine_alert"] = $_POST['routine_alert'];

if (empty($user_detail_meta)):
$user_details["skype"] = $skype;
$user_final = json_encode($user_details);
add_user_meta( $user_id, 'user_details', $user_details);
else:
$user_final = json_encode($user_details);
update_user_meta( $user_id, 'user_details', $user_details );
endif;

?>