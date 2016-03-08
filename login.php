<!DOCTYPE html>
<html>

    <?php
        include 'php/html_partials.php';
        echo OpenHTMLDefaultApplication("Login");
    ?>



      <form method="post" action="index.html">
      	<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  					<div class="title-action">
					<h1>Login</h1>
					</div> 

  				<div class="form-group">
		        <p><input type="text" name="login" value="" placeholder="Username or Email"></p>
		    	</div>

		    	<div class="form-group">
		        <p><input type="password" name="password" value="" placeholder="Password"></p>
		    	</div>

		        <p class="remember_me">
		          <label>
		            <input type="checkbox" name="remember_me" id="remember_me">
		            Remember me on this computer
		          </label>
		        </p>

		        <div class="form-group">
		        <input  class ="btn btn-primary" type="submit" name="commit" value="Login">
		        </div>

		      </form>
		    
    		<p>New to Alescro?  <a href="/signup.php">Sign up now.</a></p>
		  </div>
		</div>


		<div class="row">
  <div class="col-md-6 col-md-offset-5">
    <div class="ss-belt center">
    	<a href="/Facebook"
    		<img src="assets/images/facebook-icon.png", alt= "Facebook Login", height="50", width="50", class="ss-icon", id="fb-auth">
    	</a>

    	<a href="/Google"
    		<img src="assets/images/googleicon.png", alt= "Google Login", height="50", width="50", class="ss-icon", id="go-auth">
    	</a>

    	<a href="/LinkedIn"
    		<img src="assets/images/linkedin-icon.png", alt= "LinkedIn Login", height="50", width="50", class="ss-icon", id="ln-auth">
    	</a>
    </div>
  </div>
</div>


	<?php
		echo closeHTMLDefaultApplication();
	?>

</html>