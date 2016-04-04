SELECT
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
  COUNT(p.riderID) as riders,
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
ORDER BY
DEGREES(ACOS(COS(RADIANS(rt.latA)) * COS(RADIANS({$_GET['latA']})) *
COS(RADIANS(rt.lngA) - RADIANS({$_GET['lngA']})) +
SIN(RADIANS(rt.latA)) * SIN(RADIANS({$_GET['latA']}))))*22.209 +
DEGREES(ACOS(COS(RADIANS(rt.latB)) * COS(RADIANS({$_GET['latB']})) *
COS(RADIANS(rt.lngB) - RADIANS({$_GET['lngB']})) +
SIN(RADIANS(rt.latB)) * SIN(RADIANS({$_GET['latB']}))))*22.209;
/*
+  ABS(EXTRACT(EPOCH FROM (rd.startDT-'{$_GET['dt']}'))/3600)
*/
