<?php
/**
 * Fitness Functions
 */
add_filter('show_admin_bar', '__return_false');
//load jquery
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.10.2.min.js', false, null);
   wp_enqueue_script('jquery');
}
/**
 * Enqueue scripts and styles. 
 */
function fitness_scripts() {
	//style
  wp_enqueue_style( 'fitness-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
  wp_enqueue_style( 'fitness-animate', get_template_directory_uri() . '/css/animate.css' );
  wp_enqueue_style( 'fitness-elements', get_template_directory_uri().'/css/elements.css' );
  wp_enqueue_style( 'fitness-custom', get_template_directory_uri().'/css/custom.css' );
  wp_enqueue_style( 'fitness-fontawesome', get_template_directory_uri().'/fonts/font-awesome-4.0.3/css/font-awesome.min.css' );
  wp_enqueue_style( 'fitness-slider', get_template_directory_uri().'/css/slider.css' );
  wp_enqueue_style( 'fitness-isotope', get_template_directory_uri().'/css/isotope.css' );
  wp_enqueue_style( 'fitness-style', get_stylesheet_uri() );

	//script
  wp_enqueue_script('jquery-bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery') );
  wp_enqueue_script('jquery-custom', get_template_directory_uri().'/js/custom.js', array('jquery') );
  wp_enqueue_script( 'jquery-scroll', get_template_directory_uri() . '/js/scrolltopcontrol.js', array('jquery') );
  wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery') );
  wp_enqueue_script( 'jquery-slider', get_template_directory_uri() . '/js/bootstrap-slider.js', array('jquery') );
  wp_enqueue_script( 'jquery-countdown', get_template_directory_uri() . '/js/jquery.countdown.js', array('jquery') );
  wp_enqueue_script( 'jquery-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery') );
  wp_enqueue_script( 'jquery-ellipsis', get_template_directory_uri() . '/js/jquery.ellipsis.js', array('jquery') );
  wp_enqueue_script( 'facebook-script', get_template_directory_uri() . '/js/facebook-script.js', array('jquery') );


}

add_action( 'wp_enqueue_scripts', 'fitness_scripts' );


add_filter( 'wp_title', 'filter_wp_title' );
/**
 * Filters the page title appropriately depending on the current page
 *
 * This function is attached to the 'wp_title' fiilter hook.
 *
 * @uses  get_bloginfo()
 * @uses  is_home()
 * @uses  is_front_page()
 */
function filter_wp_title( $title ) {
  global $page, $paged, $current_user;

  if ( is_feed() )
    return $title;

  $site_description = "Fitness Meet Purpose";

  $filtered_title = ( $title == 'User | ' ) ? $current_user->user_firstname . ' | ' . get_bloginfo( 'name' ) : $title . get_bloginfo( 'name' );
  $filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
  $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';

  return $filtered_title;
}



//mailer function
function introMailer($recipient, $subject, $body) {
require get_template_directory() . '/class.phpmailer.php';

    $mail = new PHPMailer;
    
    $mail->IsSMTP();                                       
    $mail->Host       = "email-smtp.us-east-1.amazonaws.com";
    $mail->Username   = "AKIAJCUBVOQHISPCDOTQ";
    $mail->Password   = "AoJH714nQ2f+jqjB3ixnLfi0RQtYFEOwilj/IL3jNx74";
    $mail->SMTPDebug   = 0;
    $mail->SMTPAuth = true;                                                  
    $mail->Priority = 1;   
    $mail->SMTPSecure = 'tls';   
    $mail->Port = 587;                        
    
    $mail->From = 'tyler.smith.la@gmail.com';
    $mail->FromName = get_bloginfo('name');
    $mail->AddAddress($recipient);  
  

    $mail->WordWrap = 50;                              
    $mail->IsHTML(true);                                  
    
    $mail->Subject = $subject;
    $mail->Body    = $body;
    
    if(!$mail->Send()) {
       $errors = 'Message could not be sent.';
       $errors = 'Mailer Error: ' . $mail->ErrorInfo;
       $return_arrs["test"] = $errors;
       echo json_encode($return_arrs);
       exit;
    }
    
}


add_action( 'template_redirect', 'wpse8170_activate_user' );
function wpse8170_activate_user() {
    $page = get_page_by_title( 'activate' );
    if ( is_page() && get_the_ID() == $page->ID ) {
        $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
        if ( $user_id ) {
            $code = get_user_meta( $user_id, 'has_to_be_activated', true );
            if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                wp_update_user( array( 'ID' => $user_id, 'role' => 'author' ) );
                delete_user_meta( $user_id, 'has_to_be_activated' );
                $user_info = get_userdata($user_id);
                $user_info->remove_cap( 'pending');
                wp_redirect( home_url() . '/sign-in?setup=ok' ); exit;

            }
        }
    }
}




