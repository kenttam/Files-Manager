<?php

class admin_model extends CI_Model {
	function __construct()
	{
		
   }

   public function verify_user($email)
   {
      $q = $this
            ->db
            ->where('email', $email)
            ->limit(1)
            ->get('users');

      if ( $q->num_rows > 0 ) {
         // person has account with us

         return true;

      }
      return false;
   }
}

