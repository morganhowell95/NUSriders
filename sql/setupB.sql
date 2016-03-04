
CREATE TABLE ROUTE (
  placeIDA    varchar(28)   NOT NULL,
  placeIDB    varchar(28)   NOT NULL,
  latA        numeric       NOT NULL,
  lngA        numeric       NOT NULL,
  latB        numeric       NOT NULL,
  lngB        numeric       NOT NULL,
  driverID    integer       NOT NULL REFERENCES users (id),
  routeID     serial        PRIMARY KEY
);
/* i didnt check if driverID has driver flag to true */

CREATE TABLE RIDE (
  startDT     timestamp     NOT NULL,
  cost        money         NOT NULL,
  capacity    smallint      NOT NULL CHECK(capacity > 0),
  status      smallint      NOT NULL CHECK(status IN (0, 1, 2)),
  routeID     integer       NOT NULL REFERENCES ROUTE (routeID),
  rideID      serial        PRIMARY KEY
);

CREATE TABLE PROPOSAL (
  riderID     integer       NOT NULL REFERENCES users (id),
  status      smallint      NOT NULL CHECK(status IN (0, 1, 2)),
  rideID      integer       NOT NULL REFERENCES RIDE (rideID)
);
/* note no cascading constraint is set, thus updating...
ROUTE has to update RIDE
RIDE has to update PROPOSAL
likewise for deletes */
/* note no sufficient currency check to apply proposal constraint is set */
