<?php



?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($user) { ?>
      Your user profile is <?php echo $error; ?>
      <pre>
        <?php //var_dump($_SESSION);?>
        <?php //print htmlspecialchars(print_r($user_profile, true)) ?>
      </pre>
    <?php } else { ?>
      <head></head>
    <?php } ?>
    <fb:login-button autologoutlink='true' id='loginButton'></fb:login-button>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '133270333416553',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location = "http://localhost:8888/test_bank";
          //alert('logged in');
        });
        FB.Event.subscribe('auth.logout', function(response) {
          //window.location.reload();
          //alert('logged out');
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
</html>
