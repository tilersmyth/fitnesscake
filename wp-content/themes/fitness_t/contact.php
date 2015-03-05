<?php
/*
Template Name: Contact
*/
get_header(); ?>

<!-- Main body
================== -->
  <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="animated slideInLeft"><span>Contact Us</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
                    <h2 class="hl top-zero">Contact Us</h2>
                    <div class="alert alert-success submit_success" style="display:none"></div>
          <hr>
            <p>For additional Fitness Cake information or if you just want to say hello, please shoot us a message using the form below!  </p>
            <form role="form" id="contactus">
              <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
              </div>
              <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter E-Mail">
              </div>
              <div class="form-group">
                <label for="email">Phone</label>
                <input type="phone" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number">
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" name="message" rows="3" id="message" placeholder="Enter Message"></textarea>
              </div>
              <button type="submit" class="btn btn-green">Send</button>

            </form>
            <div class="submit_error"></div>
        </div>
     </div>
 </div>
</div>
  <script>
jQuery(document).ready(function($){

$('form#contactus').each(function() { 
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
    },
    phone: {
      minlength: 2,
      required: true
    },
    message: {
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
        url: "<?php echo get_bloginfo('template_url') ?>" + "/emailjax.php",
        data: $('form#contactus').serialize(),
      })
        .done(function( msg ) {
        $('form#contactus')[0].reset();
        $(".submit_success").show();
        $(".submit_success").html('Thanks for the message! We will reach out shortly.');
        })
      .fail(function( msg ) {});          
}
  
  })
})    
  
</script>


<?php get_footer(); ?>