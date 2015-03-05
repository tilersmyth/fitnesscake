 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");

$user_id = $_POST['close'];
add_user_meta( $user_id, 'welcome-alert', '1');
?>