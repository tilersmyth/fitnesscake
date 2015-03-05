jQuery(document).ready(function($){ 
$('form#biz_settings').each(function() { 

$(this).validate(
  {
  rules: {
    monthly_price: {
      required: {
                depends: function(){
                    return $('#enable_charge').is(':checked')
                }
            }
    },
     package_name: {
      required: {
                depends: function(){
                    return $('#enable_charge').is(':checked')
                }
            }
    },
     package_desc: {
      required: {
                depends: function(){
                    return $('#enable_charge').is(':checked')
                }
            }
    }
    ,
     coupon_name: {
      required: {
                depends: function(){
                    return $('#activate_coupon').is(':checked')
                }
            }
    }
    ,
     coupon_amt: {
      required: {
                depends: function(){
                    return $('#activate_coupon').is(':checked')
                }
            }
    }
  },
  submitHandler: function (form) {
      submit_pricing();
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
      $(".error_container").html('<div class="error"><p>'+message+'</p></div>');
      $(".error_container").show();
    } else {
      $(".error_container").hide();
    }
  }

});

//remove required field message
$.validator.messages.required = '';

var submit_pricing = function(){ 
   $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_pricing_object.ajaxurl,
        data: { 
                'action': 'ajaxpricing', 
                'enable_charge': $('form#biz_settings #enable_charge').is(':checked') ? $('form#biz_settings #enable_charge').val() : null,
                'monthly_price': $('form#biz_settings #monthly_price').val(),
                'package_name': $('form#biz_settings #package_name').val(),
                'package_desc': $('form#biz_settings #package_desc').val(),
                'activate_coupon': $('form#biz_settings #activate_coupon').is(':checked') ? $('form#biz_settings #activate_coupon').val() : null,
                'coupon_name': $('form#biz_settings #coupon_name').val(),
                'coupon_amt': $('form#biz_settings #coupon_amt').val(),
                //'security': $('form#trainerfeedback #security').val() 
              },
        })
        .done(function( msg ) {
          $('.success_container').html('<div class="updated"><p>Settings have been updated.</p></div>');
          console.log(msg);
        })
      .fail(function( msg ) { });          
  } 

  
 })
  
}) 