//USER LOGIN AUTHENTICATION

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) { 
    add_action('init', 'ajax_login_init');
}

function ajax_login_init(){

wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url() . '/user',
        'redirecturladmin' => home_url() . '/wp-admin',
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

function ajax_login(){

    check_ajax_referer( 'ajax-login-nonce', 'security' );

    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );

    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...'), 'role'=> $user_signon->roles[0]));


    }

    die();
}


//USER SIGN UP AUTHENTICATION

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) { 
    add_action('init', 'ajax_signup_init');
}

function ajax_signup_init(){

wp_register_script('ajax-signup-script', get_template_directory_uri() . '/js/ajax-signup-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-signup-script');

    wp_localize_script( 'ajax-signup-script', 'ajax_signup_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        'template_url' => get_bloginfo('template_url')
    )); 

    add_action( 'wp_ajax_nopriv_ajaxsignup', 'ajax_signup' );
}

function ajax_signup(){

    check_ajax_referer( 'ajax-signup-nonce', 'security' );
    
    $default_newuser = array(
        'user_pass' =>  $_POST['user_pass'],
        'user_login' => $_POST['user_name'],
        'user_email' => $_POST['user_email'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'role' => 'pending'
    );
    $user_id = wp_insert_user($default_newuser);
    $user_details["exercise_alert"] = "1";
    $user_details["routine_alert"] = "1";
    add_user_meta( $user_id,  'user_details', $user_details );
     if ( $user_id && !is_wp_error( $user_id ) ) {
        $code = sha1( $user_id . time() );
        $page = get_page_by_title( 'activate' );
        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink($page->ID));
        add_user_meta( $user_id, 'has_to_be_activated', $code, true );
        $email_subject = 'Fitness Cake Account Verification';
        $email_content = 'Hi '.$_POST['first_name'].' '.$_POST['last_name'].', <br/><br/>Thank you for signing up with Fitness Cake!<br/><br/>Please click the following link to complete your verification: <br/><br/>'.$activation_link.'<br/><br/>If you cannot click on the link just copy/paste it to your browser.<br/><br/>Best Wishes, <br/><br/>The Fitness Cake Team'; 
        introMailer($_POST['user_email'],nl2br($email_subject),$email_content);
    }

}



//Facebook Integration Station

if (!is_user_logged_in()) { 
    add_action('init', 'ajax_facebook_init');
}

function ajax_facebook_init(){
wp_register_script('ajax-facebook-script', get_template_directory_uri() . '/js/ajax-facebook-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-facebook-script');

    wp_localize_script( 'ajax-facebook-script', 'ajax_facebook_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        'template_url' => get_bloginfo('template_url'),
        'redirecturl' => home_url() . '/user'
    )); 

    add_action( 'wp_ajax_nopriv_ajaxfacebook', 'ajax_facebook' );
}

function ajax_facebook(){
global $blog_id;
  check_ajax_referer( 'fb-security', 'security' );
    
    $fbuser = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'user_email' => $_POST['user_email'],
        'id' => $_POST['id']
    );


    if( !email_exists( $fbuser['user_email'] ) ) {
    
    $wp_user_id = wp_create_user( $fbuser['user_email'], md5( ( $fbuser['id'] . $fbuser['user_email'] ) ), $fbuser['user_email'] );
    $user = new WP_User( $wp_user_id );
    $user->set_role( 'author' );
    $user_details["exercise_alert"] = "1";
    $user_details["routine_alert"] = "1";
    add_user_meta( $wp_user_id,  'user_details', $user_details );
    add_user_meta( $wp_user_id, 'primary_blog', $blog_id);

    if ( is_wp_error( $wp_user_id ) ) {
      $error_message = $wp_user_id->get_error_code();
    }
    else {
      update_user_meta( $wp_user_id, 'first_name', $fbuser['first_name'] ); 
      update_user_meta( $wp_user_id, 'last_name', $fbuser['last_name'] );

      $creds['user_login'] = $fbuser['user_email'];
      $creds['user_password'] = md5( ( $fbuser['id'] . $fbuser['user_email'] ) );
      $creds['remember'] = true;

      $wp_user = wp_signon( $creds, false );

      if ( is_wp_error( $wp_user ) ) {
        $error_message = $wp_user->get_error_code();
      }

      echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));

      exit;
    }
  }
  else {
    $user_obj = get_user_by( 'email', $fbuser['user_email'] );

    $creds['user_login'] = $user_obj->data->user_login;
    $creds['user_password'] = md5( ($fbuser['id'] . $fbuser['user_email']) );
    $creds['remember'] = true;

    $wp_user = wp_signon( $creds, false );

    if ( is_wp_error( $wp_user ) ) {
      //$error_message = $wp_user->get_error_code();
      echo json_encode(array('loggedin'=>false, 'message'=>__('Login failed. This email is associated with another account.')));
      exit;
    }

    echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    exit;
  
}



        
 die();
}




