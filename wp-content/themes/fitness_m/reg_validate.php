 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");

//check username availability
if(!empty($_POST['user_login'])){
	 $username = $_POST['user_login'];
       if ( username_exists( $username ) )
           echo "false";
       else
           echo "true";
}

//check if email is already in use
if(!empty($_POST['user_email'])){
	 $email = $_POST['user_email'];
       if ( email_exists( $email ) )
           echo "false";
       else
           echo "true";
}






?>