<?php
/*
Template Name: Activity
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
global $current_user; $user_details = get_user_meta($current_user->ID, 'user_details');
get_header('backend'); date_default_timezone_set('America/New_York'); ?>

   <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Your Activity</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="timeline-block">
          <!-- First blog post -->
            <div class="blog-summary">
              <h4>Leg Day</h4>
              <time datetime="2013-11-10" class="timestamp hidden-xs">Nov 10, 2013</time>
              <ul class="text-muted list-inline">
                <li><i class="fa fa-tachometer"></i> 14:46</li>
              </ul>
              <hr>
              <p class="blog-text">
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-ok"></span> Lunges: </li>
               <li>It went well</li>
               </ul>
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-ok"></span> Squats: </li>
               <li>I felt some lower back pain</li>
               </ul>
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-remove"></span> Calf Press: </li>
               <li>Too much pain</li>
               </ul>
                
              </p>

            </div>
            <!-- Second blog post -->
            <div class="blog-summary">
              <h4>Cardio</h4>
              <time datetime="2013-09-10" class="timestamp hidden-xs">Nov 09, 2013</time>
              <ul class="text-muted list-inline">
                <li><i class="fa fa-tachometer"></i> 11:36</li>
              </ul>
              <hr>
              <p class="blog-text">
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-ok exercise_activity_ok"></span> Spin: </li>
               <li>felt great afterwards</li>
               </ul>
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-ok exercise_activity_ok"></span> Jumping Jacks: </li>
               <li>i felt this in my back</li>
               </ul>
               <ul class="exercise_item">
               <li><span class="glyphicon glyphicon-ok exercise_activity_ok"></span> Stretch: </li>
               <li>Stretching went great. want to incorporate this into more routines.</li>
               </ul>
                
              </p>
            </div>
            
          </div>
        
        </div>
        <div class="col-sm-4">
      
          <div class="block-inverse">
            <div class="head-inverse">
              <div class="text-center">
                <strong class="text-muted">Consistency Score</strong>
                <h1 class="text-center text-green">95%</h1>
              </div>
            </div>
            <div class="body-inverse">
              <p class="text-center">
                <strong class="text-muted">Addtional Info</strong>
              </p>
              <div class="user-gallery text-center">
                
              </div>
            </div>
          </div>
          </div>

        
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>