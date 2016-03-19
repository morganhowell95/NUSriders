<?php

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();
	
	// Destroy the session
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: demo.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checking whether the Login form has been submitted
	
	$err = array();
	// Will hold our errors
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';
	
	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		// Escaping all input data

		$row = mysql_fetch_assoc(mysql_query("SELECT id,email FROM users WHERE email='{$_POST['username']}' AND encrypted_password='".md5($_POST['password'])."'"));

		if($row['usr'])
		{
			// If everything is OK login
			
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			
			// Store some data in the session
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='Wrong username and/or password!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Save the error messages in the session

	header("Location: demo.php");
	exit;
}
?>

<!DOCTYPE html>
<html>

    <?php
        include 'php/html_partials.php';
        echo OpenHTMLDefaultApplication("Login");
        echo openGenNavBarHome();
    ?>

    <!-- Custom internals to nav bar, dependent on presence of session id -->
    <?php if(!isset($_SESSION["id"])): // If you are not logged in ?>

        <li> <a href="register.php" class="smoothScroll"> Register</a></li>

    <?php else: //if user is logged in ?>
      <li> <a href="profile.php" class="smoothScroll">Profile</a></li>
      <li> <a href="add_driver.php" class="smoothScroll"> Add Driver</a></li>
      <li class="divider"></li>
      <li> <a href="clear_sessions.php" class="smoothScroll"> Log Out</a></li>
    <!-- Generic function for closing the nav bar -->

    <?php 
    endif; 
    echo closeNavBar();
    ?>


<form class="clearfix" action="" method="post">

<?php

if($_SESSION['msg']['reg-err'])
{
	echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
	unset($_SESSION['msg']['reg-err']);
	// This will output the registration errors, if any
}

if($_SESSION['msg']['reg-success'])
{
	echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
	unset($_SESSION['msg']['reg-success']);
	// This will output the registration success message
}

?>


<div class="row">
  <div class="col-md-6 col-md-offset-3">

  	<div class="title-action">
		<h1>Member Login</h1>
		</div> 


    <div class="form-group">
      <label class="grey" for="username">Username:</label>
			<input class="field" type="text" name="username" id="username" value="" />
    </div>
     
    
      <div class="form-group">
				<label class="grey" for="password">Password:</label>
				<input class="field" type="password" name="password" id="password"  />
				<label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> Remember me</label>
      </div>
    
    <div class="form-group">
      <input type="submit" name="submit" value="Login" class="bt_login btn btn-primary" />
    </div>


    <p>New to NUS-Riders? <a href="register.php"> register here</a>  </p>

  </div>
</div>

</form>

<?php
define('INCLUDE_CHECK',true);

require 'php/connect.php';
require 'functions.php';

// Those two files can be included only if INCLUDE_CHECK is defined

session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();

	// Destroy the session
}

if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	header("Location: demo.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checking whether the Login form has been submitted

	$err = array();
	// Will hold our errors

	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';

	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];

		// Escaping all input data

		$row = mysql_fetch_assoc(mysql_query("SELECT id,usr FROM tz_members WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'"));

		if($row['usr'])
		{
			// If everything is OK login

			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];

			// Store some data in the session

			setcookie('tzRemember',$_POST['rememberMe']);
			// We create the tzRemember cookie
		}
		else $err[]='Wrong username and/or password!';
	}

	if($err)
		$_SESSION['msg']['login-err'] = implode('<br />',$err);
		// Save the error messages in the session

	header("Location: demo.php");
	exit;
} ?>