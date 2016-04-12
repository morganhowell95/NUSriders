<?php
require 'php/connect.php';
require 'php/functions.php';


session_name('NUSRiders');
// Starting the session
session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();

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
	
		$result = pg_query("INSERT INTO users(email, first_name, last_name, encrypted_password, regIP, last_sign_in_at)
						VALUES(
							'".$_POST['username']."',
							'".$_POST['first-name']."',
							'".$_POST['last-name']."',
							'".md5($pass)."',
							'".$_SERVER['REMOTE_ADDR']."',
							'".date("Y-m-d H:i:s")."'
						)");

		if(pg_affected_rows($result)==1)
		{
			$_SESSION['msg']['reg-success']='Congratulations on making a new account!';
			$user = current_user($_POST['username'], md5($pass));
			set_authenticated_cookie($user);
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
			set_authenticated_cookie($user);
			$_SESSION['msg']['reg-success']="Welcome back {$user->firstName}!";
		}

		if(count($err)) {
			$_SESSION['msg']['reg-err'] = implode('<br />', $err);
			header("Location: login.php");
		}	else {
			unset($_SESSION['msg']['reg-err']);
			header("Location: index.php");
		}


}
//must render template after headers are set
include 'views/login.php';
?>