<!DOCTYPE html>
<html>
    <?php
    	//Use internal template rendering engine to produce opening HTML body and add custom
    	//css and js files
      include 'php/html_partials.php';
      echo OpenHTMLDefaultApplication("Login", NULL,
      	'<link href="assets/css/login.css" type="text/css" rel="stylesheet"/>',
      	'<script src="assets/javascripts/login.js"></script>');
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

    <div class="loginBox">
    <div class="loginBox-greeter">NUSRiders</div>
    <form action="login.php" method="post" accept-charset="utf-8">

    	<?php
    		//FLASH TO USERS RELEVANT SUCCESS/ERROR MESSAGES

					if(isset($_SESSION['msg']['reg-err']))
					{
						echo '<div class="alert alert-danger">'.$_SESSION['msg']['reg-err'].'</div>';
						unset($_SESSION['msg']['reg-err']);
					}

					if(isset($_SESSION['msg']['reg-success']))
					{
						echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
						unset($_SESSION['msg']['reg-success']);
					}
			?>

	     <div class="loginBox-fields">

	        <input class="input hidden login-field" type="text" name="first-name" placeholder="First Name"/>
	        <input class="input hidden login-field" type="text" name="last-name" placeholder="Last Name"/>
	        <input class="input" type="email" name="email" placeholder="Email" required />
	        <input class="input" type="password" name="password" placeholder="Password" required />
	        <input class="input hidden login-field" type="password" name="confirmed-password" placeholder="Confirm Password"/>

	      </div>
	      <div id="loginBox-error">
	        <?php if(isset($_SESSION['msg'])) echo $_SESSION['msg']; ?>
	      </div>
	      <input id="loginBox-button" type="submit" name="submit" value="Login &#9658;"/>
	    </form>
	    <div id="forget-pass" class="loginBox-text">forget password?</div>
	    <div id="reglogToggle" class="loginBox-text" data-login="true">Register</div>
	  </div>

<?php
	require_once 'php/html_partials.php';
	echo closeHTMLDefaultApplication();
?>