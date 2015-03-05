jQuery(document).ready(function($){ 
$('form#register').each(function() { 
  $(this).validate(
  {
  rules: {
    first_name: {
      required: true
    },
    last_name: {
      required: true
    },
    user_login: {
      minlength: 6,
      required: true,
      remote: {
        url: ajax_signup_object.template_url+"/reg_validate.php",
        type: "post",
        data: {
          user_login: function() {
            return $( "#username" ).val();
          }
        }
      }
    },
    user_email: {
      email: true,
      required: true,
      remote: {
        url: ajax_signup_object.template_url+"/reg_validate.php",
        type: "post",
        data: {
          user_email: function() {
            return $( "#useremail" ).val();
          }
        }
      }
    },
    pass1: {
      required: true, 
      minlength: 8,
      digit: true
    },
    pass2: {
      equalTo: "#password1"
    },
    terms: {
      required: true
    }

  },
  messages:{
        user_login:{
            required: "Username is a required field",
            remote: jQuery.validator.format("{0} is already taken. Please try another username."),
            minlength: "Your username must be at least {0} characters long"
        },
        user_email:{
            remote: jQuery.validator.format("{0} is in use. Do you already have an account?"),
        },
        pass2:{
            equalTo: "Passwords do not match. Please try again."
        },
        terms:{
            required: "You must agree to our terms and conditions before continuing."
        }

    },

  highlight: function(element) {
    $(element).removeClass('has-success').addClass('has-error');
  
  },
  unhighlight: function(element) {
    $(element).removeClass('has-error').addClass('has-success');

  },
  errorPlacement: function(error, element) {
    // For invalid messages in popover.
            var erMsg = error.html();

            $(".submit_error").html(erMsg);
          $(".submit_error").show();
      
  }, 
  success: function(label){
    
  },
  submitHandler: function (form) {
                 submit_cand();            
  },
  invalidHandler: function(event, validator) {

  }
 });
  
  
  var submit_cand = function(){
   var btn = $('#submit');
   btn.button('loading');

      $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_signup_object.ajaxurl,
        data: { 
                'action': 'ajaxsignup', //calls wp_ajax_nopriv_ajaxlogin
                'first_name': $('form#register #firstname').val(), 
                'last_name': $('form#register #lastname').val(), 
                'user_name': $('form#register #username').val(), 
                'user_email': $('form#register #useremail').val(), 
                'user_pass': $('form#register #password1').val(),
                'security': $('form#register #security').val() }
      })
        .done(function( msg ) {
          console.log(msg);
          $('#register')[0].reset();
          $(".submit_success").html('<div class="alert alert-success" role="alert">An account activation link has been sent to the e-mail address you provided. Please click on the link so we can get working on your fitness plan!</div>');
           btn.button('reset');
        })
      .fail(function( msg ) {});          
}
  
  })


})  