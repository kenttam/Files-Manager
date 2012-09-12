<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to Facebook Ignited</title>

    <style type="text/css">
    
    body {
     background-color: #fff;
     margin: 40px;
     font-family: Lucida Grande, Verdana, Sans-serif;
     font-size: 14px;
     color: #4F5155;
    }
    
    a {
     color: #003399;
     background-color: transparent;
     font-weight: normal;
    }
    
    h1 {
     color: #444;
     background-color: transparent;
     border-bottom: 1px solid #D0D0D0;
     font-size: 16px;
     font-weight: bold;
     margin: 24px 0 2px 0;
     padding: 5px 0 6px 0;
    }
    
    code {
     font-family: Monaco, Verdana, Sans-serif;
     font-size: 12px;
     background-color: #f9f9f9;
     border: 1px solid #D0D0D0;
     color: #002166;
     display: block;
     margin: 14px 0 14px 0;
     padding: 12px 10px 12px 10px;
    }
    
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
        <script>
        $(document).ready(function(){
            FB.init({ 
                appId  : '<?php echo $fb_app['fb_appid']; ?>',
                status : true, // check login status
                cookie : true, // enable cookies to allow the server to access the session
                xfbml  : true  // parse XFBML
            });
            FB.Canvas.setSize();
        });
        /*function sendfeed()
        {
         FB.ui(
           {
             method: 'feed',
             name: 'Facebook Ignited: The Open Source Facebook Framework',
             link: 'http://apps.facebook.com/facebook-ignited/',
             picture: '',
             caption: 'Check out this awesome free script!',
             description: '<?php if (isset($me)): echo $me['first_name'].","; endif; ?> just checked out Facebook Ignited! Be the first of their friends to do so!',
             message: 'Wow, this is awesome! And its Free!'
           },
           function(response) {
             if (response && response.post_id) {
               alert('Post was published.');
             } else {
               alert('Post was not published.');
             }
           }
         );
            }*/
        var request = {
                method: 'apprequests',
                message: 'Check out this free script!',
                data: ''
            };
            function sendRequest() {
                FB.ui(request, function (response) {
                    if (response && response.request_ids) {
                         
                    /* Do something after the user sends requests IE show a fancy graphic or record data in db */
                        
                    } else {

                   /* Do nothing or something whatever blows your hair back if they click cancel */
                   
                    }
                })
            }
            function placeOrder() {
                var item_id = document.getElementById('item_id').value;

                // Assign an ID - usually points to a db record 
                    // found in your callback
                var order_info = item_id;

                // calling the API ...
                var obj = {
                method: 'pay',
                order_info: order_info,
                purchase_type: 'item'
                };

                  FB.ui(obj, callback);
                }
                
                var callback = function(data) {
                  if (data['order_id']) {
                    // Success, we received the order_id. The order states can be
                    // settled or cancelled at this point.
                    return true;
                  } else {
                    //handle errors here
                    return false;
                  }
                };          
        </script>
        
</head>
<body>
<div id="fb-root"></div>
<fb:like show_faces="false" layout="button_count"></fb:like>
<?php if (isset($error)): echo $error; endif; ?>
<h1>Welcome <?php if (isset($me)): echo $me['first_name'].","; else: echo "Guest"; endif; ?> to Facebook Ignited!</h1>
<?php if (isset($email))
    echo "<p>Your Email was not recognized</p>";
    var_dump($_SESSION);
    ?>

<p>The page you are looking at is being generated dynamically by CodeIgniter &amp; the Facebook SDK.</p>

<p>You can can view the advanced features by clicking <a href="<?php echo $link ?>">this link</a> to authorize the app!</p>

<p>If you would like to edit this page you'll find it located at:</p>
<code>application/views/welcome_message.php</code>

<p>The corresponding controller for this page is found at:</p>
<code>application/controllers/welcome.php</code>

<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>

<p>You can view the source code at: <a href="https://bitbucket.org/deth4uall/facebook-ignited/" target="_blank">https://bitbucket.org/deth4uall/facebook-ignited/</a> & <a href="https://github.com/deth4uall/facebook-ignited/" target="_blank">https://github.com/deth4uall/facebook-ignited/</a></p>

<p><a href='javascript:void();' onclick='sendRequest()'>Try a Request</a> | <a href='javascript:void();' onclick='sendfeed()'>Try Publishing to Your Feed</a></p>
<form name ="place_order" id="order_form" action="#">
   <img src="http://www.facebook.com/images/gifts/21.png">
   <input type="hidden" name="item_id" value="1" id="item_id">
    <img src="http://developers.facebook.com/attachment/credits_sm.png" 
      height="25px">


    <a onclick="placeOrder(); return false;">
     <img src="https://www.facebook.com/images/credits/paybutton.png">
    </a>
  </form>
<p><br />Page rendered in {elapsed_time} seconds</p>

</body>
</html>