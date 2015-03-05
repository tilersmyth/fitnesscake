<?php 
//set default admin theme
add_filter( 'get_user_option_admin_color', function( $color_scheme ) {

global $_wp_admin_css_colors;

if ( 'classic' == $color_scheme || 'fresh' == $color_scheme ) {
  $color_scheme = 'light';
}

return $color_scheme;

}, 5 );
  
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
  global $blog_id;
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
   $user_query = new WP_User_Query( array( 'blog_id' => $blog_id, 'role' => 'Author' ) ); $users = $user_query->get_results(); $followers_total = count($users); 
   $followers = $followers_total  == '1' ? 'Follower' : 'Followers';
  echo '<li class="follower-count"><a href="#">'.$followers_total .' '.$followers.'</a></li>';
  echo '<li class="aag-share">Link to your Fitness Cake page: <span class="aag-share-link">'.get_bloginfo( 'url' ).'</span></li>';

}
add_action('dashboard_glance_items', 'add_custom_post_counts');

function cpad_at_glance_icons() {
    echo '<style type="text/css">
        .routine-count a:before {content:"\f163"!important}
        .exercise-count a:before {content:"\f507"!important}
        .follower-count a:before {content:"\f307"!important}
        .post-count, .page-count, #wp-version-message, #wp-admin-bar-new-content, .fade, #wp-admin-bar-wp-logo, #wp-admin-bar-my-sites{display:none !important;}
        .aag-share{width: 100% !important; float:left; font-size:12px; font-weight:bold}
        .aag-share-link{color:#0074a2}
        .aag-share-link:before {content:"\f103"!important}
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


add_action('admin_init', 'user_profile_fields_disable');
 
function user_profile_fields_disable() {
 
    global $pagenow;
 
    // apply only to user profile or user edit pages
    if ($pagenow!=='profile.php') {
        return;
    }
 
    add_action( 'admin_footer', 'user_profile_fields_disable_js' );
 
}
 
/**
 * Disables selected fields in Admin user profile (profile.ph)
 */
function user_profile_fields_disable_js() {
?>
    <script>
        jQuery(document).ready( function($) {
            $('#your-profile > h3').hide();
            $("#nickname,#display_name,#user_login,#url,#color-picker,#description").parent().parent().remove(); 
            $("#rich_editing,#comment_shortcuts").parent().parent().parent().remove();
            $("#admin_bar_front").parent().parent().parent().parent().remove(); 
        });
    </script>
<?php
}


add_action( 'admin_enqueue_scripts', 'enqueue_admin' );


//custom settings page

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
    $page = get_page_by_title( 'settings' );
    $profile_txt = get_post_meta( $page->ID, 'profile_txt' );
    $profile_image = get_post_meta( $page->ID, 'profile_image' );
    global $menu;
    add_menu_page( 'Settings', 'Settings', 'delete_pages', 'admin_settings.php', 'pg_building_function', 'dashicons-admin-generic', 65 );
    if (empty($profile_txt) || empty($profile_image)){
    $menu[60][0] .= " <span style='color:#d54e21' class='dashicons dashicons-flag' title='Requires attention!'></span>";
  }
}

function pg_building_function(){
  $page = get_page_by_title( 'settings' );
?>
  <style type="text/css">
    .fh-profile-upload-options th,
    .fh-profile-upload-options td,
    .fh-profile-upload-options input {
      vertical-align: top;
    }

    .user-preview-image {
      display: block;
      height: auto;
      width: 150px;
      float: left;
      margin-right: 20px;
    }

    #profile_txt{
      width: 33em;
    }

  </style>
<div class="wrap">
<h2>Settings</h2>
<div class="success_container"></div>
<form id="admin_settings">
<table class="form-table">
  <tbody>
    <tr>
 <th scope="row">Profile Picture</th>
 <td>
    <img class="user-preview-image" src="<?php $prof_image = get_post_meta( $page->ID, 'profile_image' ); echo $prof_image[0]; ?>">
        <input type="text" name="profile_image" id="image" value="<?php echo $prof_image[0]; ?>" class="regular-text" />
        <input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />

        <span class="description">Please upload an image for your profile.</span>
 </td>
</tr>
<th scope="row">Front Page Text</th>
 <td>
        <textarea name="profile_txt" rows="4" id="profile_txt"><?php $profile_txt = get_post_meta( $page->ID, 'profile_txt' ); echo $profile_txt[0]; ?></textarea><br />

        <span id="profile_desc" class="description">Character recommendation: 300 - 600. If over 400, recent activity will not display</span>
 </td>
</tr>
  <tr>
  <th scope="row">Show Follower Number</th>
  <?php $show_followers = get_post_meta( $page->ID, 'show_followers' ); ?>
  <td><label for="show_followers"><input type="checkbox" name="show_followers" id="show_followers" value="true" <?php echo $show_followers[0] == 'true' ? 'checked' : ''; ?>> Show number of followers on Front Page</label></td>
  </tr>
    <tr>
  <th scope="row">E-Mail Notifications</th>
  <?php $notify_newuser = get_post_meta( $page->ID, 'notify_newuser' );
        $notify_comment = get_post_meta( $page->ID, 'notify_comment' ); ?>
  <td><label for="notify_newuser"><input type="checkbox" name="notify_newuser" id="notify_newuser" value="true" <?php echo $notify_newuser[0] == 'true' ? 'checked' : ''; ?>> Send me an email when a new user joins my site</label><br/><br/>
      <label for="notify_comment"><input type="checkbox" name="notify_comment" id="notify_comment" value="true" <?php echo $notify_comment[0] == 'true' ? 'checked' : ''; ?>> Send me an email when a user comments on my site</label>

  </td>
  </tr>
  </tbody>
</table>
<input type='submit' class="button-primary" value="Update Settings" id="settingsupdate"/>
</form>
</div>
<?
echo '<script>jQuery(document).ready(function(){
jQuery("#profile_desc").after("<div id=\"count_contain\" class=\"description\"> Current count: <span id=\"excerpt_counter\"></span></div>");
     jQuery("#excerpt_counter").text(jQuery("#profile_txt").val().length);
     jQuery("#profile_txt").keyup( function() {
     jQuery("#count_contain").css("font-weight","bold");
     jQuery("#excerpt_counter").text(jQuery("#profile_txt").val().length);
     if((jQuery("#profile_txt").val().length) < 300){jQuery("#count_contain").css("color","#444");}
     if((jQuery("#profile_txt").val().length) > 300){jQuery("#count_contain").css("color","#3c763d");}
     if((jQuery("#profile_txt").val().length) > 700){jQuery("#count_contain").css("color","#a94442");}
   });
});</script>';
}

   add_action('admin_init', 'ajax_settings_init');