function user_setup_warning(){
  echo  '<div class="alert alert-danger" role="alert">
  <strong><span class="glyphicon glyphicon-warning-sign"></span></strong> Please answer the account setup questions <a href="'.esc_url( home_url( '/setup' ) ).'">here</a> so we can build your fitness plan. Until then our hands are tied!
</div>';
}

function user_setup(){
  echo  '<div class="alert alert-success" role="alert">
  Your account has been created! You can now sign in. 
</div>';
}


function hide_personal_options(){
echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";
}
add_action('admin_head','hide_personal_options');



include(get_template_directory() . "/inc/fitness_plan.php");

include_once 'metaboxes/setup.php';

include_once 'metaboxes/home-spec.php'; 



if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
    // Display trackbacks differently than normal comments.
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
  <?php
      break;
    default :
    // Proceed with normal comments.
    global $post;
  ?>
<div class="comment">
<div class="media">

              <div class="media-body">
                <p><?php  printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
            get_comment_author_link(),
            // If current post author is also comment author, make it known visually.
            ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
          );?></p>
                <p> <?php comment_text(); ?></p>
                <ul class="text-muted list-inline">
                  <li><i class="fa fa-clock-o"></i> <?php
          printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            /* translators: 1: date, 2: time */
            sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
          );
        ?></li>
        <li>
        <?php if ( '0' == $comment->comment_approved ) : ?>
       <i class="fa fa-asterisk"></i> <?php _e( 'Awaiting moderation.', 'twentytwelve' ); ?>
      <?php endif; ?>
        </li>

                </ul>
              </div>
            </div>
            </div>
        
     

      

       

      
  <?php
    break;
  endswitch; // end comment_type check
}
endif;


function add_opengraph_nameser( $output ) {
 return $output . '
xmlns:og="http://opengraphprotocol.org/schema/"
xmlns:fb="http://www.facebook.com/2008/fbml"';
 }
add_filter('language_attributes', 'add_opengraph_nameser');



// Get featured image
function ST4_get_FB_image($post_ID) {
    global $exercises; 

    $vid_meta =  $exercises->the_meta($post_ID); 

    if (!empty($vid_meta['vidthumb'])) {
        return $vid_meta['vidthumb'];
    }
}
 
// Get post excerpt
function ST4_get_FB_description($post) {

    global $exercises; 

    $desc_meta =  $exercises->the_meta($post);

    if (!empty($desc_meta['description'])) {
        return $desc_meta['description'];
    }

}

function ST4FB_header() {
    global $post;
    $post_description = ST4_get_FB_description($post);
    $post_featured_image = ST4_get_FB_image($post->ID);
    if ( (is_single()) AND ($post_featured_image) AND ($post_description) ) {
?>
  <meta property="og:url" content="<?php the_permalink(); ?>" />
  <meta property="og:title" content="<?php echo $post->post_title; ?>" />
  <meta property="og:description" content="<?php echo $post_description; ?>" />
  <meta property="og:image" content="<?php echo $post_featured_image; ?>" />
<?php
    }
}

add_action('wp_head', 'ST4FB_header');

/**
  * Support for multiple post types for comments
  *
  * @param array $clauses
  * @param object $wpqc WP_Comment_Query
  * @return array $clauses
  */   
 function wpse_121051( $clauses, $wpqc )
 {
    global $wpdb;

    // Remove the comments_clauses filter, we don't need it anymore. 
    remove_filter( current_filter(), __FUNCTION__ );

    // Add the multiple post type support.
    if( isset( $wpqc->query_vars['post_type'][0] ) )
    {

        $join = join( "', '", array_map( 'esc_sql', $wpqc->query_vars['post_type'] ) );

        $from = "$wpdb->posts.post_type = '" . $wpqc->query_vars['post_type'][0] . "'";                         
        $to   = sprintf( "$wpdb->posts.post_type IN ( '%s' ) ", $join );

        $clauses['where'] = str_replace( $from, $to, $clauses['where'] );
    }  

    return $clauses;
 }

add_filter( 'comments_clauses', 'wpse_121051', 10, 2 );   


