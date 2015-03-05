<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	
 <div class="wrapper">    
  <!-- Showcase
    ================ -->
    <div id="wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-7 col-sm-12">
            <h1 class="animated slideInDown search-title">Find your trainer</h1>
            <div class="list fitness-search">
              
             <?php $blog_title = get_bloginfo('url') . '/search'; ?>
             <form method="get" id="sul-searchform" action="<?php echo $blog_title; ?>">
                  <div class="input-group input-group-lg animated slideInLeft search-input-group">
                    <input type="text" class="form-control" name="t" placeholder="Search by name or email">
                    <span class="input-group-btn">
                      <button class="btn btn-turquoise" type="submit">Search</button>
                    </span>
                  </div><!-- /input-group -->
              </form>    

            </div>
          </div>
          <div class="col-md-5 hidden-sm hidden-xs">
            <div class="showcase">
              <img src="<?php echo get_template_directory_uri(); ?>/img/iMac.png" alt="..." class="iMac animated fadeInDown">
              <img src="<?php echo get_template_directory_uri(); ?>/img/iPad.png" alt="..." class="iPad animated fadeInLeft">
              <img src="<?php echo get_template_directory_uri(); ?>/img/iPhone.png" alt="..." class="iPhone animated fadeInRight">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <!-- Services
        ================ -->
      <div class="row">
        <div class="col-md-12">
          <div class="services">
            <ul>
                <li>
                  <i class="fa fa-cogs fa-3x"></i>
                  <p>How It Works<br /><a href="<?php echo esc_url( home_url( '/how-it-works' ) ); ?>">See why your clients/prospects will love Fitness Cake!</a></p>
                </li>
                <li>
                  <i class="fa fa-envelope fa-3x"></i>
                  <p>Contact<br /><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact us with any questions!</a></p>
                </li>
                <li>
                  <i class="fa fa-pencil-square fa-3x"></i>
                  <p>Sign up<br /><a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Start using Fitness Cake today!</a></p>
                </li>
            </ul>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Welcome message
            ================= -->
        <div class="col-md-7">
        <div class="block-header">
          <h2>
            <span class="title">Welcome to Fitness Cake</span><span class="decoration"></span><span class="decoration"></span><span class="decoration"></span>
          </h2>
        </div>
          <img src="<?php echo get_template_directory_uri(); ?>/img/main-img.jpg" class="img-about img-responsive" alt="About">
          <p class="index_intro">
            Fitness Cake makes it easy to stay connected with your existing clients and build your online presence.<br /><br /> Use your dedicated page to upload new exercises, build client specific routines and interact with your followers.    
            <br /><br />
           <a href="<?php echo esc_url( home_url( '/sign-up' ) ); ?>">Get started today!</a> 

          </p>

        </div>
        <!-- Last updated
            ================== -->
        <div class="col-md-5">
            <div id="testimonial_container">
                  <div id="testimonial_content"> 
                      <div id="testimonial_text">"My clients are located all over the place. Fitness Cake is making it much easier to stay connected and track progress."</div>
                  </div>
                  <div id="trainer_info">Jesse Ruiz, Personal Trainer<br/>Austin, TX<br/></div>
                  <div id="testimonial_img"><img src="<?php echo get_template_directory_uri(); ?>/img/trainer.png" class="img-responsive" alt="Jesse Ruiz"></div>
            </div>
      </div>
      </div>
      <!-- Recent Works
        =================== -->
     
      
    </div>
  </div>
<script>
  jQuery(document).ready(function($){
  $('.recent_vid_item').ellipsis({
    lines: 1,
    ellipClass: 'ellip',
    responsive: true
  });

  $('form#sul-searchform').each(function() { 

$(this).validate(
  {
  rules: {
    t: {
      required: true
    }
  },
  submitHandler: function (form) {form.submit();},
  errorPlacement: function(error,element) {
   
  }


  });});
  
  });
</script>

<?php get_footer(); ?>