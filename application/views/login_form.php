<div id="container">
<?php var_dump($_SESSION)?>
	<div id="fb-root"></div>
	<fb:login-button autologoutlink='true' id='loginButton' scope='email'></fb:login-button>
	<script>

		function login(){
		   FB.api('/me', function(response) {
		      alert('You have successfully logged in, '+response.name+"!");
		      //window.location = "http://localhost/test_bank/index.php/upload";
			  //alert("hello");
			  $.get('<?php echo base_url();?>index.php/login/verify_email', {  'email' :  response.email}, function(data){
		        	if(data){
		        		alert('you are allowed');
		        		window.location = "<?php echo base_url();?>";
		        	}
		        	else{
		        		alert('you are not omega');
		        	}
		        });
		   });
		}
		function logout(){
		   //alert('You have successfully logged out!');
		   	$.get('<?php echo base_url();?>index.php/login/logout', function(data){
		   		alert('You have successfully logged out!');
		    });
		}
		function greet(){
		   FB.api('/me', function(response) {
		      alert('Welcome, '+response.name+"!");
		   });
		}

	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '133270333416553', // App ID
	      //channelUrl : '//localhost/test_bank', // Channel File
	      status     : true, // check login status
	      cookie     : true, // enable cookies to allow the server to access the session
	      oauth      : true, // enable OAuth 2.0
	      xfbml      : true  // parse XFBML
	    });

	    FB.Event.subscribe('auth.login', function(response) {
		    login();
	    	//jQuery(".email").html(response.name);
		});
		FB.Event.subscribe('auth.logout', function(response) {
		   logout();
		});
		FB.getLoginStatus(function(response) {
		   if (response.session) {
			 //window.location = "http://www.example.com/";
			 //alert("hello");
		   }

		});
	    // Additional initialization code here
	  };
	  // Load the SDK Asynchronously
	  (function(d){
	     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
	     js = d.createElement('script'); js.id = id; js.async = true;
	     js.src = "//connect.facebook.net/en_US/all.js";
	     d.getElementsByTagName('head')[0].appendChild(js);
	   }(document));
	</script>
</div>
<!--fb:login-button autologoutlink='true' id='loginButton' scope='email'></fb:login-button>

<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
  appId      : '133270333416553', // App ID
  channelUrl : 'localhost/test_bank', // Channel File
  status     : true, // check login status
  cookie     : true, // enable cookies to allow the server to access the session
  xfbml      : true  // parse XFBML
});  
var login = false;
 FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
              alert('connected');
              login=true;
                // the user is logged in and connected to your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                //window.location = "http://localhost/test_bank";
          }
          else{
              FB.login(function(response) {
               if (response.authResponse) {
                 alert('Welcome!  Fetching your information.... ');
                 FB.api('/me', function(response) {
                   alert('Good to see you, ' + response.name + '.');
                   //window.location = "http://localhost/test_bank";
                   if(login===false)
                   {
                       window.open("[APPLINKONFACEBOOK]", "_top");
                   }
                   //window.location.href=window.location.href;
                   //FB.logout(function(response) {
                     //console.log('Logged out.');
                   //});
                 });
               } else {
                 alert('User cancelled login or did not fully authorize.');
               }    
             }, {scope: 'email'});
          }});

// Additional initialization code here
};
 (function() {
var e = document.createElement('script');
e.async = true;
e.src = document.location.protocol +
 '//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);  
  }());
  // Load the SDK Asynchronously
 (function(d){
 var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
 js = d.createElement('script'); js.id = id; js.async = true;
 js.src = "//connect.facebook.net/en_US/all.js";
 d.getElementsByTagName('head')[0].appendChild(js);
 }(document));

 </script-->
