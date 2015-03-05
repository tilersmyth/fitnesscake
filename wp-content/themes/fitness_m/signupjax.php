 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');

//required for remote site until proper ajax is setup
//header("HTTP/1.1 200 OK");
	$contact = array();
	$contact["inputName"] = $_POST['name'];
	$contact["inputEmail"] = $_POST['email'];


	$subject = "New Trainer Submission";
	$body = "Name: " . $contact["inputName"] . "<br />E-Mail: " . $contact["inputEmail"];

	$email = 'tyler.smith.la@gmail.com';
	
	introMailer($email, $subject, $body);
	
?>