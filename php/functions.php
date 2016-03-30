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

function current_user($email=NULL, $password=NULL, $cookieID=NULL) {
	//If no parameters are passed, attempt to construct user from browser cooke
	if(is_null($email) && is_null($password) && is_null($cookieID)) {

	} elseif(!is_null($password) && !is_null($email)) {
		$hashed_pass = md5(strip($password));
		$email = strip($email);
		$single_row = pg_query("SELECT * FROM users
														WHERE email = '{$email}'
														AND encrypted_password = '{$hashed_pass}';");
		if(pg_num_rows($single_row) == 1) {
			return $single_row;
		} else {
			return NULL;
		}
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