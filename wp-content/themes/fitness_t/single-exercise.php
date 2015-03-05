<div class="wrapper wrapper-backend">
    
    <div class="container single_player">
			<?php while ( have_posts() ) : the_post(); global $exercises; $meta = $exercises->the_meta(get_the_ID());  $holy_shit = $meta['vidID']; ?>
			
        	<div class="row">
          		<div class="col-sm-9">
          			<div id="single-player-container">
						<div id="player"></div>
					</div>	
				</div>
				<div class="col-sm-3">
			          <h3><?php echo the_title(); ?></h3>
			          <p><?php echo $meta['description']; ?></p>
			          <hr>
			          <ul class="list-inline gallery-item-icons">
			            <li title="Views">
			            	<?php
			            	$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/".$holy_shit."?v=2&alt=json");
							$JSON_Data = json_decode($JSON);
							$views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
							echo '<i class="fa fa-eye vid_info_siderbar" data-toggle="tooltip" data-placement="top" title="Exercise Views"></i> ' . $views;
			            	?>
			            </li>
			            <li title="Bookmarks">
			              <i class="fa fa-thumb-tack vid_info_siderbar" data-toggle="tooltip" data-placement="top" title="Used in Routines"></i> 0
			            </li>
			            <li title="Comments">
			              <i class="fa fa-comments vid_info_siderbar" data-toggle="tooltip" data-placement="top" title="Video Comments"></i> <?php echo get_comments_number(); ?>
			            </li>
			          </ul>
			          <p>
			          <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
			          </p>
			          <hr>
			          <p class="tags">
			          <small>Exercise Tags:</small><br/>
			          <?php $vid_tags = get_the_terms( $post->ID, 'tag'); 
			          if ( !empty( $vid_tags ) ) {  foreach ( $vid_tags as $vid_tag ) {
			          	echo '<a href="#">'.$vid_tag->name.'</a>';
			          }}
			          ?>
			          </p>
			          <hr>
			          <?php $next_post = get_adjacent_post();
			          		if(!empty($next_post)){
			          		$url = is_object( $next_post ) ? get_permalink( $next_post->ID ) : '';
							$title = is_object( $next_post ) ? get_the_title( $next_post->ID ) : '';
							echo '<a href="'. $url. '" class="btn btn-turquoise">Next: '. $title . ' <span class="glyphicon glyphicon-chevron-right"></span></a>';
						}
			          ?> 
				</div>
			</div>
			<div class="row">
          		<div class="col-sm-9 .col-sm-offset-3">
          			<?php comments_template('/comments.php', true); ?>		
				</div>
			</div>
			<?php endwhile; // end of the loop. ?>
    </div>
  </div>
 <script>
      var obj = <?php echo json_encode($holy_shit); ?>; 
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          playerVars: { 'autoplay': 0, modestbranding: true},		
          height: '100%',
          width: '100%',
          videoId: obj,
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }



      function onPlayerReady(event) {
      	

      }
      function onPlayerStateChange(event) {}
      function stopVideo() {
        player.stopVideo();
      }


jQuery(document).ready(function($){
    $(window).resize(function() {
    
    var vid_container = $( '#single-player-container' ).width();
	var vid_desired_height = Math.floor(vid_container * .5632);
    $('#single-player-container').height(vid_desired_height);
	});

	$(window).trigger('resize');
});	

    </script>