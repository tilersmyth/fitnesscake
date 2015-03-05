<?php
/*
Template Name: Sign In
*/
if (is_user_logged_in()) { wp_redirect( home_url() . '/user' ); exit;}
get_header(); 
?>
<!-- Main body
================== -->
  <div class="wrapper wrapper-backend">
    <!-- Main Form -->
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Sign in</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container signin_container">
      <div class="row">
        <div class="col-sm-5 signin_container">
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
<?php get_footer('backend'); ?>