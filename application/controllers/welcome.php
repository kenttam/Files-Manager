<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        
        // The fb_ignited library is already auto-loaded so call the user and app.
        parse_str($_SERVER['QUERY_STRING'],$getArr);
        $_REQUEST['state']=$getArr['state'];
        $_REQUEST['code']=$getArr['code']; 
        $this->fb_me = $this->fb_ignited->fb_get_me();      
        $this->fb_app = $this->fb_ignited->fb_get_app();
        
        // This is a Request System I made to be used to work with Facebook Ignited.
        // NOTE: This is not mandatory for the system to work.
        /*if ($this->input->get('request_ids'))
        {
            $requests = $this->input->get('request_ids');
            $this->request_result = $this->fb_ignited->fb_accept_requests($requests);
        }*/
        $this->load->model('admin_model');
        if(isset($this->fb_me['email'])){
            $verified = $this->admin_model->verify_user($this->fb_me['email']);
            if($verified){//only insert the username variable if the email verifies.
                $_SESSION['username'] = $this->fb_me['email']; 
            }
        }        
    }

    function index()
    {           
       /* $content_data['fb_app'] = $this->fb_app;
        if (isset($this->request_result))
        {
            $content_data['error'] = $this->request_result;
        }
        if (isset($_SESSION['username']))
        {
            //redirect('browse'); //redirects user if the variable was set which means logged in and verified.
        }
        else
        {
            if(isset($this->fb_me['email'])){
                $content_data['email'] = $this->fb_me['email']; //pass in the email to tell user the email was not verified.
            }
        }
        $content_data['link'] = $this->fb_ignited->fb_login_url();
        $this->load->view('welcome_message', $content_data);
        //$content_data['fb_app'] = $this->fb_app;*/
    }
    
    function callback()
    {
        // This method will include the facebook credits system.
        $content_data['message'] = $this->fb_ignited->fb_process_credits();
        $this->load->view('fb_credits_view', $content_data);
    }

    public function logout()
   {
      session_destroy();
      $content_data['fb_app'] = $this->fb_app;
      $content_data['link'] = $this->fb_ignited->fb_login_url();
      $this->load->view('welcome_message', $content_data);
   }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
//          'appId'  => '133270333416553',
//            'secret' => 'd2c0872525c7cad161a4c7bfbcc31e7d'