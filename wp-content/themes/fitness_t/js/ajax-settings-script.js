jQuery(document).ready(function($){ 
$('form#admin_settings').each(function() { 

$(this).validate(
  {
  rules: {
    profile_image: {
      required: true
    },
     profile_txt: {
      required: true
    }
  },
  submitHandler: function (form) {submit_settings();}

});

var submit_settings = function(){ 
   $.ajax({
        type: "POST",
        dataType: 'json',
        url: ajax_settings_object.ajaxurl,
        data: { 
                'action': 'ajaxsettings', 
                'image': $('form#admin_settings #image').val(), 
                'profile_txt': $('form#admin_settings #profile_txt').val(),
                'show_followers': $('form#admin_settings #show_followers').is(':checked') ? $('form#admin_settings #show_followers').val() : null,
                'notify_newuser': $('form#admin_settings #notify_newuser').is(':checked') ? $('form#admin_settings #notify_newuser').val() : null,
                'notify_comment': $('form#admin_settings #notify_comment').is(':checked') ? $('form#admin_settings #notify_comment').val() : null,
                //'security': $('form#trainerfeedback #security').val() 
              },
        })
        .done(function( msg ) {
          $('.success_container').html('<div class="updated"><p>Settings have been updated.</p></div>');
        })
      .fail(function( msg ) { });          
  } 

  
 })

// image upload function
  $( '#uploadimage' ).on( 'click', function() {

    tbframe_interval = setInterval(function() {
          $('#TB_iframeContent').contents().find('.savesend input[type="submit"]').val('Upload This Photo');
          $('#TB_iframeContent').contents().find('.slidetoggle tbody tr:nth-child(3), .slidetoggle tbody tr:nth-child(4), .slidetoggle tbody tr:nth-child(5), .slidetoggle tbody tr:nth-child(6), .slidetoggle tbody tr:nth-child(7), .slidetoggle tbody tr:nth-child(8), .slidetoggle tbody tr:nth-child(9)').hide();


    }, 1000);
  
    tb_show('Upload Profile Picture', 'media-upload.php?type=image&TB_iframe=1');

    window.send_to_editor = function( html ) 
    {
      imgurl = $( 'img',html ).attr( 'src' );
      $( '#image' ).val(imgurl);
      tb_remove();
    }

    return false;
  });
  
})  