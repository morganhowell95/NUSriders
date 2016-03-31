<?php

define('INCLUDE_CHECK',true);

require 'php/connect.php';
require 'php/functions.php';


// Those two files can be included only if INCLUDE_CHECK is defined


session_name('NUSRiders');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

// if($_SESSION['id'] && !isset($_COOKIE['NUSRiders']) && !$_SESSION['rememberMe'])
// {
// 	// If you are logged in, but you don't have the NUSRiders cookie (browser restart)
// 	// and you have not checked the rememberMe checkbox:

// 	$_SESSION = array();
// 	session_destroy();
// 	// Destroy the session
// }

if(empty($_POST))
{

} elseif($_POST['submit']=='Register')
{

	//Server-side validation and DB constraint violation indication
	$err = array();
	
	if($_POST['password'] != $_POST['confirmed-password']) 
	{
		$err[] = 'Your passwords do not match!';
	}

	if(strlen($_POST['username'])<3 || strlen($_POST['username'])>25)
	{
		$err[] = 'Your username must be between 3 and 25 characters!';
	}

	if(!checkEmail($_POST['username']))
	{
		$err[] = 'Your email is not valid!';
	}
	
	if(!count($err))
	{
		//Escape the input data to avoid SQL injection, using md5 to hash password
		$_POST['username'] = strip($_POST['username']);
		$_POST['first-name'] = strip($_POST['first-name']);
		$_POST['last-name'] = strip($_POST['last-name']);
		$pass = strip($_POST['password']);
		$isDriver = (!empty($_POST['driver']) ? 'true' : 'false');
	
		$result = pg_query("INSERT INTO users(email, first_name, last_name, driver, encrypted_password, regIP, last_sign_in_at)
						VALUES(
							'".$_POST['username']."',
							'".$_POST['first-name']."',
							'".$_POST['last-name']."',
							'".$isDriver."',
							'".md5($pass)."',
							'".$_SERVER['REMOTE_ADDR']."',
							'".date("Y-m-d H:i:s")."'
						)");

		if(pg_affected_rows($result)==1)
		{
			$_SESSION['msg']['reg-success']='Congratulations on making a new account!';
		} else
		{
			$err[] = 'This username is already taken!';
		} 
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />', $err);
		header("Location: login.php");
	}	else {
		header("Location: index.php");
	}

	exit();
} elseif($_POST['submit']=='Login') {
		//Server-side validation and DB constraint violation indication
		$err = array();

		$_POST['username'] = strip($_POST['username']);
		$_POST['password'] = md5(strip($_POST['password']));
		//helper method within helper_functions.php that returns object representing current user
		$user = current_user($_POST['username'], $_POST['password']);

		if(is_null($user)) {
			$err[] = 'Username/Password is incorrect!';
		} else {
			$_SESSION['msg']['reg-success']="Welcome back {$user->firstName}!";
			//TODO: set cookie and sessions to this user
		}

		if(count($err)) {
			$_SESSION['msg']['reg-err'] = implode('<br />', $err);
			header("Location: login.php");
		}	else {
			unset($_SESSION['msg']['reg-err']);
			header("Location: index.php");
		}


}
include 'views/login.php';
?>