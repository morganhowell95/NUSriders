<?php


	include_once 'php/User.php';
	include_once 'php/connect.php';

function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

function send_mail($from,$to,$subject,$body)
{
	$headers = '';
	$headers .= "From: $from\n";
	$headers .= "Reply-to: $from\n";
	$headers .= "Return-Path: $from\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Date: " . date('r', time()) . "\n";

	mail($to,$subject,$body,$headers);
}

/*
Global helper function to provide various flexible ways of fetching the current user in the form
of an extensible User object.
@params (optional): email: user's sanitized email
										password: user's sanitized password
										cookieID: cookie signatue
*/
function current_user($email=NULL, $password=NULL, $cookieID=NULL) {
	//If no parameters are passed, attempt to construct user from browser cooke
	if(is_null($email) && is_null($password) && is_null($cookieID) && (isset($_SESSION['user-authenticated']) || isset($_COOKIE['user-authenticated']))) {

		//Fetch user instance from current cookie/session
		if(array_key_exists('user', $GLOBALS)) {
			return $GLOBALS['user'];
		} elseif(isset($_COOKIE['user-authenticated'])) {
			//query sessions table to find user based off cookie value
			$GLOBALS['user'] = User::genUserFromCookieID($_COOKIE['user-authenticated']);
		} elseif(isset($_SESSION['user-authenticated'])) {
			//query sessions table to find user based off session value
			$GLOBALS['user'] = User::genUserFromCookieID($_SESSION['user-authenticated']);
		} else {
			$GLOBALS['user'] = NULL;
		}
		return $GLOBALS['user'];
		//email and password will be used to verify and retreive user
	} elseif(!is_null($password) && !is_null($email) && is_null($cookieID)) {
		//query user for supplied email and password and verify existence
		$single_row = pg_query("SELECT * FROM users
										WHERE email = '{$email}'
										AND encrypted_password = '{$password}';");
		if(pg_num_rows($single_row) == 1) {
			//Cast fetched row to an associative array to harvest user info
			$single_row = pg_fetch_array($single_row, NULL, PGSQL_ASSOC);
			$current_user = User::getInstance($single_row['id'], $single_row['first_name'], $single_row['last_name'], $single_row['email'], $single_row['admin']);
			set_authenticated_cookie($current_user);
			$GLOBALS['user'] = $current_user;
			return $current_user;
		} else {
			return NULL;
		}
		//raw cookie signature has been passed to fetch the given user from corresponding sessions' table
	} else if(is_null($email) && is_null($password) && !is_null($cookieID)) {

	} else {
		return NULL;
	}
}


/*
Global helper function to create, verify, and authenticate users through third party platforms
*/
function userFromThirdPartyPlatform($user_info) {

	$user = NULL;
	$response = NULL;

	//returning user
	if(User::doesUserExistWithEmail($user_info['email'])) {
		//if auth token already exists under the user, authentication is already stored
		if(User::hasUserAuthenticatedInPast($user_info['uid'], $user_info['token'])) {
			$user = User::fetchUserFromToken($user_info['uid'], $user_info['token']);
			$response = "Welcome back {$user->getFirstName}!";
		}
		//otherwise user is authenticating with a new platform or device
		else {
			//we can safely fetch user because they've authenticated via oauth
			$user = User::addAuthenticationStrategyForUser($user_info['email'], $user_info['platform'], $user_info['uid'],
				$user_info['token']);
			$response = "Welcome back {$user->getFirstName()}!";
		}
	}
	//user is creating a new account from third-party provider
	//thus a new user and new authentication under that user must be created
	else {
		//create new user from platform API information utilizing the auth token
			$result = pg_query("INSERT INTO users(email, first_name, last_name, encrypted_password, regIP, last_sign_in_at)
					VALUES(
						'".$user_info['email']."',
						'".$user_info['first_name']."',
						'".$user_info['last_name']."',
						'".md5($user_info['token'])."',
						'".$_SERVER['REMOTE_ADDR']."',
						'".date("Y-m-d H:i:s")."'
					)");

			if(pg_affected_rows($result)==1) {
					//associate a new session with this user
					$user = User::addAuthenticationStrategyForUser($user_info['email'], $user_info['uid'],
						$user_info['token']);
					$response = "Congratulations - You have made a new account through a third-party provider. " . $user_info['first_name'];
			} else {
				$response = "Your third-party account has failed to synchronize.";
			} 
	}
	//user has successfully authenticated
	if(is_null($user)) {
		$_SESSION['msg']['reg-err'] = $response;
		return NULL;
	} else {
		$_SESSION['msg']['reg-success'] = $response;
		set_authenticated_cookie($user);
		return $user;
	}
}

/*
Remove characters to prevent sql injection
@param  txt:String  raw string to process
*/
function strip($txt) {
  return pg_escape_string(stripslashes(strip_tags($txt)));
}

/*
Given a user object, we can construct a cookie that lives persistently
in the browser to represent user validation and authentication
@param User object
*/
function set_authenticated_cookie($current_user) {
	$cookie_name = "user-authenticated";
	$cookie_value = $current_user->saveNewSession();
	$_SESSION['user-authenticated']= $cookie_value;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 900), "/");
}

/*
Effectively log out by destroying all client-side data and PHP global references to current user
*/
function destroy_all_cookies_and_sessions() {
	unset($_COOKIE["user-authenticated"]);
	unset($_SESSION["user-authenticated"]);
	$GLOBALS['user'] = NULL;
}

?>
