<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NUSRiders - Login</title>
    <!-- META -->
    <link href="assets/css/layout.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/login.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/field.css" type="text/css" rel="stylesheet"/>
    <!-- STYLES -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- CDN IMPORTS -->
  </head>
  <body>
    <div class = "wrapper">
      <div class="loginBox">
      <div class="loginBox-greeter"><strong>NUSRiders</strong></div>
      <form action="login.php" method="post" accept-charset="utf-8">
  	    <div class="loginBox-fields">
  	        <input id = "f1" class="input login-field" type="text" name="first-name" placeholder="First Name"/>
  	        <input id = "f2" class="input login-field" type="text" name="last-name" placeholder="Last Name"/>
  	        <input id = "f3" class="input" type="email" name="username" placeholder="Email" required />
  	        <input id = "f4" class="input" type="password" name="password" placeholder="Password" required />
  	        <input id = "f5" class="input login-field" type="password" name="confirmed-password" placeholder="Confirm Password"/>
  	    </div>
  	    <div id="loginBox-error">
	        <?php
            if(isset($_SESSION['msg']['reg-err'])) {
              echo $_SESSION['msg']['reg-err'];
            }
          ?>
  	    </div>
  	    <strong><input id="loginBox-button" type="submit" name="submit" value="Login"/></strong>
  	    </form>
  	    <div id="forget-pass" class="loginBox-text">forget password?</div>
  	    <div id="reglogToggle" class="loginBox-text" data-login="true">Register</div>
  	  </div>
    </div>
  </body>
  <script src="assets/javascripts/login.js"></script>
</html>
