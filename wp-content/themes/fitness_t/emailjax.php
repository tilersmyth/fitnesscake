 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');

//required for remote site until proper ajax is setup
//header("HTTP/1.1 200 OK");
	$contact = array();
	$contact["inputName"] = $_POST['name'];
	$contact["inputEmail"] = $_POST['email'];
	$contact["inputPhone"] = $_POST['phone'];
	$contact["inputMessage"] = $_POST['message'];


	if(!empty($contact["inputSubject"])){
	 	$subject = "<br />Subject: Contact Submission";
	 	}
	$subject = "Contact Submission";
	$body = "Name: " . $contact["inputName"] . "<br />E-Mail: " . $contact["inputEmail"] . "<br />Phone: " . $contact["inputPhone"] . "<br />Message: " . $contact["inputMessage"];

	$email = 'tyler.smith.la@gmail.com';
	
	introMailer($email, $subject, $body);
	
?>