//admin settings ajax

function ajax_settings_init(){
wp_enqueue_script('form_validation_feedback',  get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery') );
wp_register_script('ajax-settings-script', get_template_directory_uri() . '/js/ajax-settings-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-settings-script');

    wp_localize_script( 'ajax-settings-script', 'ajax_settings_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        'template_url' => get_bloginfo('template_url')
    )); 

    add_action( 'wp_ajax_ajaxsettings', 'ajax_settings' );
}

function ajax_settings(){
    $page = get_page_by_title( 'settings' );
    //check_ajax_referer( 'ajax-signup-nonce', 'security' );
    
    $settings_message = array(
        'image' =>  $_POST['image'],
        'profile_txt' => $_POST['profile_txt'],
        'show_followers' => $_POST['show_followers'],
        'notify_newuser' => $_POST['notify_newuser'],
        'notify_comment' => $_POST['notify_comment'],
    );
    update_post_meta($page->ID, 'profile_image', $settings_message['image']);
    update_post_meta($page->ID, 'profile_txt', $settings_message['profile_txt']);
    update_post_meta($page->ID, 'show_followers', $settings_message['show_followers']);
    update_post_meta($page->ID, 'notify_newuser', $settings_message['notify_newuser']);
    update_post_meta($page->ID, 'notify_comment', $settings_message['notify_comment']);

  die();
}

