jQuery(document).ready(function($){ 
$('form#trainerfeedback').each(function() { 
$(this).validate(
  {
  rules: {
    message: {
      required: true
    }
  },
  submitHandler: function (form) {submit_feedback();}

});

 var submit_feedback = function(){  
   $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_feedback_object.ajaxurl,
        data: { 
                'action': 'ajaxfeedback', 
                'username': $('form#trainerfeedback #username').val(), 
                'blog': $('form#trainerfeedback #blog').val(),
                'message': $('form#trainerfeedback #message').val(), 
                //'security': $('form#trainerfeedback #security').val() 
              },
        })
        .done(function( msg ) {
        if (msg.sent == true){
            $(".submit_success").html('<div class="updated"><p>Thanks for the message!</p></div>');
            $("#message").val('');
           }   


        })
      .fail(function( msg ) { });          
   
}

  
 })
})  