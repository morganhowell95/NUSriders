SELECT rt.placeIDA, rt.placeIDB, rd.rideID, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, COUNT(p.riderID) AS passengers, rd.capacity
FROM ride rd
LEFT JOIN route rt ON rt.routeID = rd.routeID
LEFT JOIN proposal p ON p.rideID = rd.rideID
LEFT JOIN users u ON u.id = rt.driverID
WHERE rd.startDT > NOW()
GROUP BY rt.latA, rt.lngA, rt.latB, rt.lngB, rt.placeIDA, rt.placeIDB, rd.startDT, rd.cost, rt.driverID, u.first_name, u.last_name, rd.capacity, rd.rideID
ORDER BY
DEGREES(ACOS(COS(RADIANS(rt.latA)) * COS(RADIANS(1)) *
COS(RADIANS(rt.lngA) - RADIANS(1)) +
SIN(RADIANS(rt.latA)) * SIN(RADIANS(1))))*22.209 +
DEGREES(ACOS(COS(RADIANS(rt.latB)) * COS(RADIANS(1)) *
COS(RADIANS(rt.lngB) - RADIANS(1)) +
SIN(RADIANS(rt.latB)) * SIN(RADIANS(1))))*22.209 +
ABS(EXTRACT(EPOCH FROM rd.startDT-NOW())/3600)
ASC;