function enqueue_admin()
{
  wp_enqueue_script( 'thickbox' );
  wp_enqueue_style('thickbox');

  wp_enqueue_script('media-upload');
}



function remove_media_library_tab($tabs) {
    unset($tabs['library']);
    unset($tabs['type_url']);
    return $tabs;
}
add_filter('media_upload_tabs', 'remove_media_library_tab');


//add business page

add_action( 'admin_menu', 'register_custom_page_business' );

function register_custom_page_business(){
    add_menu_page( 'Business', 'Business', 'delete_pages', 'business-settings.php', 'business_page_function', 'dashicons-chart-pie', 60 );
}

function business_page_function(){
 $page = get_page_by_title( 'settings' ); ?>
 <style type="text/css">
    #package_desc{
      width: 33em;
    }
    .pricing_title{
      margin-bottom: 0px !important;
    }
    #coupon_details_info{
      display: block;
    }
    .membership-alert{
      color: #a94442 !important;
    }

  </style>

<div class="wrap">
<h2>Business Settings</h2>
<div class="success_container"></div>
<form id="biz_settings">
<table class="form-table">
  <thead> 
  <tr>
  <?php $args = array( 'posts_per_page' => 1, 'post_type' => 'shop_coupon');
        $mycoupon = get_posts( $args ); $coupon_info = get_post_meta( $mycoupon[0]->ID);
        $get_membership = get_product_by_sku( 'k-1' );
        $enable_charge = get_post_meta( $get_membership->id, '_stock_status' ); ?>
        <th scope="row">Client Membership</th>
        <td><label for="enable_charge"><input type="checkbox" name="enable_charge" id="enable_charge" value="instock" <?php echo $enable_charge[0] == 'instock' ? 'checked' : ''; ?>> Charge your online clients a monthly fee</label>
        <br/><span class="description membership-alert" style="display: <?php echo $enable_charge[0] == 'instock' ? 'none' : ''; ?>">Your clients will have direct access to your content and not be charged!</span></td>
       </tr>
  </thead>
  <tbody id="cost_details">
  <?php  $member_meta = get_post_meta($get_membership->id,'_subscription_price'); ?>
  <tr><th scope="row"><h3 class="pricing_title">Pricing Details</h3></th></tr> 
        <tr>
        <th scope="row">Monthly Price ($)</th>
        <td><input type="number" name="monthly_price" id="monthly_price" placeholder="e.g. 5.90" step="any" min="0" value="<?php echo $member_meta[0]; ?>" class="regular-text" /></td>
       </tr>
        <tr>
        <th scope="row">Membership Name</th>
        <td><input type="text" name="package_name" id="package_name" value="<?php echo $get_membership->post->post_title; ?>" class="regular-text" /></td>
       </tr>
       <tr>
        <th scope="row">Membership Description</th>
        <td><textarea name="package_desc" rows="3" id="package_desc"><?php echo $get_membership->post->post_excerpt; ?></textarea></td>
       </tr>
       <tr>
        <th scope="row"><h3 class="pricing_title">Coupon (optional)</h3></th>
       </tr>
       <tr>
        <?php $enable_coupon = get_post_status( $mycoupon[0]->ID); ?>
        <th scope="row">Activate Coupon</th>
        <td><label for="activate_coupon"><input type="checkbox" name="activate_coupon" id="activate_coupon" value="true" <?php echo $enable_coupon == 'publish' ? 'checked' : ''; ?>> Allow new subscribers to enter coupon</label></td>
       </tr>
       <tr class="coupon_details">
        <th scope="row">Coupon Code</th>
        <td><input type="text" name="coupon_name" id="coupon_name" value="<?php echo $mycoupon[0]->post_title; ?>" class="regular-text" /><br/>
        <span class="description">Client will use this code to obtain discount</span></td>
       </tr>
       <tr class="coupon_details">
        <th scope="row">Coupon Details (%)</th>
        <td><div id="coupon_details_info">
            <input type="number" name="coupon_amt" id="coupon_amt" placeholder="e.g. 10" step="any" min="0" value="<?php echo $coupon_info['coupon_amount'][0]; ?>" class="regular-text" /><br/>
        <span class="description">Discount that will be applied upon signup</span>
        </div></td>
       </tr>
  </tbody>
