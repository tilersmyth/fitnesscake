// Validation for routine admin section
// ========================================================================
jQuery(document).ready(function($){ 
$('form#post').each(function() { 
  $(this).validate(
		  {
		  rules: {
		    post_title: {
		      required: true
		    },
		    "_full_meta2[description]": {
		      required: true
		    },
		    "_full_meta2[routine][0][target]": {
		      required: true
		    },
		    "_full_meta2[routine][0][date]": {
		      required: true
		    },
		    "_full_meta2[routine][0][time]": {
		      required: true
		    },
		    "_full_meta3[client][0][target]": {
		      required: true
		    }

		  },

		  highlight: function(element) {
		    $(element).removeClass('routine-has-success').addClass('routine-has-error');
		  
		  },
		  unhighlight: function(element) {
		  	$(element).removeClass('routine-has-error');

		  },
		  invalidHandler: function(event, validator) {
		  	 // 'this' refers to the form
			    var errors = validator.numberOfInvalids();
			    if (errors) {
			      var message = errors == 1
			        ? 'Please complete the 1 hightlighted field.'
			        : 'Please complete the ' + errors + ' hightlighted fields.';
			      $(".routine_post_alert").html('<div class="error error-routine"><p><b>'+message+"</b></p></div>");
			      $(".routine_post_alert").show();
			    } else {
			      $(".routine_post_alert").hide();
			    }
		  }
		 });
  

	});

});