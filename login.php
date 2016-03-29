<?php
define('INCLUDE_CHECK',true);

require 'php/connect.php';
require 'php/functions.php';

session_start();
$_SESSION = array();
// create session object

if(isset($_POST['submit'])) {
  $email = strip($_POST['email']);
  $password = md5(strip($_POST['password']));
  // parse user input

  if($_POST['submit'] == "Login") {
    $row = pg_fetch_assoc(pg_query("
      SELECT email, username, password
      FROM users
      WHERE email = '{$email}' AND password = '{$password}'
    "));
    // query if email password combo exists
    if($row['email']) {
    // user exists
      gotoApplication($row['username'], $email);
    }else {
    // wrong credentials
      $_SESSION['msg'] = "invalid email or password";
    }
    // LOGIN BUTTON EVENT -----------------------------------------------------
  }else if($_POST['submit'] == "Register") {
    $username = strip($_POST['name']);
    // parse user input
    $row = pg_fetch_assoc(pg_query("
      SELECT email, username, password
      FROM users
      WHERE email = '{$email}'
    "));
    // query if email already registered
    if(isset($row['email'])) {
    // user already exists
      $_SESSION['msg'] = "email is already registered";
    } else {
    // able to create new user
      pg_query("
        INSERT INTO users (email, username, currency, password)
        VALUES ('{$email}', '{$username}', '$50', '{$password}')");
      gotoApplication($username, $email);
    }
    // REGISTER BUTTON EVENT --------------------------------------------------
  }
}
// CONTROLLER
// ============================================================================

/*
Remove characters to prevent sql injection
@param  txt:String  raw string to process
*/
function strip($txt) {
  return pg_escape_string(stripslashes(strip_tags($txt)));
}

/*
Take arguments as session variables and go to main application
*/
function gotoApplication($usr, $eml) {
  $_SESSION['username'] = $usr;
  $_SESSION['email'] = $eml;
  // save session data
  header("Location: index.php");
  // go to application
}

// METHODS
// ============================================================================

include 'views/login.php';
// RENDER VIEW ----------------------------------------------------------------
?>