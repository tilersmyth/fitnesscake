jQuery(document).ready(function($){ 
$('form#login').each(function() { 
  $(this).validate(
  {
  rules: {
    username: {
      required: true
    },
    password: {
      required: true
    }
  },
  submitHandler: function (form) {submit_cand();}
 });
  
  
  var submit_cand = function(){ 
   var btn = $('#submit');
   btn.button('loading');

      $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val() },
        })
        .done(function( msg ) {
           if (msg.loggedin == true){
              if((msg.role == 'administrator') || (msg.role == 'editor')){
                  document.location.href = ajax_login_object.redirecturladmin; 
                 }else{ document.location.href = ajax_login_object.redirecturl;
                 }                  
                }
            if (msg.loggedin == false){    
                $(".submit_error").html('<div class="info-board info-board-red">'+msg.message+'</div>');

            }
           btn.button('reset');
        })
      .fail(function( msg ) {});          
}
  
  })
})  