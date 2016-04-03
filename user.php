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
  invalids
  </body>
  </html>";
  //TODO 404
}
// validate user id from GET --------------------

if(isset($_GET['cancelid']) && $idArg == $idSs) {
  $did = pg_fetch_assoc(pg_query(
  "SELECT rt.driverid
  FROM route rt, ride rd
  WHERE rd.rideID = {$_GET['cancelid']}
  AND rd.routeID = rt.routeID;"))['driverid'];
  if($did == $idArg) {
    pg_query(
    "DELETE FROM ride
    WHERE rideid = {$_GET['cancelid']};");
    // delete own offer
  }else {
    pg_query(
    "DELETE FROM proposal
    WHERE rideid = {$_GET['cancelid']} AND riderid = {$did};");
    // delete proposal
  }
  header("Location: user.php?user=1&pg_view=2");
}
// GET cancel a ride ----------------------------

$query = "";
if(!isset($_GET['pg_view']) || $_GET['pg_view']==1) {
  if($idArg == $idSs) {
    //10
    $query = "SELECT * FROM route WHERE driverID = {$idArg};";
  }else {
    //11

  }
}else if($_GET['pg_view']==2) {
  if($idArg == $idSs) {
    //20
    $query ="SELECT rt.placeIDA, rt.placeIDB, rd.rideID, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, COUNT(p.riderID) AS passengers, rd.capacity
    FROM ride rd
    LEFT JOIN route rt ON rt.routeID = rd.routeID
    LEFT JOIN proposal p ON p.rideID = rd.rideID
    LEFT JOIN users u ON u.id = rt.driverID
    WHERE rt.driverID = {$idArg} OR p.riderID = {$idArg} AND rd.startDT > NOW()
    GROUP BY rt.placeIDA, rt.placeIDB, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, rd.capacity, rd.rideID;
    ";
    //WARNING NOW() uses time in postgres, if time is not the same as local
    // machine it will cause errors
  }else {
    //21
  }
}else if($_GET['pg_view']==3 && $pg_ownself || current_user()->isAdmin()) {
  //3
}else {
  //TODO 404
}
$rows = json_encode(pg_fetch_all(pg_query($query)));
// load list data -------------------------------

if($row) {
  include 'views/userView.php';
}
?>
