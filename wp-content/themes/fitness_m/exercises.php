<?php
/*
Template Name: Exercises
*/
get_header(); ?>

<!-- Main body
================== -->
  <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Exercises</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">

      <div class="row">
        <div class="col-sm-12">
          <div class="btn-group" id="filters">
          <a href="#" class="btn btn-default" data-filter="*">All</a>
           <?php query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => -1 ) );?>
            <?php if ( have_posts() ) : while (have_posts()) : the_post();
              $tags_array = get_the_terms( get_the_ID(), 'tag');
              if (!empty($tags_array)):
              foreach ($tags_array as $tag_single):
                  $space_replace = str_replace(" ", "-", $tag_single->name);
                  echo '<a href="#" class="btn btn-default" data-filter=".'.$space_replace.'">'.$tag_single->name.'</a>';
             endforeach; endif; endwhile; endif; wp_reset_query(); ?>
          </div>
        </div>
      </div>
      <ul class="row list-inline gallery-list" id="isotope-container">
      <?php query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => -1 ) );?>
            <?php if ( have_posts() ) : while (have_posts()) : the_post(); global $exercises; 
            $meta =  $exercises->the_meta(get_the_ID());
            $tags = get_the_terms( get_the_ID(), 'tag'); 
            if (!is_user_logged_in()){$exercises_link = esc_url(home_url( '/sign-up' ));}else{$exercises_link = get_permalink();} ?>

            <li class="isotope-item <?php if ( !empty( $tags ) ) {  foreach ( $tags as $tag ) { $space_replace2 = str_replace(" ", "-", $tag->name); echo $space_replace2 . ' ';}} ?>">
              <a href="<?php echo $exercises_link; ?>">
                <span class="gallery-thumbnail">
                  <img class="img-responsive" src="<?php echo $meta['vidthumb']; ?>" alt="...">
                  <div class="thumb_brand">Fitness Cake</div>
                </span>
                <span class="gallery-text">
                  <span class="gallery-title"><?php the_title(); ?></span>
                  <div class="ellip ellip-line"><?php echo $meta['description']; ?></div>
                </span>
              </a>
            </li>
            <?php endwhile; endif;  ?>
      </ul>
    </div>
  </div>
<script>
jQuery(document).ready(function($){
  $('.gallery-title').ellipsis({
    lines: 1,
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

<?php get_footer(); ?>