//jesse (editor) provisioning = make it easier
if (( current_user_can( 'edit_posts' )) && ( !current_user_can( 'activate_plugins' ))) {
  
function remove_menus_editor(){
 //menu items 
remove_menu_page( 'upload.php' ); 
remove_menu_page( 'edit.php' );
remove_menu_page( 'tools.php' );
remove_menu_page( 'edit.php?post_type=page' );
 //dashboard meta
remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); 
remove_meta_box('dashboard_primary', 'dashboard', 'normal'); 
}
add_action( 'admin_menu', 'remove_menus_editor' );


//At a Glance - custom post types 
function add_custom_post_counts() {
   $post_types = array('exercises_single'); // array of custom post types to add to 'At A Glance' widget
   foreach ($post_types as $pt) :
      $pt_info = get_post_type_object($pt); // get a specific CPT's details
      $num_posts = wp_count_posts($pt); // retrieve number of posts associated with this CPT
      $num = number_format_i18n($num_posts->publish); // number of published posts for this CPT
      $text = _n( $pt_info->labels->singular_name, $pt_info->labels->name, intval($num_posts->publish) ); // singular/plural text label for CPT
      echo '<li class="exercise-count '.$pt_info->name.'-count"><a href="edit.php?post_type='.$pt.'">'.$num.' '.$text.'</a></li>';
   endforeach;

   $routines = array('routines_single'); // array of custom post types to add to 'At A Glance' widget
   foreach ($routines as $routine) :
      $routine_info = get_post_type_object($routine); // get a specific CPT's details
      $routine_num_posts = wp_count_posts($routine); // retrieve number of posts associated with this CPT
      $routine_num = number_format_i18n($routine_num_posts->publish); // number of published posts for this CPT
      $routine_text = _n( $routine_info->labels->singular_name, $routine_info->labels->name, intval($routine_num_posts->publish) ); // singular/plural text label for CPT
      echo '<li class="routine-count '.$routine_info->name.'-count"><a href="edit.php?post_type='.$routine.'">'.$routine_num.' '.$routine_text.'</a></li>';
   endforeach;
   $user_query = new WP_User_Query( array( 'role' => 'Author' ) );
   $followers = $user_query->query_vars['count_total'] == '1' ? 'Follower' : 'Followers';
  echo '<li class="follower-count"><a href="#">'.$user_query->query_vars['count_total'].' '.$followers.'</a></li>';

}
add_action('dashboard_glance_items', 'add_custom_post_counts');

function cpad_at_glance_icons() {
    echo '<style type="text/css">
        .routine-count a:before {content:"\f163"!important}
        .exercise-count a:before {content:"\f507"!important}
        .follower-count a:before {content:"\f307"!important}
        .post-count, .page-count, #wp-version-message, #wp-admin-bar-new-content, .fade, #wp-admin-bar-wp-logo{display:none !important;}
        </style>';


}
add_action('admin_head', 'cpad_at_glance_icons');


//remove screen options
  function remove_screen_options(){ __return_false;}
  add_filter('screen_options_show_screen', 'remove_screen_options');


if (is_user_logged_in()) { 
   add_action('admin_init', 'ajax_feedback_init');
}


//trainer feedback

function ajax_feedback_init(){
wp_enqueue_script('form_validation_feedback',  get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery') );
wp_register_script('ajax-feedback-script', get_template_directory_uri() . '/js/ajax-feedback-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-feedback-script');

    wp_localize_script( 'ajax-feedback-script', 'ajax_feedback_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        'template_url' => get_bloginfo('template_url')
    )); 

    add_action( 'wp_ajax_ajaxfeedback', 'ajax_feedback' );
}

function ajax_feedback(){

    //check_ajax_referer( 'ajax-signup-nonce', 'security' );
    
    $feedback_message = array(
        'user_name' =>  $_POST['username'],
        'blog' => $_POST['blog'],
        'message' => $_POST['message'],
    );

        $email_subject = $feedback_message['user_name'] . ' ('. $feedback_message['blog'] . ')';
        $email_content = $feedback_message['message'];
        introMailer('tyler.smith.la@gmail.com',nl2br($email_subject),$email_content);
  
  echo json_encode(array('sent'=>true));


  die();
}

function fitness_trainer_feedback() {

  wp_add_dashboard_widget(
                 'feedback_dashboard_widget',
                 'Fitness Cake Feedback',
                 'trainer_feedback_meta' 
        );  
}
add_action( 'wp_dashboard_setup', 'fitness_trainer_feedback' );

