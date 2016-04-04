<?php
require 'php/pgHeader.php';

require 'php/connect.php';
// connect to database
//detect if POST called or default load
$dt = $_POST['dt'];

$query = "SELECT
  rd.startDT > NOW() as lol,
  rtu.driverID,
  rtu.first_name,
  rtu.last_name,
  rd.startDT,
  rd.cost,
  rd.capacity,
  rd.routeID,
  rd.rideID,
  rtu.placeIDA, rtu.placeIDB,
  COUNT(p.riderID) as passengers,
  ARRAY_AGG(p.riderID) as riderIDs
FROM ride rd
  LEFT JOIN
    (route rt
      LEFT JOIN
        users u
      ON u.id = rt.driverID
    ) rtu
  ON rtu.routeID = rd.routeID
  LEFT JOIN
    proposal p
  ON p.rideID = rd.rideID
GROUP BY
  rtu.latA,
  rtu.latB,
  rtu.lngA,
  rtu.lngB,
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
  COUNT(p.riderID) < rd.capacity AND
  rd.startDT > NOW()
ORDER BY";

if(isset($_GET['latA']) && isset($_GET['latB']) && isset($_GET['lngA']) && isset($_GET['lngB'])) {
  $query = $query . " DEGREES(ACOS(COS(RADIANS(rtu.latA)) * COS(RADIANS({$_GET['latA']})) *
  COS(RADIANS(rtu.lngA) - RADIANS({$_GET['lngA']})) +
  SIN(RADIANS(rtu.latA)) * SIN(RADIANS({$_GET['latA']}))))*22.209 +
  DEGREES(ACOS(COS(RADIANS(rtu.latB)) * COS(RADIANS({$_GET['latB']})) *
  COS(RADIANS(rtu.lngB) - RADIANS({$_GET['lngB']})) +
  SIN(RADIANS(rtu.latB)) * SIN(RADIANS({$_GET['latB']}))))*22.209";
  // if distance deviation exists
  if(isset($_GET['dt'])) {
    $query = $query . " + ABS(EXTRACT(EPOCH FROM (rd.startDT-'{$_GET['dt']}'))/3600)";
  }
  // if time deviation exists
  $query = $query . " ASC;";
  // close query
}else {
  $query = $query . " rd.startDT ASC;";
  // query latest rides if no time/distance deviation
}

$rows = json_encode(pg_fetch_all(pg_query($query)));

include 'views/searchView.php';
// RENDER VIEW ----------------------------------------------------------------
?>
