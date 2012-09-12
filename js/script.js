/* Author: Kent Tam

*/


//add last to array
if(!Array.prototype.last) {
    Array.prototype.last = function() {
        return this[this.length - 1];
    }
}

window.fbAsyncInit = function() {
        FB.init({
          appId: '133270333416553',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          //window.location = "http://localhost/test_bank";
          //alert('logged in');
        });
        FB.Event.subscribe('auth.logout', function(response) {
          //window.location.reload();
          //alert('logged out');
          window.location = "http://localhost/test_bank/index.php/logout";
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());

