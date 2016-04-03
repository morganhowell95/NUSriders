<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database
//detect if POST called or default load

$dt = $_POST['dt'];
$query = "";
if(isset($_GET['latA']) && isset($_GET['latB']) && isset($_GET['lngA']) && isset($_GET['lngB'])) {
  $query ="SELECT rt.placeIDA, rt.placeIDB, rd.rideID, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, COUNT(p.riderID) AS passengers, rd.capacity
  FROM ride rd
  LEFT JOIN route rt ON rt.routeID = rd.routeID
  LEFT JOIN proposal p ON p.rideID = rd.rideID
  LEFT JOIN users u ON u.id = rt.driverID
  WHERE rd.startDT > NOW()
  GROUP BY rt.placeIDA, rt.placeIDB, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, rd.capacity, rd.rideID
  ORDER BY
  DEGREES(ACOS(COS(RADIANS(rt.latA)) * COS(RADIANS({$_GET['latA']})) *
  COS(RADIANS(rt.lngA) - RADIANS({$_GET['lngA']})) +
  SIN(RADIANS(rt.latA)) * SIN(RADIANS({$_GET['latA']}))))*22.209 +
  DEGREES(ACOS(COS(RADIANS(rt.latB)) * COS(RADIANS({$_GET['latB']})) *
  COS(RADIANS(rt.lngB) - RADIANS({$_GET['lngB']})) +
  SIN(RADIANS(rt.latB)) * SIN(RADIANS({$_GET['latB']}))))*22.209";

  if(isset($_GET['dt'])) {
    $query = $query . " + ABS(EXTRACT(EPOCH FROM rd.startDT-{$_GET['dt']})/3600)";
  }
  // if time deviation exists
  $query = $query . " ASC;";
  // close query
}else {
  $query ="SELECT rt.placeIDA, rt.placeIDB, rd.rideID, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, COUNT(p.riderID) AS passengers, rd.capacity
  FROM ride rd
  LEFT JOIN route rt ON rt.routeID = rd.routeID
  LEFT JOIN proposal p ON p.rideID = rd.rideID
  LEFT JOIN users u ON u.id = rt.driverID
  WHERE rd.startDT > NOW()
  GROUP BY rt.placeIDA, rt.placeIDB, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, rd.capacity, rd.rideID
  ORDER BY rd.startDT ASC;";
  // query latest rides
}

$rows = json_encode(pg_fetch_all(pg_query($query)));

include 'views/searchView.php';
// RENDER VIEW ----------------------------------------------------------------
?>
