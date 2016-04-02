<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database

/** id of user's page */
$idArg =  $_GET['user'];
/** id of session user */
$idSs = current_user()->getUserId();

$row = pg_fetch_assoc(pg_query("
  SELECT email, first_name, last_name, currency_amount
  FROM users
  WHERE id = '{$idArg}'
"));
// query if id is valid
if($row) {
  $pg_username = $row['first_name']. " " . $row['last_name'];
  $pg_currency = $row['currency_amount'];
  $pg_ownself = $idArg == $idSs;
}else {
  echo "<html>
  <body>
  invalid
  </body>
  </html>";
  //TODO 404
}
// validate user id from GET
$query = "";
if(!isset($_GET['pg_view']) || $_GET['pg_view']==1) {
  if($idArg == $idSs) {
    //10
    $query = "SELECT * FROM route WHERE driverID = {$idSs};";
  }else {
    //11
  }
}else if($_GET['pg_view']==2) {
  if($idArg == $idSs) {
    //20
  }else {
    //21
  }
}else if($_GET['pg_view']==3 && $pg_ownself || current_user()->isAdmin()) {
  //3
}else {
  //TODO 404
}
$rows = json_encode(pg_fetch_all(pg_query($query)));
//THERES no transaction detection.... ride complete detection... money transfer business....

if($row) {
  include 'views/userView.php';
}
?>
