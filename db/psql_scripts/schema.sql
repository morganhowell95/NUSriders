CREATE TABLE users (
id serial PRIMARY KEY,
email text NOT NULL UNIQUE,
first_name text NOT NULL DEFAULT '',
last_name text NOT NULL DEFAULT '',
currency_amount money NOT NULL DEFAULT 0,
admin boolean NOT NULL DEFAULT false,
driver boolean NOT NULL,
rider boolean NOT NULL,
regIP varchar(15) NOT NULL DEFAULT '',
encrypted_password varchar(64) NOT NULL DEFAULT '',
sign_in_count integer NOT NULL DEFAULT 1,
last_sign_in_at date,
prof_pic text
);

/* Users may register multiple sessions that hold arbitrary amounts of data */
CREATE TABLE sessions (
	id bigint REFERENCES users ON DELETE CASCADE,
	user_session_number integer NOT NULL DEFAULT 1,
	data text,
	created_at date,
	updated_at date,
	PRIMARY KEY (id, user_session_number)
);

/* User may add multiple auth tokens to be remembered for sign in, including platforms such as:
	Facebook, Linkedin, and Google */
CREATE TABLE authentications (
	id bigint REFERENCES users on DELETE CASCADE,
	provider text,
	uid text UNIQUE,
	token text,
	created_at date,
	PRIMARY KEY (id, uid)
);

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