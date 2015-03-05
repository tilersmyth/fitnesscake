<?php
/*
Template Name: Setup
*/
if (!is_user_logged_in()) { wp_redirect( home_url() ); exit;}
global $current_user; $user_details = get_user_meta($current_user->ID, 'user_details');
if(!empty($user_details)){ wp_redirect( home_url() . '/user' ); exit; }
get_header('backend'); ?>

<!-- setup page - auth login and setup not complete
================== -->

<?php global $current_user; get_currentuserinfo();?>

 <div class="wrapper wrapper-backend">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Account Setup</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container setup1">
      <div class="row">
        <div class="col-md-12">
          <h1 class="hl text-center top-zero"><?php echo 'Hi ' . $current_user->user_firstname . ", ";?> Let's get started!</h1>
          <p class="lead text-center setup_subtext">
          Please answer the below questions so we can customize a fitness plan for you! Answers can be changed anytime. The information you provide is confidential.
          </p>
          <br />
          <form id="setup" method="post">
            <div class="form-group">
              <textarea class="form-control" rows="3" id="situation" name="situation" placeholder="Current physical condition" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Please explain your current physical condition and any ailments you may have. Please provide as much detail as possible, inluding areas of pain." data-original-title="Physical Condition"></textarea>
            </div>
            <br/>
            <div class="form-group">
              <textarea class="form-control" rows="3" id="goal" name="goal" placeholder="What do you want to get out of this fitness plan?" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Please explain what your goal is for this fitness plan." data-original-title="Fitness Goal"></textarea>
            </div>
            <br/>

            <div class="form-group">
            <label>What is your desired daily workout timeframe (default: 30 minutes)?</label>
            <div class="time_slider">
            <b>15 min</b><input type="text" id="fitframe" name="fitframe" class="col-md-12" value="" data-slider-min="15" data-slider-max="60" data-slider-step="15" data-slider-value="30" data-slider-orientation="horizontal" data-slider-selection="after" data-slider-tooltip="show"><b>60 min</b>
            <input type="hidden" id="time_frame" name="time_frame" value="30">
            </div>
            </div>
            <br/>
            <div class="form-group">
              <div class="checkbox">
              <label>
                <input type="checkbox" name="skype" checked> I would like a 5 minute introductory Skype session with a certified trainer (highly recommended)
              </label>
            </div>
            </div>

            <div class="reg_btn_container">
            <button type="submit" id="submit" data-loading-text="Sending" class="btn btn-green reg_btn">Submit</button>
            <div class="submit_error"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
jQuery(document).ready(function($){

  $('#fitframe').slider().on('slide', function(ev){
    $('#time_frame').val(ev.value);
  });


  var templateDir = "<?php bloginfo('template_directory') ?>";
  var redirect = "<?php echo esc_url( home_url( '/user' ) ); ?>";
$('form#setup').each(function() { 
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
  submitHandler: function (form) {submit_cand(); }
 });
  
  
  var submit_cand = function(){ 
   var btn = $('#submit');
   btn.button('loading');

      $.ajax({
        type: "POST",
        url: "<?php echo get_bloginfo('template_url') ?>" + "/setup_ajax.php",
        data: $('form#setup').serialize(),
      })
        .done(function( msg ) {
              window.location.href = redirect;
                })
      .fail(function( msg ) {});          
}
  
  })
});  
  
</script>

<?php get_footer(); ?>