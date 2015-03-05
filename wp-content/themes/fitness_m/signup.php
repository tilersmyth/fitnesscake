<?php
/*
Template Name: Sign up
*/

get_header();?>

  <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="animated slideInLeft"><span>Sign up</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
                    <h2 class="hl top-zero">Sign up</h2>
                    <div class="alert alert-success submit_success" style="display:none"></div>
          <hr>
            <p>This sign up page is for personal trainers and gyms. To follow a trainer/gym you must go to their URL. Fitness Cake is still in beta mode. Submit the form below and we will get you setup! </p>
            <form role="form" id="signup">
              <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
              </div>
              <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter E-Mail">
              </div>
              <button type="submit" class="btn btn-green">Submit</button>

            </form>
            <div class="submit_error"></div>
        </div>
     </div>
 </div>
</div>
  <script>
jQuery(document).ready(function($){

$('form#signup').each(function() { 
  $(this).validate(
  {
  rules: {
    name: {
      minlength: 2,
      required: true
    },
    email: {
      minlength: 2,
      required: true
    }

  },
  highlight: function(element) {
    $(element).removeClass('contact-has-success').addClass('contact-has-error');
  
  },
  unhighlight: function(element) {
    $(element).removeClass('contact-has-error').addClass('contact-has-success');

  },
  errorPlacement: function(error, element) {
  }, 
  submitHandler: function (form) {
                 submit_cand();
                 
  },
  invalidHandler: function(event, validator) {
    // 'this' refers to the form
    var errors = validator.numberOfInvalids();
    if (errors) {
      var message = errors == 1
        ? 'Please complete the 1 hightlighted field.'
        : 'Please complete the ' + errors + ' hightlighted fields.';
      $(".submit_error").html(message);
      $(".submit_error").show();
      setTimeout(function() {$(".submit_error").fadeOut().empty();}, 3000);
    } else {
      $(".submit_error").hide();
    }
  }
 });
  
  
  var submit_cand = function(){ 

      $.ajax({
        type: "POST",
        url: "<?php echo get_bloginfo('template_url') ?>" + "/signupjax.php",
        data: $('form#signup').serialize(),
      })
        .done(function( msg ) {
        $('form#signup')[0].reset();
        $(".submit_success").show();
        $(".submit_success").html('Thanks. You will receive an email with your login credentials shortly!');
        })
      .fail(function( msg ) {});          
}
  
  })
})    
  
</script>


<?php get_footer(); ?>