<div id="meta_main" class="my_meta_control">
 
	<label>Routine Description</label>
 
	<p>
		<?php $metabox->the_field('description'); ?>
		<textarea name="<?php $metabox->the_name(); ?>" id="video_description" rows="2"><?php $metabox->the_value(); ?></textarea>
		<span>Answer: what type of client is this routine meant for and how will it help?</span>
	</p>


<label>Add exercise from drop down and specify recommended reps/sets. These sections are draggable!</label>
<p>
<div class="routine_add_container">
<?php while($mb->have_fields_and_multi('routine')): ?>
  <?php $mb->the_group_open(); ?>
    <div>
      
    <?php $selected = ' selected="selected"'; ?>

    <?php $mb->the_field('target'); ?>
    <div style="display:inline-block;">
    <label>Exercise</label>
    <p><select name="<?php $mb->the_name(); ?>">
    <option value=""></option>
    <?php query_posts( array( 'post_type' => 'exercises_single', 'posts_per_page' => -1 ) );?>
    <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
    <option value="<?php echo get_the_ID(); ?>"<?php if ($mb->get_the_value() == get_the_ID()) echo $selected; ?>><?php the_title(); ?></option>
    <?php endwhile; endif; wp_reset_query();?>
    </select></p>
    </div>

    <div style="display:inline-block;">
    <?php $mb->the_field('date'); ?>
    <label>Sets</label>
    <p><input type="text" name="<?php $mb->the_name(); ?>" class="example-datepicker" value="<?php $mb->the_value(); ?>"/></p>
    </div>

    <div style="display:inline-block">
    <?php $mb->the_field('time'); ?>
    <label>Reps / Time</label>
    <p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
    </div>

    </div>
 
    
    <a href="#" class="dodelete button item-delete dashicons dashicons-dismiss"></a>

  <?php $mb->the_group_close(); ?>
  <?php endwhile; ?>

</div> 
</p>
      <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-routine button">Add Exercise</a>
    <a style="float:right; margin:0 10px;" href="#" class="dodelete-routine button">Remove All</a>
  </p>



</div>


<script type="text/javascript">
//<![CDATA[
jQuery(function($){
  $('#meta_main .wpa_loop-routine').sortable({
     connectWith: '.wpa_loop',
         opacity: 0.6,
         revert: true,
         cursor: 'move'
     });
});
//]]>
</script>