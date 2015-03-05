<?php
/*
Template Name: Exercises
*/
get_header('backend'); ?>

<!-- Main body
================== -->
  <div class="wrapper wrapper-backend">
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
      <div class="col-md-6 col-md-offset-3 exercise_search">
        <input type="text" id="test_tag" name="test_tag" class="form-control" placeholder="What are ya looking for? Start typing">
      </div>  
        
           <?php query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => -1 ) );?>
            <?php $space_replace = array(); $tag_key = array();  if ( have_posts() ) : while (have_posts()) : the_post();
              $tags_array = get_the_terms( get_the_ID(), 'tag');
              if (!empty($tags_array)):            
              foreach ($tags_array as $tag_single):
                  $space_replace[] = str_replace(" ", "-", $tag_single->name);
                  $tag_key[] = $tag_single->name;
                  endforeach; endif; endwhile; endif; wp_reset_query(); ?>
          <?php $result_key = array_unique($space_replace); 
          $result = array_unique($tag_key);  $c = array_combine($result_key, $result);
             ?>

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
  // var selector = $(this).attr('data-filter');
  // $container.isotope({ filter: selector });
  // return false;
});

  var selector;
   $( "#test_tag" ).keyup(function() {
  if( !$(this).val() ){selector = '*'}
  $container.isotope({ filter: selector });
  return false;
  });

  var exercise_list = '<?php echo json_encode($c) ?>';

  var final_exercise_list = $.parseJSON( exercise_list );

  var countriesArray = $.map(final_exercise_list, function (value, key) { return { value: value, data: key }; });
  $('#test_tag').autocomplete({
        lookup: countriesArray,
        minChars: 1,
        onSelect: function (event) { 
            selector = '.'+event.data
            $container.isotope({ filter: selector });
            return false;
        },
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'Sorry, no matching results',
    });
 });



// Filtering

  
});
</script>

<?php get_footer('backend'); ?>