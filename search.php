<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database
//detect if POST called or default load
$dt = $_POST['dt'];
$query = "";
if(isset($_GET['from_id']) && isset($_GET['to_id']) && isset($_GET['dt'])) {
  $query ="SELECT rt.placeIDA, rt.placeIDB, rd.rideID, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, COUNT(p.riderID) AS passengers, rd.capacity
  FROM ride rd
  LEFT JOIN route rt ON rt.routeID = rd.routeID
  LEFT JOIN proposal p ON p.rideID = rd.rideID
  LEFT JOIN users u ON u.id = rt.driverID
  WHERE rt.driverID = {$idArg} OR p.riderID = {$idArg}
  GROUP BY rt.placeIDA, rt.placeIDB, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, rd.capacity, rd.rideID;
  ";
  //TODO sort by equation
}else {
  //TODO search all rides sort by latest
}

$rows = pg_fetch_all(pg_query($query));

include 'views/searchView.php';
// RENDER VIEW ----------------------------------------------------------------
?>
