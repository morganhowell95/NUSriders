CREATE TABLE users (
id serial PRIMARY KEY,
email text NOT NULL UNIQUE,
first_name text NOT NULL DEFAULT '',
last_name text NOT NULL DEFAULT '',
currency_amount numeric NOT NULL DEFAULT 0,
admin boolean NOT NULL DEFAULT false,
regIP varchar(15) NOT NULL DEFAULT '',
encrypted_password varchar(64) NOT NULL DEFAULT '',
sign_in_count integer NOT NULL DEFAULT 1,
last_sign_in_at date,
prof_pic text
);

/*TODO: MAKE USER_SESSION_ID UNIQUE*/
/* Users may register multiple sessions that hold arbitrary amounts of data */
CREATE TABLE sessions (
	id bigint REFERENCES users ON DELETE CASCADE,
	user_session_id text NOT NULL UNIQUE,
	data text,
	created_at date,
	updated_at date,
	PRIMARY KEY (id, user_session_id)
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

CREATE TABLE route (
  placeIDA    varchar(28)   NOT NULL,
  placeIDB    varchar(28)   NOT NULL,
  latA        numeric       NOT NULL,
  lngA        numeric       NOT NULL,
  latB        numeric       NOT NULL,
  lngB        numeric       NOT NULL,
  driverID    integer       NOT NULL REFERENCES users (id) ON DELETE CASCADE,
  routeID     serial        PRIMARY KEY
);

CREATE TABLE ride (
  startDT     timestamp     NOT NULL,
  cost        numeric       NOT NULL,
  capacity    smallint      NOT NULL CHECK(capacity > 0),
  routeID     integer       NOT NULL REFERENCES route (routeID) ON DELETE CASCADE,
  rideID      serial        PRIMARY KEY
);

CREATE TABLE proposal (
  riderID     integer       NOT NULL REFERENCES users (id) ON DELETE CASCADE,
  rideID      integer       NOT NULL REFERENCES ride (rideID) ON DELETE CASCADE
);
