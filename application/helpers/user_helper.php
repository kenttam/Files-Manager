<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function match_email($user_email) {
	$active_emails = array('ktam39@gmail.com');

	if(in_array($user_email, $active_emails))
		return true;
	else
		return false;

} 
