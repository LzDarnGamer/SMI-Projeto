<html>
<body>
  <script>

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '585466409055616',
        cookie     : true,
        xfbml      : true,
        version    : 'v7.0'
      });
      
      FB.AppEvents.logPageView();

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });


      
    };

    (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function (response) {
          console.log('Successful login for: ' + response.name);
        });
      }
    }
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }
  </script>

  <fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>

</body>
</html>