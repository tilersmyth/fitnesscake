<?php
/*
Template Name: User Page
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
global $current_user; $user_details = get_user_meta($current_user->ID, 'user_details');
if(empty($user_details)){ wp_redirect( home_url() . '/setup' ); exit; }
get_header('backend');?>

 <div class="wrapper wrapper-backend">
    <div class="container user_container">
      <div class="row">
       
            
        <div class="col-md-8">
          <?php $alert_status = get_user_meta($current_user->ID, 'welcome-alert'); if(empty($alert_status)):?>
          <div class="alert alert-success welcome-alert">
            <button type="button" id="welcome-close" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $current_user->first_name; ?>, Welcome to Fitness Cake! Below are routines that our trainer has created for you! Also, you can view individual exercises by selecting 'Exercises' above.
          </div>
          <?php endif; ?>
          <div class="block-header">
          <h2 class="user-page-h2">
            <span class="title">Routines</span><span class="decoration"></span><span class="decoration"></span><span class="decoration"></span>
          </h2>
        </div>
        <?php query_posts( array( 'post_type' => 'routines_single', 'posts_per_page' => -1 ) );
              global $routines, $routine_intended, $authordata; if ( have_posts() ) :?>
         <!-- Get routines applicable to user -->   
           <ul class="row list-inline gallery-list" id="isotope-container"> 
                <?php while (have_posts()) : the_post(); 
                $meta =  $routines->the_meta(get_the_ID()); $exercise_list = $meta['routine']; $exercise_cnt = count($exercise_list);
                $author_role = $authordata->roles; $intended_meta = $routine_intended->the_meta(get_the_ID()); 
                $intended = array();
                //making sure this routine is intended for client
                foreach ($intended_meta['client'] as $intended_client){
                if ((in_array("all", $intended_client)) || (in_array($current_user->ID, $intended_client))){$intended[] = true;}}
                if($intended[0]): ?>
                <li class="isotope-item-dashboard">
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
                <?php endif; endwhile; ?>
          </ul>
        <?php else: echo "<h2 class='routine_non'>There are currently no routines availabile</h2>";  endif;  wp_reset_query();  ?>


        </div>
        <div class="col-md-4">
         <?php query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => 3 ) );?> 
         <!-- exercise panel -->
            <div class="panel panel-turquoise">
            <div class="panel-heading">
              <h3 class="panel-title">Recent Exercises</h3>
            </div>
            <div class="panel-body">
              <div class="recent-blogs">
                <?php if ( have_posts() ) : while (have_posts()) : the_post(); global $exercises; 
                  $meta_be =  $exercises->the_meta(get_the_ID()); ?>
                  <div class="media backend_sidebar_media">
                    <a class="pull-left" href="<?php echo get_permalink(); ?>">
                      <img class="media-object backend_sidebar_thumb" src="<?php echo $meta_be['vidthumb']; ?>">
                    </a>
                    <div class="media-body">
                      <h5 class="media-heading"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h5>
                      <div class="sidebar_meta">
                      <small><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></small>
                      | <small><i class="fa fa-tag"></i> <?php $sidebar_tags = get_the_terms( get_the_ID(), 'tag'); if ( !empty( $sidebar_tags ) ) { 
                               $prefix = ''; foreach ( $sidebar_tags as $tag ) { echo $prefix . $tag->name; $prefix = ', ';}} 
                        ?></small>
                      </div>
                    </div>
                  </div>
                  <hr class="backend_sidebar_hr">
                <?php endwhile; endif; wp_reset_query();?>
                <a class="view_all_ex" href="<?php echo esc_url( home_url( '/exercises' ) ); ?>">View All Exercises</a>
              </div>
            </div>
          </div>  
          <!-- routine panel -->
           <div class="panel panel-turquoise">
            <div class="panel-heading">
              <h3 class="panel-title">Recent Comments <i class="fa fa-comments-o"></i></h3>
            </div>
            <div class="panel-body">
              <div class="recent-blogs">
                  <div class="media backend_sidebar_media">
                    <div class="media-body">
                    <?php 
                    $args = array('post_type' => array( 'routines_single', 'exercises_single' ), 'number' => 3);
                    $comments_query = new WP_Comment_Query;
                    $comments = $comments_query->query( $args ); 
                    if ( $comments ): foreach ( $comments as $comment ): $intended_meta2 = $routine_intended->the_meta($comment->comment_post_ID);
                    $intended2 = array(); foreach ($intended_meta2['client'] as $intended_client2){
                    if ((in_array("all", $intended_client2)) || (in_array($current_user->ID, $intended_client2))){$intended2[] = true;}}
                    if (( 'exercises_single' == get_post_type($comment->comment_post_ID) ) || ($intended2[0])): ?>
                     
                      <h5 class="media-heading"><a class="panel_ellip" href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo $comment->comment_author . ': ' . $comment->comment_content; ?></a></h5>
                      <div class="sidebar_meta"> 
                        <small class="panel_ellip"><?php echo human_time_diff( get_comment_date('U'), current_time('timestamp') ) . ' ago on ' . get_the_title($comment->comment_post_ID); ?></small>
                      </div>
                      <hr class="backend_sidebar_hr">
                    <?php endif; endforeach; else : echo 'No comments found.'; ?>

                      <?php endif; wp_reset_query();?>

                    </div>
                  </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div> 
  </div> 
 <script>
  jQuery(document).ready(function($){
  $('.panel_ellip').ellipsis({
    lines: 1,
    ellipClass: 'ellip',
    responsive: true
  });

  $('.routine_item_desc').ellipsis({
    lines: 3,
    ellipClass: 'ellip',
    responsive: true
  });

  $(window).on('load', function () {
  $('#isotope-container').isotope({ 
  itemSelector : '.isotope-item-dashboard',
  layoutMode : 'fitRows'
  });

  var $container = $('#isotope-container');
  $container.isotope({
  });
  
  });

  //close meta ajax
  $('#welcome-close').click(function() { 
    var close = '<?php echo $current_user->ID;?>';
    var templateDir = "<?php bloginfo('template_directory') ?>";
    $.ajax({
        type: "POST",
        url: templateDir+'/welcome-close-jax.php',
        dataType: "json",
        data: { close: close},
      })
        .done(function( msg ) {})
      .fail(function( msg ) {});
    }) 

  });
</script> 

<?php get_footer('backend'); ?>