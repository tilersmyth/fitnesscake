jQuery(document).ready(function($){ 

 window.fb_integrate = function(first, last, email, id, nonce){ 
   $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_facebook_object.ajaxurl,
        data: { 
                'action': 'ajaxfacebook', 
                'first_name': first, 
                'last_name': last, 
                'user_email': email,
                'id': id,
                'security': nonce  },
        })
        .done(function( msg ) {
           if (msg.loggedin == true){
            document.location.href = ajax_login_object.redirecturl;
           }    
           if (msg.loggedin == false){    
            
                $(".submit_error").html('<div class="info-board info-board-red">'+msg.message+'</div>');

            }     

        })
      .fail(function( msg ) {  });          
   
}

  
})  