jQuery(document).ready(function($) {
	
Stripe.setPublishableKey(gateway_stripe.public_key);
$('#submit_stripe_payment_form').click(function(e){
	
	var $this = $(this);
	
    var $form = $('#stripe_payment_form');
    
    var cvc = $('input[name="stripe_card_cvc"]',$form).val();
    
    var data = {
    	name: gateway_stripe.card_customer,
    	address_line1: gateway_stripe.address_line1,
		address_line2: gateway_stripe.address_line2,
		address_city: gateway_stripe.address_city,
		address_state: gateway_stripe.address_state,
		address_zip: gateway_stripe.address_zip,
		address_country: gateway_stripe.address_country,
    	number: $('input[name="stripe_card_num"]',$form).val(),
        exp_month: $('select[name="stripe_cc_month"]',$form).val(),
        exp_year: $('select[name="stripe_cc_year"]',$form).val()
    };

    var error = false; message='';
    
    $('.woocommerce_error').remove();
    
    if(!Stripe.validateCardNumber(data.number)) {
    	error = true;
    	message += '<li>' + gateway_stripe.msg_card_number + '</li>'
    }

    if(cvc != undefined){
    	data.cvc = cvc;
    	if(!Stripe.validateCVC(data.cvc)) {
        	error = true;
        	message += '<li>' + gateway_stripe.msg_cvc_code + '</li>'
    	}
    }
    
    if(!Stripe.validateExpiry(data.exp_month, data.exp_year)) {
    	error = true;
    	message += '<li>' + gateway_stripe.msg_exp_date + '</li>'
    }
	
	if(message != ''){
		message = '<ul class="woocommerce_error">' + message + '</ul>';
		$form.before(message);
		return false;
	}
    try {
    	$("body").block(
		{ 
			message: '<img src="' + gateway_stripe.img_loading_url + '" alt="Redirecting…" style="float:left; margin-right: 10px;" />' + gateway_stripe.msg_thank, 
			overlayCSS: 
			{ 
				background: "#fff", 
				opacity: 0.6 
			},
			css: { 
				padding:        20, 
				textAlign:      "center", 
				color:          "#555", 
				border:         "3px solid #aaa", 
				backgroundColor:"#fff", 
				cursor:         "wait",
				lineHeight:		"32px"
			} 
		});
		
        Stripe.createToken(data, function(status, response){
        	if (status == 200 && !response.used){
        		var token = response['id'];
        		$form.append('<input type="hidden" name="stripe_token" value="' + token + '" />');
        		$form.submit();
        	} else {
        		message = '<ul class="woocommerce_error"><li>' + response.error.message + '</li></ul>';
        		$form.before(message);
        		$('body').unblock();
        	}
        	return false;
        });
       
    } catch(err) {
    }
    
    return false;
});

});