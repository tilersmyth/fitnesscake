  <?php
/*
Template Name: Settings
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
global $current_user; $user_details = get_user_meta($current_user->ID, 'user_details');
if(empty($user_details)){ wp_redirect( home_url() . '/setup' ); exit; }
get_header('backend'); date_default_timezone_set('America/New_York'); 
?>

<!-- Main body
================== -->
  <div class="wrapper wrapper-backend">
    
    <div class="container user_container settings_container">
      <!-- Help Center -->
      <div class="row">
        <!-- Profile Menu -->
        <div class="col-sm-4 col-md-3">
          <div class="user-menu bottom-15">
            <ul>
              <li>
                <a href="#" class="active">
                  <i class="sign fa fa-cog bg-green"></i> Settings <i class="fa fa-chevron-right pull-right"></i>
                </a>  
              </li>
              <li>
                <a href="<?php echo wp_logout_url( home_url() ); ?>">
                  <i class="sign fa fa-sign-out bg-red"></i> Sign Out <i class="fa fa-chevron-right pull-right"></i>
                </a>  
              </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-8 col-md-6">
          <!-- Edit profile form -->
          <div id="submit_success"></div>
          <h3 class="hl">Settings <small><?php echo $current_user->first_name .' '. $current_user->last_name; ?></small></h3>
          <p class="text-muted">Update your settings and user preferences below</p>
          <hr>
          <h4 class="hl bottom-15">Fitness Information</h4>
          <form id="settings" role="form">
            <div class="form-group">
              <label for="full-name">Current Physical Condition</label>
              <textarea class="form-control" rows="3" id="situation" name="situation"><?php if (!empty($user_details[0]['situation'])){echo $user_details[0]['situation'];} ?></textarea>
            </div>
            <div class="form-group">
              <label for="email-1">Fitness Goals</label>
              <textarea class="form-control" rows="3" id="goal" name="goal" placeholder="What do you want to get out of this fitness plan?"><?php if (!empty($user_details[0]['goal'])){echo $user_details[0]['goal'];} ?></textarea>
            </div>
            <div class="form-group">
            <label>What is your desired daily workout timeframe (default: 30 minutes)?</label>
            <div class="time_slider">
            <?php if (!empty($user_details[0]['time_frame'])){$time_frame =  $user_details[0]['time_frame'];} ?>
            <b>15 min</b><input type="text" id="fitframe" name="fitframe" class="col-md-12" value="" data-slider-min="15" data-slider-max="60" data-slider-step="15" data-slider-value="<?php echo $time_frame; ?>" data-slider-orientation="horizontal" data-slider-selection="after" data-slider-tooltip="show"><b>60 min</b>
            <input type="hidden" id="time_frame" name="time_frame" value="<?php echo $time_frame; ?>">
            </div>
            </div>
            <hr>
            <h4 class="hl bottom-15">Notifications</h4>
            <div class="form-group">
              <label>New Exercises</label>
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="settings_alert" name="exercise_alert" value="1" <?php echo ($user_details[0]['exercise_alert']==1 ? 'checked' : '');?>> I would like to receive new exercise email notifications
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>New Routines</label>
              <div class="checkbox" >
                <label>
                  <input type="checkbox" class="settings_alert" name="routine_alert" value="1" <?php echo ($user_details[0]['routine_alert']==1 ? 'checked' : '');?>> I would like to receive new routine email notifications
                </label>
              </div>
            </div>

            <button type="submit" id="submit" data-loading-text="Sending" class="btn btn-green pull-right" disabled>Submit</button>
            <div class="clearfix"></div>
          </form>
          
        </div>
      </div>
    </div>
  </div>
 <script>
jQuery(document).ready(function($){
  $(".settings_alert").change(function() {
        var form = $('form').find(':submit'); 
    $(form).removeAttr('disabled');
});

   $('#fitframe').slider().on('slide', function(ev){
    $('#time_frame').val(ev.value);
    var form = $('form').find(':submit'); 
    $(form).removeAttr('disabled');
  });

  var templateDir = "<?php bloginfo('template_directory') ?>";
$('form').each(function() { 
  $(this).validate(
  {
  ignore:[],
  rules: {
    situation: {
      required: true
    },
    goal: {
      required: true
    }

  }, 
  onkeyup: function(element) {
    var form = $('form').find(':submit'); 
    $(form).removeAttr('disabled');
  },
  submitHandler: function (form) { submit_cand(); }
 });
  
  
  var submit_cand = function(){ 
   var btn = $('#submit');
   btn.button('loading');

      $.ajax({
        type: "POST",
        url: "<?php echo get_bloginfo('template_url') ?>" + "/setup_ajax.php",
        data: $('form').serialize(),
      })
        .done(function( msg ) {
        $("#submit_success").html('<div class="info-board info-board-green">Settings have been updated!</div>');
        btn.button('reset');
                })
      .fail(function( msg ) {});          
}
  
  })
});  
  
</script>

<?php get_footer('backend'); ?>