<?php

//create custom post type for Exercises

function exercises_single() {
  $args = array();
  register_post_type( 'exercises_single', $args ); 
  flush_rewrite_rules();
}
add_action( 'init', 'exercises_single' );

function exercises_layout() {
  $labels = array(
    'name'               => _x( 'Exercises', 'post type general name' ),
    'singular_name'      => _x( 'Exercises', 'post type singular name' ),
    'add_new'            => _x( 'Create New', 'book' ),
    'add_new_item'       => __( 'Create New Exercise' ),
    'edit_item'          => __( 'Edit Exercise' ),
    'new_item'           => __( 'New Exercise' ),
    'all_items'          => __( 'All Exercises' ),
    'view_item'          => __( 'View Exercise' ),
    'search_items'       => __( 'Search Exercises' ),
    'not_found'          => __( 'No Exercises found' ),
    'not_found_in_trash' => __( 'No Exercises found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Exercises'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Fitness plans are assigned to clients',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'comments'),
    'has_archive'   => true,
    'menu_icon' => 'dashicons-universal-access-alt',
  );
  register_post_type( 'exercises_single', $args ); 
}
add_action( 'init', 'exercises_layout' );


function my_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['exercises_single'] = array(
    0 => '', 
    1 => sprintf( __('Plan updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Plan updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Plan published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Plan submitted. <a target="_blank" href="%s">Preview plan</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview plan</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );


add_filter( 'manage_edit-exercises_single_columns', 'my_plan_columns' ) ;

function my_plan_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Plan' ),
		'description' => __( 'Description' ),
    'customtags' => __( 'Tags' ),
    'vidthumb' => __( '<div class="dashicons dashicons-format-image"></div>' ),
		'date' => __( 'Published' )
	);

	return $columns;
}


add_action( 'manage_exercises_single_posts_custom_column', 'my_manage_movie_columns', 10, 2 );

function my_manage_movie_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    /* If displaying the 'duration' column. */
    case 'description' :

      /* Get the post meta. */
      global $exercises;

      $meta =  $exercises->the_meta($post_id); 

      //var_dump($meta);

      /* If no duration is found, output a default message. */
      if ( empty( $meta ) )
        echo __( 'No Description' );

      /* If there is a duration, append 'minutes' to the text string. */
      else
        printf( $meta['description'] );

      break;

    /* If displaying the 'genre' column. */
    case 'customtags' :

      /* Get the genres for the post. */
      $tags = get_the_terms( $post_id, 'tag');


      /* If terms were found. */
      if ( !empty( $tags ) ) {

        $tag_show = array();

        /* Loop through each term, linking to the 'edit posts' page for the specific term. */
        foreach ( $tags as $tag ) {
          $tag_shows[] = $tag->name;
        }

        /* Join the terms, separating them with a comma. */
       echo join( ', ', $tag_shows );


      }

      /* If no terms were found, output a default message. */
      else {
        _e( 'No Tags' );
      }

      break;

      case 'vidthumb' :

        /* Get the post meta. */
      global $exercises;

      $meta =  $exercises->the_meta($post_id); 

      //var_dump($meta);

      /* If no duration is found, output a default message. */
      if ( empty( $meta ) )
        echo __( 'No Thumbnail' );

      /* If there is a duration, append 'minutes' to the text string. */
      else

        echo '<img height="60" width="auto" src="' . $meta['vidthumb'] . '" />';

      break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}




add_action( 'init', 'create_tag_taxonomies', 0 );

//create two taxonomies, genres and tags for the post type "tag"
function create_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'popular_items' => __( 'Popular Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tag' ), 
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
    'separate_items_with_commas' => __( 'Separate tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tags' ),
    'choose_from_most_used' => __( 'Choose from the most used tags' ),
    'menu_name' => __( 'Tags' ),
  ); 

  register_taxonomy('tag','exercises_single',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag' ),
  ));
}


//Customize Edit Page 
function my_replace_submit_meta_box() {
    remove_post_type_support( 'exercises_single', 'editor' );
    remove_post_type_support( 'routines_single', 'editor' );
    remove_meta_box('slugdiv', 'exercises_single', 'normal');
}
add_action( 'admin_menu', 'my_replace_submit_meta_box' );

function hide_publishing_actions(){
        $my_post_type = 'exercises_single';
        $my_post_type2 = 'routines_single';
        global $post;
        if(($post->post_type == $my_post_type) || ($post->post_type == $my_post_type2)){
            echo '
                <style type="text/css">
                    #minor-publishing, #delete-action, #message a, #edit-slug-box, .add-new-h2, #commentstatusdiv{
                        display:none;
                    }
                    #minor-publishing-actions{
                      padding-bottom:10px !important;
                    }

                </style>
            ';
        }
}
add_action('admin_head-post.php', 'hide_publishing_actions');
add_action('admin_head-post-new.php', 'hide_publishing_actions');
add_filter( 'pre_get_shortlink', '__return_empty_string' );



//create custom post type for Routines

function routines_single() {
  $args = array();
  register_post_type( 'routines_single', $args ); 
  flush_rewrite_rules();
}
add_action( 'init', 'routines_single' );

function routines_layout() {
  $labels = array(
    'name'               => _x( 'Routines', 'post type general name' ),
    'singular_name'      => _x( 'Routines', 'post type singular name' ),
    'add_new'            => _x( 'Create New', 'book' ),
    'add_new_item'       => __( 'Create New Routine' ),
    'edit_item'          => __( 'Edit Routine' ),
    'new_item'           => __( 'New Routine' ),
    'all_items'          => __( 'All Routines' ),
    'view_item'          => __( 'View Routine' ),
    'search_items'       => __( 'Search Routines' ),
    'not_found'          => __( 'No Routines found' ),
    'not_found_in_trash' => __( 'No Routines found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Routines'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Completed routines',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'comments'),
    'has_archive'   => true,
    'menu_icon' => 'dashicons-list-view',
  );
  register_post_type( 'routines_single', $args ); 
}
add_action( 'init', 'routines_layout' );

function my_updated_messages_routines_single( $messages ) {
  global $post, $post_ID;
  $messages['routines_single'] = array(
    0 => '', 
    1 => sprintf( __('Routine updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Routine updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Routine published. <a href="%s">View routine</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Routine submitted. <a target="_blank" href="%s">Preview plan</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview plan</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages_routines_single' );

add_filter( 'manage_edit-routines_single_columns', 'my_routine_columns' ) ;

function my_routine_columns( $columns ) {

  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Title' ),
    'description' => __( 'Description' ),
    'author' => __( 'Author' ),
    'date' => __( 'Published' )
  );

  return $columns;
}

add_action( 'manage_routines_single_posts_custom_column', 'my_manage_routine_columns', 10, 2 );

function my_manage_routine_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    /* If displaying the 'duration' column. */
    case 'description' :

      /* Get the post meta. */
      global $routines;

      $meta =  $routines->the_meta($post_id); 

      //var_dump($meta);

      /* If no duration is found, output a default message. */
      if ( empty( $meta ) )
        echo __( 'No Description' );

      /* If there is a duration, append 'minutes' to the text string. */
      else
        printf( $meta['description'] );

      break;

  

    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}
