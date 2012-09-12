<?php

class Login extends CI_Controller{

	function index()
	{
		$facebook = new Facebook(array(
		  'appId'  => '133270333416553',
		  'secret' => 'd2c0872525c7cad161a4c7bfbcc31e7d',
		));
		// See if there is a user from a cookie
		$user = $facebook->getUser();

		if ($user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $user_profile = $facebook->api('/me');
		    $_SESSION['fb'] = $user_profile;
		  } catch (FacebookApiException $e) {
		    $data['fb_exception'] = $e;
		    $user = null;
		  }
		}
		$data['user'] =$user;
		if(isset($_SESSION['email'])) //if email was set that means the person is signed into facebook and verified with the database
			redirect('browse'); //signed into fb and verified
		elseif(isset($_SESSION['fb'])){ //email not set, check to see if signed into fb
			if($this->verify_email($_SESSION['fb']['email'])){ //yes signed into fb
				redirect('browse');
			}
			else{ //signed into fb but email incorrect, notify user
				$data['error'] = "You not allowed.";
			}	
		}
		//got here means that they're not signed into fb, let them sign in in the view
		$this->load->view('facebook_login', $data);
	}

	function verify_email()
	{
		$this->load->model('admin_model');
		$verified = $this->admin_model->verify_user($_SESSION['fb']['email']);
        if($verified){//only insert the username variable if the email verifies.
            $_SESSION['email'] = $_SESSION['fb']['email'];
            return true; 
        }
        else{
        	return false;
        }
	}

	public function logout()
    {
      session_destroy();
      $this->load->view('facebook_login');
    }
}

?>