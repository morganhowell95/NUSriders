<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database

if(!isset($_GET['rid'])) header("Location: search.php");
// invalid entry without route id
$rid = $_GET['rid'];
$row = pg_fetch_assoc(pg_query("
  SELECT *
  FROM route
  WHERE routeid = '{$_GET["rid"]}'
"));
// query if id is valid
if($row) {
  $dat = json_encode($row);
  // encode data for js
}else {
  header("Location: search.php");
  // no such route id
}
if(isset($_GET['cost'])) {

  pg_query("INSERT INTO ride
    VALUES(
      '{$_GET["datetime"]}', '{$_GET["cost"]}',
      '{$_GET["capacity"]}', '{$_GET["rid"]}');");
  header("Location: user.php?user=".current_user()->getUserId()."&pg_view=2");
}

include 'views/offerView.php';
?>
