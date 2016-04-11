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
  $pg_ownself = ($idArg == $idSs);
}else {
  header("Location : index.php");
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
  header("Location: userprofile.php?user=".current_user()->getUserId()."&pg_view=2");
}
// GET cancel a ride ----------------------------

$query = "";
if(!isset($_GET['pg_view']) || $_GET['pg_view']==1) {
  $query = "SELECT * FROM route WHERE driverID = {$idArg};";
}else if($_GET['pg_view'] == 2 || $_GET['pg_view'] == 3) {
  $query = "SELECT
    rtu.driverID,
    rtu.first_name,
    rtu.last_name,
    rd.startDT,
    rd.cost,
    rd.capacity,
    rd.routeID,
    rd.rideID,
    rtu.placeIDA, rtu.placeIDB,
    COUNT(pu.riderID) as passengers,
    ARRAY_AGG(pu.riderID) as riderIDs,
    ARRAY_AGG(pu.first_name) as riderfNames,
    ARRAY_AGG(pu.last_name) as riderlNames
  FROM ride rd
    LEFT JOIN
      (route rt
        LEFT JOIN
          users u
        ON u.id = rt.driverID
      ) rtu
    ON rtu.routeID = rd.routeID
    LEFT JOIN
      (proposal p
        LEFT JOIN
          users uu
        ON uu.id = p.riderID
      ) pu
    ON pu.rideID = rd.rideID
  GROUP BY
    rtu.driverID,
    rtu.first_name,
    rtu.last_name,
    rd.startDT,
    rd.cost,
    rd.capacity,
    rd.routeID,
    rd.rideID,
    rtu.placeIDA, rtu.placeIDB
  HAVING
    (
      ARRAY[{$idArg}] <@ ARRAY_AGG(pu.riderID) OR
      rtu.driverID = {$idArg}) ";
  if($_GET['pg_view']==3 && ($pg_ownself || current_user()->isAdmin())) {
    $query = $query . " AND rd.startDT < NOW()";
  }else {
    $query = $query . " AND rd.startDT > NOW()";
  }
  $query = $query . ";";
}else {
  header("Location : index.php");
}
$rows = json_encode(pg_fetch_all(pg_query($query)));
// load list data -------------------------------

if($row) {
  include 'views/userView.php';
}
?>
