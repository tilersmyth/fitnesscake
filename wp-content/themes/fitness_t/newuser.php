 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");
switch_to_blog($_POST['blog_id']);
$default_newuser = array(
        'user_pass' =>  $_POST['pass1'],
        'user_login' => $_POST['user_login'],
        'user_email' => $_POST['user_email'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'role' => 'pending'
    );
$user_id = wp_insert_user($default_newuser);


 if ( $user_id && !is_wp_error( $user_id ) ) {
        $code = sha1( $user_id . time() );
        $page = get_page_by_title( 'activate' );
        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink($page->ID));
        add_user_meta( $user_id, 'has_to_be_activated', $code, true );
        $email_subject = 'Fitness Cake Account Verification';
        $email_content = 'Hi '.$_POST['first_name'].' '.$_POST['last_name'].', <br/><br/>Thank you for signing up with Fitness Cake!<br/><br/>Please click the following link to complete your verification: <br/><br/>'.$activation_link.'<br/><br/>If you cannot click on the link just copy/paste it to your browser.<br/><br/>Best Wishes, <br/><br/>The Fitness Cake Team'; 
        introMailer($_POST['user_email'],nl2br($email_subject),$email_content);
    

    }


?>