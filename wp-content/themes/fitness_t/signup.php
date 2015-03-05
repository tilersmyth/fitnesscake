<?php
/*
Template Name: Sign up
*/

get_header();?>

<!-- Main body
================== -->

  <div class="wrapper">
    <!-- Page Tip -->
    <div class="page-tip animated slideInDown">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <p>Fill out the form below to sign up.</p>    
          </div>
        </div>
      </div>
    </div>
    <!-- Main Form -->
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 signup">
          <h3 class="hl top-zero">Easy Sign up!</h3>
          <div class="submit_success"></div>
          <hr>
          <form id="register" method="post">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <input type="text" class="form-control margin-bottom-xs" id="firstname" name="first_name" placeholder="First Name" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Enter your first name" data-original-title="First Name">
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Last Name" data-toggle="popover" data-trigger="focus" data-content="Enter your last name" data-original-title="Last Name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="username" name="user_login" placeholder="Username" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Enter desired username here." data-original-title="Username">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="useremail" name="user_email" placeholder="Enter email" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Enter a valid email here." data-original-title="Email">
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <input type="password" class="form-control margin-bottom-xs" name="pass1" id="password1" placeholder="Password" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Eight symbols minimum. Please use one digit" data-original-title="Password">
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control" id="password2" name="pass2" placeholder="Repeat Password" data-toggle="popover" data-trigger="focus" data-content="Make sure you still remember it." data-original-title="Repeat Password">
                </div>
              </div>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="terms"> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
              </label>
            </div>
            <?php //do_action('register_form'); ?>
            <div class="reg_btn_container">
            <button type="submit" id="submit" data-loading-text="Sending" class="btn btn-green reg_btn">Create an account</button>
            <div class="submit_error"></div>
            </div>
            <?php wp_nonce_field( 'ajax-signup-nonce', 'security' ); ?>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
jQuery.validator.addMethod(
        'digit',
        function (value) { 
            return /[0-9]/.test(value); 
        },  
        'Your password must contain at least one digit.'
    ); 
	
</script>


<?php get_footer(); ?>