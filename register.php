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
	echo "GET ISSUED";
	GETTEDIT;
}
elseif($_POST['submit']=='Register')
{
	echo "POST ISSUED";
	POSTEDIT;
	// If the Register form has been submitted
	
	$err = array();
	
	if(strlen($_POST['username'])<3 || strlen($_POST['username'])>25)
	{
		$err[]='Your username must be between 3 and 25 characters!';
	}

	if(!checkEmail($_POST['username']))
	{
		$err[]='Your email is not valid!';
	}
	
	if(!count($err))
	{
		//Escape the input data to avoid SQL injection, using md5 to hash password
		$_POST['username'] = pg_escape_string($_POST['username']);
		$_POST['first-name'] = pg_escape_string($_POST['first-name']);
		$_POST['last-name'] = pg_escape_string($_POST['last-name']);
		$pass = pg_escape_string($_POST['password']);
		$isDriver = (!empty($_POST['driver']) ? 'true' : 'false');
	
		$result = pg_query("	INSERT INTO users(email, first_name, last_name, driver, encrypted_password, regIP, last_sign_in_at)
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
		}
		else
		{
			$err[]='This username is already taken!';
		} 
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
		header("Location: register.php");
	}	
	else 
	{
		header("Location: index.php");
	}

	exit();
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

if(isset($_SESSION['msg']['reg-err']))
{
	echo '<div class="alert alert-danger">'.$_SESSION['msg']['reg-err'].'</div>';
	unset($_SESSION['msg']['reg-err']);
	// This will output the registration errors, if any
}

if(isset($_SESSION['msg']['reg-success']))
{
	echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
	//unset($_SESSION['msg']['reg-success']);
	// This will output the registration success message
}

?>


<div class="row">
  <div class="col-md-6 col-md-offset-3">

	  	<div class="title-action">
			<h1>Not a member yet? Sign Up!</h1>
			</div> 

			<div class="form-group">
	      <label class="grey" for="first-name">First Name:</label>
				<input class="field" type="text" name="first-name" id="first-name" value="" />
	    </div>

	    <div class="form-group">
	      <label class="grey" for="username">Last Name:</label>
				<input class="field" type="text" name="last-name" id="last-name" value="" />
	    </div>

	    <div class="form-group">
	      <label class="grey" for="username">Email:</label>
				<input class="field" type="text" name="username" id="username" value="" />
	    </div>
	     
      <div class="form-group">
				<label class="grey" for="password">Password:</label>
				<input class="field" type="password" name="password" id="password"  />
				<label><input name="driver" id="driver" type="checkbox" value="1" /> Are you a Driver?</label>
      </div>
    
    <div class="form-group">
      <input type="submit" name="submit" value="Register" class="btn btn-primary" />
    </div>

  </div>
</div>

</form>


<?php
    require_once 'php/html_partials.php';
    echo closeHTMLDefaultApplication();
?>