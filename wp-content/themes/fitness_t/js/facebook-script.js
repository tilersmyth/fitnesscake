// This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
 
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      //testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  var host = window.location.hostname;

  var fbapp; 
  if (host == 'localhost'){
    fbapp = '683096381775691';
  }else{fbapp = '682740565144606';}

  window.fbAsyncInit = function() {
  FB.init({
    appId      : fbapp,
    cookie     : true,  
    xfbml      : true,  
    version    : 'v2.0' 
  });

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


  function Login(fbnonce) {
  FB.login(function (response) {
    if (response.authResponse) {
        FB.api('/me', function(response) {
        fb_integrate(response.first_name, response.last_name, response.email, response.id, fbnonce);
      });
    } else {
      alert("Login attempt failed!");
    }
  }, { scope: 'email,public_profile' });

}