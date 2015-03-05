<?php
/*
Template Name: Routines
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
get_header('backend'); global $current_user; ?>

<!-- Main body
================== -->
  <div class="wrapper wrapper-backend">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Routines</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">

      <div class="row">
        <div class="col-sm-12">
          <div class="btn-group" id="filters">
          <a href="#" class="btn btn-default" data-filter="*">All</a>
          
          </div>
        </div>
      </div>
      <ul class="row list-inline gallery-list" id="isotope-container">
      <?php query_posts( array( 'post_type' => 'routines_single', 'posts_per_page' => -1 ) );?>
            <?php if ( have_posts() ) : while (have_posts()) : the_post(); global $routines, $routine_intended, $authordata; 
            $meta =  $routines->the_meta(get_the_ID()); $exercise_list = $meta['routine']; $exercise_cnt = count($exercise_list);
            $author_role = $authordata->roles; $intended_meta = $routine_intended->the_meta(get_the_ID()); 
            $intended = array();
            //making sure this routine is intended for client
            foreach ($intended_meta['client'] as $intended_client){
            if ((in_array("all", $intended_client)) || (in_array($current_user->ID, $intended_client))){$intended[] = true;}}
            if($intended[0]): ?>
            <li class="isotope-item">
              <a href="<?php echo get_permalink(); ?>">
                <span class="gallery-text">
                  <span class="gallery-title routine_item_title"><?php the_title(); ?></span>
                  <hr class="routine_item">
                  <div class="routine_item_desc"><?php echo $meta['description']; ?></div>
                  <p><small><?php echo ($exercise_cnt == 1) ? $exercise_cnt . ' Exercise' : $exercise_cnt . ' Exercises'; ?></small></p>
                  <small class="routine_author">Created for <?php echo in_array("all", $intended_client) ? 'All Members' : $current_user->first_name; echo ' on ' . get_the_date('n/j/y'); ?></small>
                </span>
              </a>
            </li>
            <?php endif; endwhile; endif;   ?>
      </ul>
    </div>
  </div>
<script>
jQuery(document).ready(function($){
  $('.routine_item_desc').ellipsis({
    lines: 3,
    ellipClass: 'ellip',
    responsive: true
  });

$(window).on('load', function () {
  $('#isotope-container').isotope({ 
  itemSelector : '.isotope-item',
  layoutMode : 'fitRows'
  });
  var $container = $('#isotope-container');
  $container.isotope({
});
  $('#filters a').click(function(){ 
  var selector = $(this).attr('data-filter');
  $container.isotope({ filter: selector });
  return false;
});
 });

// Filtering

  
});
</script>

<?php get_footer('backend'); ?>