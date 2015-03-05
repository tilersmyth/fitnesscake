<?php
/*
Template Name: Search
*/
get_header(); 
$search = ( isset($_GET["t"]) ) ? sanitize_text_field($_GET["t"]) : false ;
ob_start();
?>

<!-- Main body
================== -->
  <div class="wrapper">
   <div class="container">
   <div class="row search-field-container">
        <div class="col-md-6 col-md-offset-3">
              <?php $blog_title = get_bloginfo('url') . '/search'; ?>
             <form method="get" id="sul-searchform" action="<?php echo $blog_title; ?>">
                  <div class="input-group input-group-lg">
                    <input type="text" class="form-control" name="t" placeholder="Search by name or email" value="<?php echo $search; ?>">
                    <span class="input-group-btn">
                      <button class="btn btn-turquoise" type="submit">Search</button>
                    </span>
                  </div><!-- /input-group -->
              </form>    
        </div>
   </div>
      <div class="row">
        <div class="col-xs-12">
          <h3 class="hl text-center top-zero">Search Results for: <?php echo $search; ?></h3>
          <br />
        </div>
      </div>
      <?php 
      

       

       if ($search){
    // Generate the query based on search field
    $all_ids = wp_get_sites();     
    $users = array(); $users2 = array();    
    foreach ($all_ids as $all_id):   
    $my_users = new WP_User_Query( 
      array(
        'blog_id' => $all_id['blog_id'],
        'role' => 'editor', 
        'search' => '*' . $search . '*' ,
      ));
    $results = $my_users->get_results();
 
      $my_users2 = new WP_User_Query( array(
        'blog_id' => $all_id['blog_id'],
        'role' => 'editor',
         'meta_query' => array(
        array(
            'key'     => 'full_name',
            'value'   => $search,
            'compare' => 'LIKE'
        )
      )
      ) );


     $results2 = $my_users2->get_results();   


   
   // var_dump($results2);
    if($results) {$users = array_merge($users, $results);}
    


    if($results2) {$users2 = array_merge($users2, $results2);}



    endforeach;
    if($users){ $userdata = $users; } elseif ($users2) { $userdata = $users2; } else { $userdata =  NULL; }


    }//end search
  ?>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <?php if(!$userdata):  
         echo  '<p class="lead text-center">Sorry, we cannot find this trainer.</p>';


          else: echo '<ul class="search_result_list">'; foreach ($userdata as $userdata_single): $user_blog = get_active_blog_for_user( $userdata_single->ID ); ?>  
          <?php switch_to_blog( $user_blog->blog_id); $settings = get_page_by_title( 'settings' ); $profile_txt = get_post_meta( $settings->ID, 'profile_txt' );
          $profile_image = get_post_meta( $settings->ID, 'profile_image' ); 
          $first_n = get_user_meta( $userdata_single->ID, 'first_name' ); $last_n = get_user_meta( $userdata_single->ID, 'last_name' ); ?>
          <li><a class="search_line_items" href="<?php echo $user_blog->siteurl; ?>">
          <div class="user_result_img pull-left"><img src="<?php if(!empty($profile_image[0])){ echo $profile_image[0]; } ?>"></div>
          <div class="user_result_content">
          <h4><?php echo $first_n[0] . ' ' .$last_n[0]; ?></h4>
          <p class="lead user_result_text"><?php echo $profile_txt[0]; ?></p>

          </div>
          </a></li>
          
          </ul>
          <?php endforeach; echo '</ul>'; endif; ?>
        </div>
      </div>
      
    </div>
</div>

<script>
  jQuery(document).ready(function($){
  $('.user_result_text').ellipsis({
    lines: 4,
    ellipClass: 'ellip',
    responsive: true
  });
  });
</script>
<?php get_footer(); ?>