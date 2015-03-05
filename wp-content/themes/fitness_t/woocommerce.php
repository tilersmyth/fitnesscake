<?php
/*
Template Name: woo
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
get_header('backend');  ?>

 <div class="wrapper wrapper-backend">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="animated slideInLeft"><span><?php echo get_the_title(); ?></span></h1>
          </div>
        </div>
      </div>
    </div>
   <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="hl text-center top-zero"><?php echo get_the_title(); ?></h1>
          <br />
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <?php while ( have_posts() ) : the_post(); ?>
            <?php the_content(); ?>
          <?php endwhile; // end of the loop. ?>
         
        </div>
      </div>
      
    </div>
</div>

<?php get_footer('backend'); ?>