<div id="meta_main" class="my_meta_control">
 

<label>Select client from dropdown</label>
<p>
<div class="routine_add_container">
<?php while($mb->have_fields_and_multi('client')): ?>
  <?php $mb->the_group_open(); ?>
    <div>
      
    <?php $selected = ' selected="selected"'; ?>

    <?php $mb->the_field('target'); ?>
    <div style="display:inline-block;">
    <p><select name="<?php $mb->the_name(); ?>">
    <option value=""></option>
     <?php $blogusers = get_users();
    foreach ( $blogusers as $user ):  if (($user->roles[0] !== 'editor') &&  ($user->roles[0] !== 'administrator')):?> 
    <option value="<?php echo $user->ID; ?>"<?php if ($mb->get_the_value() == $user->ID) echo $selected; ?>><?php echo esc_html( $user->first_name ) . ' ' . esc_html( $user->last_name ) ?></option>
     <?php endif; endforeach; ?>
     <option value="all"<?php if ($mb->get_the_value() == "all") echo $selected; ?>>All Clients</option>
    </select></p>
    </div>

   </div>
    
    <a href="#" class="dodelete button item-delete dashicons dashicons-dismiss"></a>

  <?php $mb->the_group_close(); ?>
  <?php endwhile; ?>

</div> 
</p>
      <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-client button">Add Client</a>
    <a style="float:right; margin:0 10px;" href="#" class="dodelete-client button">Remove All</a>
  </p>



</div>