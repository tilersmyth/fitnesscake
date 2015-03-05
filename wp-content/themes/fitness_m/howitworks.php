<?php
/*
Template Name: How it works
*/
get_header(); ?>

<!-- Main body
================== -->
  <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="animated slideInLeft"><span>The Fitness Cake Platform</span></h1>
          </div>
        </div>
      </div>
    </div>
   <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="hl text-center top-zero">How it Works</h1>
          <p class="lead text-center">
            Just finished up a session with a client? Don't send them home with a workout regimen on piece of paper. Give them your custom Fitness Cake URL, which will have a workout routine waiting for them! Keep clients/future clients engaged!
          </p>
          <br />
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="team">
            <div class="member-left">
              <img src="<?php echo get_template_directory_uri(); ?>/img/fitnessscreen1.png" alt="Client Landing Page" class="left">
              <h2>Client Landing Page</h2>
              <p class="hiw-info">Once you sign up with Fitness Cake you are provided unique URL which lead to your login page. The login page provides information about your particular service and makes it easy for your followers to login.</p>
            </div>
            <div class="member-right">
              <img src="<?php echo get_template_directory_uri(); ?>/img/fitnessscreen2.png" alt="Client Dashboard" class="right">
              <h2>Client Dashboard</h2>
              <p class="hiw-info">A follower's dashboard shows information that is relevant to them, such as customized routines or public routines. The sidebar reveals new exercises that you have uploaded and any follower comments.</p>
            </div>
            <div class="member-left">
              <img src="<?php echo get_template_directory_uri(); ?>/img/fitnessscreen3.png" alt="Individual Exercise" class="left">
              <h2>Individual Exercise</h2>
              <p class="hiw-info">Followers have the ability to easily find exercises that meet their needs by searching keywords (tags). On this page, users will find descriptions, share on social media and express their thoughts through comments.</p>
            </div>
            <div class="member-right">
              <img src="<?php echo get_template_directory_uri(); ?>/img/fitnessscreen4.png" alt="Routine" class="right">
              <h2>Routine</h2>
              <p class="hiw-info">Fitness Cake routines are compiled exercises, which followers can move through at their own speed. Like the individual exercise page, followers can share, comment and learn more about the specific routine.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
        <p class="lead text-center">New features are being added daily! Get started and stay tuned with Fitness Cake to give your clients the most value!</p>
          <div class="about-btn">
            <a class="btn btn-success" href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Get started!</a> <a class="btn btn-default" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
</div>

<?php get_footer(); ?>