<?php 
define('INCLUDE_CHECK',true);

require 'php/functions.php';

session_name('NUSRiders');
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();

if(is_null(current_user())) {
	$_SESSION['msg']['reg-err'] = "Please login to access this resource.";
	header("Location: login.php");
}
// invalid entry without logging in
 ?>
