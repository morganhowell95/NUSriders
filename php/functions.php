<?php

require_once 'User.php';
require_once 'connect.php';

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
	if(is_null($email) && is_null($password) && is_null($cookieID)) {

		//email and password will be used to verify and retreive user
	} elseif(!is_null($password) && !is_null($email) && is_null($cookieID)) {
		//query user for supplied email and password and verify existence
		$single_row = pg_query("SELECT * FROM users
										WHERE email = '{$email}'
										AND encrypted_password = '{$password}';");
		if(pg_num_rows($single_row) == 1) {
			//Cast fetched row to an associative array to harvest user info
			$single_row = pg_fetch_array($single_row, NULL, PGSQL_ASSOC);
			$current_user = new User($single_row['first_name'], $single_row['last_name'], $single_row['email']);
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
Remove characters to prevent sql injection
@param  txt:String  raw string to process
*/
function strip($txt) {
  return pg_escape_string(stripslashes(strip_tags($txt)));
}

?>