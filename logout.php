<?php
	require 'php/functions.php';

	//Still need sessions in logout to display flash messages
	session_name('NUSRiders');
	session_set_cookie_params(2*7*24*60*60);
	session_start();

	$user = current_user();
	if($user) {
		$user->deleteSessions();
		destroy_all_cookies_and_sessions();
	}
	$_SESSION['msg']['reg-success']='You have successfully logged out';
	header("Location: index.php");
?>