<div id="meta_main" class="my_meta_control">

	<label>Link</label>
 
	<p>
		<input type="text" name="<?php $metabox->the_name('name'); ?>" id="video_link" value="<?php $metabox->the_value('name'); ?>"/>
		<span>Enter YouTube URL of workout video</span>
	</p>
 
	<label>Exercise Description</label>
 
	<p>
		<?php $metabox->the_field('description'); ?>
		<textarea name="<?php $metabox->the_name(); ?>" id="video_description" rows="3"><?php $metabox->the_value(); ?></textarea>
		<span>Enter Description of Exercise</span>
	</p>
	<input type="hidden" name="<?php $metabox->the_name('vidID'); ?>" id="vidID" value="<?php $metabox->the_value('vidID'); ?>"/>
	<input type="hidden" name="<?php $metabox->the_name('vidthumb'); ?>" id="vidthumb" value="<?php $metabox->the_value('vidthumb'); ?>"/>
</div>
<script>

jQuery(document).ready(function($){
	//youtube pull
  $("#video_link").focusout(function() {

  	youtube_seek();

  })

  var youtube_seek = function(){
   //btn.button('loading');
   var data = $( "#video_link" ).val();
      $.ajax({
        type: "POST",
        url: "<?php echo get_bloginfo('template_url') ?>" + "/youtube_ajax.php",
        dataType: 'json',
        data: {value: data},
      })
        .done(function( msg ) {
        	$("#title-prompt-text").hide();
        	$('#title').val(msg.title);
        	$('#video_description').val(msg.desc);
        	$('#vidID').val(msg.vidID);
        	$('#vidthumb').val(msg.vidthumb);
            })
      .fail(function( msg ) {});          
	}


})	
</script>