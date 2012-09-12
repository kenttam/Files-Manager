<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --- Facebook Ignited ---
 * 
 * fb_appid		is the app id you recieved from dev panel
 * fb_secret	is the secret you recieved from dev panel
 * fb_canvas 	the value you put in 'Canvas Page' field in dev panel or the address of your app.
 * fb_apptype	set to either 'iframe' or 'connect' based on what platform your app is
 * 				is running on.
 * fb_auth		is the default authentications, '' is basic authentication
 */
$config['fb_appid']		= '133270333416553';
$config['fb_secret']	= 'd2c0872525c7cad161a4c7bfbcc31e7d';
$config['fb_canvas']	= 'http://localhost/test_bank/index.php/welcome';
$config['fb_apptype']	= 'connect';
$config['fb_auth']		= 'email';