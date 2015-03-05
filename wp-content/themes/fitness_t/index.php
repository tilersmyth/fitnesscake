<?php
/**
 * Trainer page index
 */

if  ($_SERVER["HTTP_USER_AGENT"] !== "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)"){
if (is_user_logged_in()) { wp_redirect( home_url() . '/user' ); exit;}
}
get_header(); global $blog_id;
?>
<!-- Main body
================== -->
  <div class="wrapper wrapper-backend">

    <div class="container signin_container">
      <div class="row">
      <div class="col-sm-7 value_prop_wrapper">
        <div class="value_prop_container">
        <?php $settings = get_page_by_title( 'settings' );
        $show_followers = get_post_meta( $settings->ID, 'show_followers' );
        $profile_txt = get_post_meta( $settings->ID, 'profile_txt' );
        $profile_image = get_post_meta( $settings->ID, 'profile_image' ); ?>   
         <div class="value_prop_img_container">
            <div class="value_prop_img_container_inner">
            <img class="value_prop_img" src="<?php if(!empty($profile_image[0])){ echo $profile_image[0]; } ?>">
            </div>
         </div><!-- .value_prop_img -->
            <?php 
            $user_query = new WP_User_Query( array( 'blog_id' => $blog_id, 'role' => 'Author' ) ); $users = $user_query->get_results(); $followers_total = count($users); 
            $followers = $followers_total == '1' ? 'Client' : 'Clients';
            if ($show_followers[0] == 'true'){echo '<span class="label label-info label-followers">Training '.$followers_total.' '.$followers.' Online</span><br/>';}
            if(!empty($profile_txt[0])){ echo $profile_txt[0]; }  
            wp_reset_query(); ?>
            <?php if(strlen($profile_txt[0]) < 401): query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => 4 ) ); if ( have_posts() ) : ?>
                <div id="main_recent_vids">
                <div id="main_recent_vids_title">Recent Activity</div>
                <div id="main_recent_activity_container">
                <ul class="main_recent_activity">
                 <?php   while (have_posts()) : the_post(); global $exercises; 
                      $meta =  $exercises->the_meta(get_the_ID()); 

                      echo '<li><p class="recent_activty_img_time">'.get_the_title().'</p><img class="recent_activty_img" src="'.$meta["vidthumb"].'"><p class="recent_activty_img_time">'.human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'.'</p></li>';
  
                        endwhile;?>
                </ul>      
                </div>
                </div>

      <?php endif; endif; ?>
        </div> <!-- .value_prop_container -->
      </div> <!-- .col-md-6 -->
        <div class="col-sm-4 col-sm-offset-1 index_login">
        <div class="submit_error"></div>
        <?php if($_GET["setup"] == "ok"){ user_setup();} ?>
        
        <div class="fb-btn-container">
        <?php $ajax_nonce = wp_create_nonce( "fb-security" ); ?>
        <a class='btn btn-primary btn-lg' onclick='Login("<?php echo $ajax_nonce;?>" );'><i class="fa fa-facebook" style="margin-right:10px;"></i> Sign in with Facebook</a>  
        </div>
        <p class="apollo-seperator"> or </p>
          <form id="login" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            </div>
            <div class="reg_btn_container">
            <button type="submit" id="submit" data-loading-text="Loading" class="btn btn-default btn-lg reg_btn">Sign in</button>
            </div>
            <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
          </form>
          <div class="signup_text">
              Need an account? <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Sign up here</a>.
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  jQuery(document).ready(function($){
  $('.recent_activty_img_time').ellipsis({
    lines: 1,
    ellipClass: 'ellip',
    responsive: true
  });
  });
  </script>
<?php get_footer('backend'); ?>