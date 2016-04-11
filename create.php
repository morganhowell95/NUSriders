<?php
require 'php/pgHeader.php';
//PULL GET DATA IF ANY
$errmsg = "";
if(isset($_GET['idA'])) {
  $idSs = current_user()->getUserId();

  $row = pg_fetch_assoc(pg_query("SELECT *
    FROM route
    WHERE
      driverID = '{$idSs}' AND
      placeIDA = '{$_GET["idA"]}' AND
      placeIDB = '{$_GET["idB"]}';
    "));
  // check if route already exists

  if($row) {
    $errmsg = "route already exists!";
  }else {
    pg_query("INSERT INTO route
      VALUES(
        '{$_GET["idA"]}', '{$_GET["idB"]}',
        '{$_GET["latA"]}', '{$_GET["lngA"]}',
        '{$_GET["latB"]}', '{$_GET["lngB"]}',
        '{$idSs}');");
    header("Location: userprofile.php?user=".current_user()->getUserId());
  }
}
include 'views/createView.php';
?>