function trainer_feedback_meta() {
  global $current_user, $blog_id;
  echo '<div class="submit_success"></div>';

  echo "<p>Please send us suggestions, comments, critiques, etc.. This is our direct line.</p>";

  echo '<form id="trainerfeedback"  method="post"><input type="hidden" id="username" name="username" value="'.$current_user->user_login.'">';

  echo '<input type="hidden" id="blog" name="blog" value="'. $blog_id.'">';

  echo '<p><textarea rows="3" style="width:100%;" id="message" name="message" placeholder="Message"></textarea></p>';

  echo '<input type="submit" class="button button-primary button-large" id="submit" value="Send"></form>';

} 




}  //END editor provisioning



//backend logout redirect..
add_action('wp_logout',create_function('','wp_redirect(home_url());exit();'));

//media upload fix
//fixes for media uploader..
add_filter('get_media_item_args', 'allow_img_insertion');
function allow_img_insertion($vars) {
    $vars['send'] = true; // 'send' as in "Send to Editor"
    return($vars);
}

function enable_media_upload(){
    wp_enqueue_script('media-upload');
}

add_action( 'admin_menu', 'enable_media_upload' );

function custom_colors() {
   echo '<style type="text/css">
           .routine-has-error {
              border:1px solid #d9534f !important;
            }
            .error-routine{
              color: #d9534f !important;
            }
         </style>';
}

add_action('admin_head', 'custom_colors');

add_action('admin_footer', 'cpd_validator', 999);

function cpd_validator(){
    global $post_type;
    if($post_type == 'routines_single'){
        wp_enqueue_script('form_validation_2',  get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery') );
        wp_enqueue_script('routine_validation',  get_template_directory_uri() . '/js/routines-validate.js', array('jquery') );
    }
}

add_action( 'edit_form_top', 'myprefix_edit_form_after_title' );
function myprefix_edit_form_after_title() {
    echo '<div class="routine_post_alert"></div>';
}


function change_footer_admin () {
  echo '';
}
 
add_filter('admin_footer_text', 'change_footer_admin');

function my_footer_version() {
    return 'Fitness Cake';
}
add_filter( 'update_footer', 'my_footer_version', 11 );


//new exercise notifications
function exercise_alert() {
  global $post, $blog_id, $exercises;
  $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
  //alert for new post only!
  if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) ) {
  $alert_meta =  $exercises->meta["description"]; 
  $blogusers = get_users( 'blog_id='.$blog_id.'&role=author' );
    foreach ( $blogusers as $bloguser ) { 
      $notify_ok = get_user_meta($bloguser->ID, 'user_details');
      if($notify_ok[0] ["exercise_alert"] == "1"){
      $subject = $current_blog_details->blogname . " Added a New Exercise!";
      $user_meta = get_user_meta( $bloguser->ID ); 
      $body = "Hi ".$user_meta["first_name"][0].", <br/><br/>". $current_blog_details->blogname . " has added &quot;". get_the_title($post->ID) ."&quot; to the exercise section. <br/><br/>Exercise description: ".$alert_meta."<br/><br/>Click the following link to check it out: ".get_permalink($post->ID)."<br/><br/>If you cannot click on the link just copy/paste it to your browser.<br/><br/>Thanks, <br/><br/>The Fitness Cake Team<br/><br/><font style='font-size:.8em;'>You can unsubscribe to these notifications on your Fitness Cake Settings page</font>";



     // introMailer($bloguser->user_email, $subject, $body);

      
      }
   }
  }
}
add_action('publish_exercises_single','exercise_alert');

//new routine notifications
function routine_alert() {
  global $post, $blog_id, $routines, $routine_intended;

  $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
  //alert for new post only!
  if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) ) {
  $blogusers = get_users( 'blog_id='.$blog_id.'&role=author' );
    foreach ( $blogusers as $bloguser ) { 
      $notify_ok = get_user_meta($bloguser->ID, 'user_details');
      if($notify_ok[0] ["routine_alert"] == "1"){
      $subject = $current_blog_details->blogname . "Added a New Routine!";
      $user_meta = get_user_meta( $bloguser->ID );


      $body = "Hi ".$user_meta["first_name"][0].", <br/><br/>". $current_blog_details->blogname . " has added a new routine, &quot;". get_the_title($post->ID) ."&quot;. <br/><br/>Click the following link to check it out: ".get_permalink($post->ID)."<br/><br/>If you cannot click on the link just copy/paste it to your browser.<br/><br/>Thanks, <br/><br/>The Fitness Cake Team<br/><br/><font style='font-size:.8em;'>You can unsubscribe to these notifications on your Fitness Cake Settings page</font>";

         introMailer($bloguser->user_email, $subject, $body);
      }
    }
  }
}
add_action('publish_routines_single','routine_alert');

