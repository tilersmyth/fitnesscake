 <div class="wrapper  wrapper-backend">
    
    <div class="container single_player">

			<?php while ( have_posts() ) : the_post(); global $routines, $exercises; $meta = $routines->the_meta(get_the_ID()); $routine_array = $meta['routine'];?>
        	<div class="row">
          		<div class="col-sm-9">
          			<?php $i = 0; foreach ($routine_array as $key=>$routine_single): $i++; $ex_meta = $exercises->the_meta($routine_single['target']); ?>
          			<div id="single-player-container">
						<div class="panel panel-turquoise">
								<div class="panel-heading">
					              <h3 class="panel-title"> <?php echo $i . '. ' . get_the_title($routine_single['target']); ?></h3>
					            </div>
					            <div class="panel-body routine-panel-body">
					            	<div class="media">
						              <a class="pull-left routine-media-a routine_modal" data-toggle="modal" ex-id="<?php echo $key ?>" data-target="#routineModal" href="#">
						              	<i class="fa fa-play-circle-o fa-3x routine-media-icon"></i>	
						                <img class="media-object routine-media-object" src="<?php echo $ex_meta['vidthumb']; ?>">
						              </a>
						              <div class="media-body routine-media-body">
						                <div class="recent_vid_item"><?php echo $ex_meta['description']; ?></div>
						                <div class="routine_recommend">
						                <span class="label label-default">Recommended:</span>
						                <?php echo '<span>' . $routine_single['date'] . ' sets x ' .$routine_single['time'] . '</span>'; ?>
						                </div>
						              </div>
						            </div>

					            </div>
						</div>
					</div>
					<?php endforeach; ?>	
				</div>
				<div class="col-sm-3">
			          <h3><?php echo the_title(); ?></h3>
			          <p><?php echo $meta['description']; ?></p>
			          <hr>
				      <p class="routine_play_btn">
			          <button type="button" class="btn btn-blue btn-lg routine_modal"  data-toggle="modal" ex-id="<?php echo '0' ?>" data-target="#routineModal">Start Routine</button>
			          </p>
			          <hr>		         
			          <p>
			          <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
			          </p>
			          <hr>
			          <?php $vid_tags = get_the_terms( $post->ID, 'tag'); 
			          if ( !empty( $vid_tags ) ) {  
			          echo '<p class="tags"><small>Routine Tags:</small><br/>';
			          	foreach ( $vid_tags as $vid_tag ) {
			          		echo '<a href="#">'.$vid_tag->name.'</a>';
			          	} echo '</p><hr>'; }

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

  <!-- Modal -->
<div class="modal fade" id="routineModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      	<div id="modal-player-container">
       		<div id="modal-player"></div>
       	</div>
      </div>
      <div class="modal-footer">
      	<div class="modal-footer-routine"></div>
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-next routine_modal" data-toggle="modal" data-target="#routineModal" rtn-array="" ex-id="" >Next</button>
      </div>
    </div>
  </div>
</div>


<script>
jQuery(document).ready(function($){

	$('.routine_modal').click(function() {
	$( ".btn-next" ).show();
	$( ".btn-close" ).html('Close');
	var ex_attr = $(this).attr( "ex-id" );
	var routine_json = '<?php echo json_encode($routine_array );?>';
	var routine_array = JSON.parse(routine_json);
 	var templateDir = "<?php bloginfo('template_directory') ?>";
	    $.ajax({
			  type: "POST",
			  url: templateDir+'/routine-modal-jax.php',
			  dataType: "json",
			  data: { exercise_id: ex_attr, rtn_array: routine_array},
			})
			  .done(function( msg ) {
			  		if(msg.next){$('.btn-next').attr('ex-id', msg.next);}else{$( ".btn-next" ).hide(); $( ".btn-close" ).html('Finished!');}
			  		$('.btn-next').attr('rtn-array', msg.rtn_array);
			  		$(".modal-title").html(msg.title);
			  		$(".modal-footer-routine").html('Recommended: '+msg.recommend);
			  		//console.log(msg);
			  		yotubeRequest(msg.ytID);

			  })
			.fail(function( msg ) {});

			//modal resize for youtube frame
			$('#routineModal').on('shown.bs.modal', function () {
				  $(window).resize(function() {
			      var vid_container = $( '.modal-body' ).width();
				  var vid_desired_height = Math.floor(vid_container * .5632);
			 	  $("#modal-player-container").animate( { height:vid_desired_height }, { queue:false, duration:500 });
				   });
				  $(window).trigger('resize');
				})

			$('#routineModal').on('hidden.bs.modal', function () {
			  //stop video on modal close
				player.stopVideo();			  
			})

		});

	});


	

function yotubeRequest(videoID) {
  if(player) { player.cueVideoById(videoID); }
}

	  var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);



      var player;

      function onYouTubeIframeAPIReady() {
        player = new YT.Player('modal-player', {
          playerVars: { 'autoplay': 0, modestbranding: true},		
          height: '100%',
          width: '100%',
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




</script>