</table>
<div class="error_container"></div>
<input type='submit' class="button-primary" value="Update Pricing" id="bizupdate"/>
</form>
</div>
<?php
echo '<script>jQuery(document).ready(function(){

    jQuery("#enable_charge").change(function(){
        if(this.checked) {
            jQuery("#cost_details").fadeIn("slow");
            jQuery(".membership-alert").hide();
        }else{
            jQuery("#cost_details").hide();
            jQuery(".membership-alert").show();
            

    }});
    jQuery("#activate_coupon").change(function(){
        if(this.checked)
            jQuery(".coupon_details").fadeIn("slow");
        else
            jQuery(".coupon_details").hide();

    });
    jQuery("input[type=checkbox]").change();
});</script>';

}

add_action('admin_init', 'ajax_pricing_init');

//admin settings ajax

function ajax_pricing_init(){
wp_register_script('ajax-pricing-script', get_template_directory_uri() . '/js/ajax-pricing-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-pricing-script');

    wp_localize_script( 'ajax-pricing-script', 'ajax_pricing_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        'template_url' => get_bloginfo('template_url')
    )); 

    add_action( 'wp_ajax_ajaxpricing', 'ajax_pricing' );
}

function ajax_pricing(){
    $get_membership = get_product_by_sku( 'k-1' );
    $page = get_page_by_title( 'settings' );
    //check_ajax_referer( 'ajax-signup-nonce', 'security' );
    
    $pricing_message = array(
        'enable_charge' =>  $_POST['enable_charge'],
        'monthly_price' => $_POST['monthly_price'],
        'package_name' => $_POST['package_name'],
        'package_desc' => $_POST['package_desc'],
        'activate_coupon' =>  $_POST['activate_coupon'],
        'coupon_name' =>  $_POST['coupon_name'],
        'coupon_amt' =>  $_POST['coupon_amt'],
        // 'notify_comment' => $_POST['notify_comment'],
    );

    if (($pricing_message['enable_charge']) == 'instock'){$enable_charge = 'instock';}else{$enable_charge = 'outofstock';}

    if (($pricing_message['activate_coupon']) == 'true'){$activate_coup = 'publish';}else{$activate_coup = 'draft';}

     //execute all pricing updates.. 
    update_post_meta($get_membership->id, '_stock_status', $enable_charge);
    update_post_meta($page->ID, 'activate_coupon', $pricing_message['activate_coupon']);
    update_post_meta($get_membership->id, '_subscription_price', $pricing_message['monthly_price']);
    $my_post = array('ID' => $get_membership->id, 'post_title' => $pricing_message['package_name'], 'post_exerpt' => $pricing_message['package_desc']);
    wp_update_post( $my_post );

    $args = array( 'posts_per_page' => 1, 'post_type' => 'shop_coupon', 'post_status' => 'any' );
    $mycoupon = get_posts( $args );
    $my_coupon = array('ID' => $mycoupon[0]->ID, 'post_title' => $pricing_message['coupon_name'], 'post_status' => $activate_coup);
    wp_update_post( $my_coupon );
   
    update_post_meta($mycoupon[0]->ID, 'coupon_amount', $pricing_message['coupon_amt']);

  die();
}
